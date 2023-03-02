<?php
session_start();

include '../libs/config.inc.php';
include '../libs/functions.php';
include '../tpls/header_proc.php';

$conn = connectDB();

if(isset($_POST['act']) && $_POST['act'] == 'REGIS'){
	$usrEmail = testInput($_POST['usrEmail']);
	$usrPwd = testInput($_POST['usrPwd']);
	$usrType = $_POST['usrType'];

	$sql = "INSERT INTO user (User_ID, User_Email, User_Password, User_Fullname, User_Type, User_Active, User_Added, User_Updated) ";
	$sql.= "VALUES (NULL, \"$usrEmail\", \"$usrPwd\", \"\", $usrType, false, NOW(), '0000-00-00 00:00:00')";
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">ผลการลงทะเบียน</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if (!$result) {
		echo '<p>การลงทะเบียนสมาชิกเกิดข้อผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'รอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="3; url=../register.php">';
	}else{
		echo '<p>การลงทะเบียนสมาชิกเรียบร้อย กรุณารอการยืนยันจากผู้ดูแลระบบ ภายใน 30 นาที<br>';
		echo 'กรณีที่ไม่สามารถเข้าใช้งานระบบ หลังจาก 30 นาที กรุณาติดต่อที่ '._ADMIN_EMAIL.'<br>';
		echo 'รอสักครู่...<a href="../index.php" class="w3-button w3-yellow">กลับหน้าแรก</a></p>';
		echo '<meta http-equiv="refresh" content="10; url=../index.php">';
	}
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
} // Register

if(isset($_POST['act']) && $_POST['act'] == 'ADDUSR'){
	$usrEmail = testInput($_POST['usrEmail']);
	$usrPwd = testInput($_POST['usrPwd']);
	$usrFullname = testInput($_POST['usrFullname']);
	$usrType = $_POST['usrType'];
	$usrActive = $_POST['usrActive'];

	$sql = "INSERT INTO user (User_ID, User_Email, User_Password, User_Fullname, User_Type, User_Active, User_Added, User_Updated) ";
	$sql.= "VALUES (NULL, \"$usrEmail\", \"$usrPwd\", \"$usrFullname\", $usrType, $usrActive, NOW(), '0000-00-00 00:00:00')";
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">การเพิ่มข้อมูลผู้ใช้งาน</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if (!$result) {
		echo '<p>การเพิ่มข้อมูลผู้ใช้งานผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="2; url=../auths/user_form.php">';
	}else{
		echo '<p>การเพิ่มข้อมูลผู้ใช้งานสำเร็จ กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="2; url=../auths/user_info.php">';
	}
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
} // Add new user

if(isset($_POST['act']) && $_POST['act'] == 'USRUPD'){
	$usrFullname = testInput($_POST['usrFullname']);
	$usrType = $_POST['usrType'];
	$usrActive = $_POST['usrActive'];

	$sql = "UPDATE user SET User_Fullname='".$usrFullname."', ";
	$sql.= "User_Type=$usrType, User_Active=$usrActive, ";
	$sql.= "User_Updated=NOW() WHERE User_Id=".$_POST['user_id'];
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">การอัปเดตข้อมูลผู้ใช้งาน</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if (!$result) {
		echo '<p>การอัปเดตข้อมูลผู้ใช้งานผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="1; url=../auths/user_form.php">';
	}else{
		echo '<p>การอัปเดตข้อมูลผู้ใช้งานสำเร็จ กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="1; url=../auths/user_info.php">';
	}
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
} // Update user

if(isset($_GET['act']) && $_GET['act'] == 'USRDEL'){
	$usrId = testInput($_GET['user_id']);
	$sql = "DELETE FROM user WHERE User_Id=$usrId";
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">การลบข้อมูลผู้ใช้งาน</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if (!$result) {
		echo '<p>การลบข้อมูลผู้ใช้งานผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="1; url=../auths/user_info.php">';
	}else{
		echo '<p>การลบข้อมูลผู้ใช้งานสำเร็จ กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="1; url=../auths/user_info.php">';
	}
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
} // Delete user

if(isset($_POST['act']) && $_POST['act'] == 'LOGIN'){
	$usrEmail = testInput($_POST['usrEmail']);
	$usrPwd = testInput($_POST['usrPwd']);
	$sql = "SELECT * FROM user WHERE (User_Email LIKE \"".$usrEmail."\" AND User_Password LIKE \"".$usrPwd."\" AND User_Active = 1)";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$_SESSION['sessLoggedIn'] = true;
		$_SESSION['sessUserId'] = $row['User_ID'];
		$_SESSION['sessUserEmail'] = $row['User_Email'];
		$_SESSION['sessUserType'] = $row['User_Type'];
		echo '<br><div class="w3-container">';
		echo '<div class="w3-card w3-border w3-pale-yellow">';
		echo '<div class="w3-center w3-padding-64">';
		echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">คุณเข้าสู่ระบบสำเร็จ</span>';
		echo '</div>';
		echo '<div class="w3-center w3-container">';
		echo '<p>กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="3; url=../auths/index.php">';
		echo '<br><br></div>';
		echo '</div>';
		echo '</div>';
	} else {
	  	$_SESSION['sessLoggedIn'] = false;
	  	$_SESSION['sessUserId'] = "";
		$_SESSION['sessUserEmail'] = "";
		$_SESSION['sessUserType'] = "";
		session_destroy();
		echo '<br><div class="w3-container">';
		echo '<div class="w3-card w3-border w3-pale-yellow">';
		echo '<div class="w3-center w3-padding-64">';
		echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">คุณเข้าสู่ระบบไม่สำเร็จ</span>';
		echo '</div>';
		echo '<div class="w3-center w3-container">';
		echo '<p>กรุณาเข้าสู่ระบบใหม่อีกครั้ง รอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="3; url=../index.php">';
		echo '<br><br></div>';
		echo '</div>';
		echo '</div>';
	}
}

if(isset($_GET['act']) &&  $_GET['act'] == 'LOGOUT'){
	$_SESSION['sessLoggedIn'] = false;
	$_SESSION['sessUserId'] = "";
	$_SESSION['sessUserEmail'] = "";
	$_SESSION['sessUserType'] = "";
	session_destroy();
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">คุณออกจากระบบสำเร็จ</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	echo '<p>กรุณารอสักครู่...</p>';
	echo '<meta http-equiv="refresh" content="3; url=../index.php">';
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
}

if(isset($_POST['act']) &&  $_POST['act'] == 'UPPROF'){
	$usrFullname = testInput($_POST['usrFullname']);
	$sql = "UPDATE user SET User_Fullname=\"".$usrFullname."\" WHERE (User_Email LIKE \"".$_SESSION['sessUserEmail']."\" AND User_Active = 1)";
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">ผลการแก้ไขข้อมูล</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if (!$result) {
		echo '<p>การแก้ไขข้อมูลเกิดข้อผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="3; url=../auths/user_setting.php">';
	}else{
		echo '<p>การแก้ไขข้อมูลเรียบร้อย<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="3; url=../auths/user_profile.php">';
	}
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
}

if(isset($_POST['act']) &&  $_POST['act'] == 'UPPWD'){
	$usrPwdNew = testInput($_POST['usrPwdNew']);
	$sql = "UPDATE user SET User_Password=\"".$usrPwdNew."\" WHERE (User_Email LIKE \"".$_SESSION['sessUserEmail']."\" AND User_Active = 1)";
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">ผลการเปลี่ยนรหัสผ่าน</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if (!$result) {
		echo '<p>การเปลี่ยนรหัสผ่านเกิดข้อผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="3; url=../auths/user_setting.php">';
	}else{
		echo '<p>การเปลี่ยนรหัสผ่านเรียบร้อย<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="3; url=../auths/user_profile.php">';
	}
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
}

if(isset($_POST['act']) == 'ADDRES' && $_POST['act'] == 'ADDRES'){
	$resPrefix = $_POST['resPrefix'];
	$resName = testInput($_POST['resName']);
	$resSurname = testInput($_POST['resSurname']);
	$resAge = testInput($_POST['resAge']);
	$resSex = $_POST['resSex'];
	$resPhone = testInput($_POST['resPhone']);
	$resEmail = testInput($_POST['resEmail']);
	$resAddress = testInput($_POST['resAddress']);
	$resNote = testInput($_POST['resNote']);
	$occId = $_POST['Occ_ID'];
	$sql = "INSERT INTO resume (Res_ID, Res_Prefix, Res_Name, Res_Surname, Res_Age, Res_Sex, Res_Phone, Res_Email, Res_Address, Res_Note, Res_Added, Res_Updated, Occ_ID, User_ID) ";
	$sql.= "VALUES (NULL, $resPrefix, \"$resName\", \"$resSurname\", \"$resAge\", $resSex, \"$resPhone\", \"$resEmail\", \"$resAddress\", \"$resNote\", NOW(), NOW(), $occId, ";
	$sql.= $_SESSION['sessUserId'].")";
	//echo $sql;
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">ผลการฝากประวัติ</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if (!$result) {
		echo '<p>การฝากประวัติเกิดข้อผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="3; url=../auths/resume.php">';
	}else{
		echo '<p>คุณฝากประวัติสำเร็จ<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="3; url=../auths/resume.php">';
	}
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
}

if(isset($_POST['act']) == 'UPRES' && $_POST['act'] == 'UPRES'){
	$resPrefix = $_POST['resPrefix'];
	$resName = testInput($_POST['resName']);
	$resSurname = testInput($_POST['resSurname']);
	$resAge = testInput($_POST['resAge']);
	$resSex = $_POST['resSex'];
	$resPhone = testInput($_POST['resPhone']);
	$resEmail = testInput($_POST['resEmail']);
	$resAddress = testInput($_POST['resAddress']);
	$resNote = testInput($_POST['resNote']);
	$occId = $_POST['Occ_ID'];
	$sql = "UPDATE resume SET Res_Prefix=$resPrefix, Res_Name='".$resName."', Res_Surname='".$resSurname."', ";
	$sql.= "Res_Age=".$resAge.", Res_Sex=".$resSex.", Res_Phone='".$resPhone."', Res_Email='".$resEmail."', ";
	$sql.= "Res_Address='".$resAddress."', Res_Note='".$resNote."', Res_Updated=NOW(), ";
	$sql.= "Occ_ID=$occId WHERE Res_ID=".$_POST['Res_ID'];
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">การปรับปรุงประวัติ</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if (!$result) {
		echo '<p>การปรับปรุงประวัติเกิดข้อผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="3; url=../auths/resume.php">';
	}else{
		echo '<p>คุณปรับปรุงประวัติสำเร็จ<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="3; url=../auths/resume.php">';
	}
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
}

if(isset($_GET['act']) == 'APPLYNOW' && $_GET['act'] == 'APPLYNOW'){
	$job_id = $_GET['job_id'];
	$sql = "SELECT * FROM resume WHERE User_ID=".$_SESSION['sessUserId'];
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">ผลการสมัครงาน</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$sql_jr = "INSERT INTO jobs_resume (Job_ID, Res_ID, JobRes_Status, Apply_Date, Accept_Date) ";
		$sql_jr.= "VALUES($job_id, ".$row['Res_ID'].", 10, NOW(), '0000-00-00 00:00:00');"; // สมัครงาน
		$res_jr = $conn->query($sql_jr);
		if($res_jr){
			echo '<p>การสมัครงานสำเร็จ กรุณารอการตอบรับจากผู้รับสมัคร<br>';
			echo 'กรุณารอสักครู่...</p>';
			echo '<meta http-equiv="refresh" content="3; url=../auths/aj_history.php">';
		}else{
			echo '<p>การสมัครงานพบข้อผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
			echo 'กรุณารอสักครู่...</p>';
			echo '<meta http-equiv="refresh" content="3; url=../auths/applyjob.php">';
		}
	}else{
		echo '<p>กรุณาฝากประวัติก่อนดำเนินการสมัครงาน ตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="3; url=../auths/resume.php">';
	}
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
}

if(isset($_GET['act']) && $_GET['act'] == 'RESCAN'){
	$job_id = $_GET['job_id'];
	$res_id = $_GET['res_id'];

	$sql_log = "INSERT INTO logs_jobs_resume (Job_ID, Res_ID, JobRes_Status, JobRes_Note, JobRes_Date) ";
	$sql_log.= "VALUES($job_id, $res_id, 30, 'ยกเลิกการสมัครงาน', NOW())";
	$res_log = $conn->query($sql_log);

	$sql = "DELETE FROM jobs_resume WHERE Job_ID=".$job_id." AND Res_ID=".$res_id;
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">การยกเลิกการสมัครงาน</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if ($result) {
		echo '<p>การยกเลิกการสมัครงานสำเร็จ<br>';
		echo 'กรุณารอสักครู่...</p>';
	}else{
		echo '<p>กรุณาฝากประวัติก่อนดำเนินการสมัครงาน ตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
	}
	echo '<meta http-equiv="refresh" content="3; url=../auths/applyjob.php">';
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
} // Resume Cancel

if(isset($_GET['act']) && $_GET['act'] == 'USRACTIVE'){
	$user_id = $_GET['user_id'];
	$user_active = $_GET['user_active'];
	$sql = "UPDATE user SET User_Active=$user_active WHERE User_ID=".$user_id;
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">การอัปเดตการเปิดใช้งานผู้ใช้</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if ($result) {
		echo '<p>การอัปเดตการเปิดใช้งานผู้ใช้สำเร็จ<br>';
		echo 'กรุณารอสักครู่...</p>';
	}else{
		echo '<p>การอัปเดตการเปิดใช้งานผู้ใช้ผิดพลาด ตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
	}
	echo '<meta http-equiv="refresh" content="2; url=../auths/user_info.php">';
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
} // Update User Active

if(isset($_POST['act']) && $_POST['act'] == 'NEWSADD'){
	$err = "";
	$newsTitle = testInput($_POST['newsTitle']);
	$newsDesc = testInput($_POST['newsDesc']);
	//$newsPhoto = testInput($_POST['newsPhoto']);

	/****/
	$target_dir = "../figs/news_figs/";
	$target_file_old = $target_dir . basename($_FILES["newsPhoto"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file_old,PATHINFO_EXTENSION));
	$target_file = $target_dir . "news_".date("YmdHis").".".$imageFileType;

	// Check if image file is a actual image or fake image
	if(isset($_POST["act"])) {
	  $check = getimagesize($_FILES["newsPhoto"]["tmp_name"]);
	  if($check !== false) {
	    $err = "File is an image - " . $check["mime"] . ".<br>";
	    $uploadOk = 1;
	  } else {
	    $err = "File is not an image.<br>";
	    $uploadOk = 0;
	  }
	}

	// Check if file already exists
	if (file_exists($target_file)) {
	  $err.= "Sorry, file already exists.<br>";
	  $uploadOk = 0;
	}

	// Check file size: 2M
	if ($_FILES["newsPhoto"]["size"] > 2000000) {
	  $err.= "Sorry, your file is too large.<br>";
	  $uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
	  $err.= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
	  $uploadOk = 0;
	}

	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">การเพิ่มข้อมูลข่าว</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	  	$err.= "Sorry, your file was not uploaded.<br>";
		echo '<p>การอัปโหลดไฟล์ผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>'.$err;
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="2; url=../auths/news_form.php">';
	// if everything is ok, try to upload file
	} else {
	  	if (move_uploaded_file($_FILES["newsPhoto"]["tmp_name"], $target_file)) {
			$sql = "INSERT INTO news (News_ID, News_Title, News_Description, News_Photo, News_Added, News_Updated, User_ID) ";
			$sql.= "VALUES (NULL, \"$newsTitle\", \"$newsDesc\", \"$target_file\", NOW(), '0000-00-00 00:00:00', ".$_SESSION['sessUserId'].")";
			$result = $conn->query($sql);
			if (!$result) {
				echo '<p>การเพิ่มข้อมูลข่าวผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
				echo 'กรุณารอสักครู่...</p>';
				echo '<meta http-equiv="refresh" content="2; url=../auths/news_form.php">';
			}else{
				echo '<p>การเพิ่มข้อมูลข่าวสำเร็จ กรุณารอสักครู่...</p>';
				echo '<meta http-equiv="refresh" content="2; url=../auths/news_info.php">';
			}
	  	} else {
	    	echo '<p>การอัปโหลดไฟล์ผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>'.$err;
			echo 'กรุณารอสักครู่...</p>';
			echo '<meta http-equiv="refresh" content="2; url=../auths/news_form.php">';
	  	}
	}
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
	/****/
} // Add news

if(isset($_GET['act']) && $_GET['act'] == 'NEWSDEL'){
	$news_id = $_GET['news_id'];

	$sql_pho = "SELECT N.News_Photo FROM news AS N WHERE News_ID=".$news_id;
	$res_pho = $conn->query($sql_pho);
	$row_pho = $res_pho->fetch_assoc();

	$sql = "DELETE FROM news WHERE News_ID=".$news_id;
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">การลบข้อมูลข่าว</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if ($result) {
		unlink($row_pho['News_Photo']);
		echo '<p>การลบข้อมูลข่าวสำเร็จ<br>';
		echo 'กรุณารอสักครู่...</p>';
	}else{
		echo '<p>การลบข้อมูลข่าวผิดพลาด ตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
	}
	echo '<meta http-equiv="refresh" content="2; url=../auths/news_info.php">';
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
} // Delete news

if(isset($_GET['act']) && $_GET['act'] == 'LOGSCLEAR'){
	$sql = "DELETE FROM logs_jobs_resume";
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">การเคลียร์ประวัติดำเนินการ</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if ($result) {
		unlink($row_pho['News_Photo']);
		echo '<p>การเคลียร์ประวัติดำเนินการสำเร็จ<br>';
		echo 'กรุณารอสักครู่...</p>';
	}else{
		echo '<p>การเคลียร์ประวัติดำเนินการผิดพลาด ตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
	}
	echo '<meta http-equiv="refresh" content="2; url=../auths/logs_info.php">';
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
} // Clear logs

if(isset($_POST['act']) == 'FARMADD' && ($_POST['act'] == 'FARMADD' || $_POST['act'] == 'FARMUPD')){
	$txt = "เพิ่ม";
	$farmName = testInput($_POST['farmName']);
	$farmDesc = testInput($_POST['farmDesc']);
	$farmType = testInput($_POST['farmType']);
	$farmPhone = testInput($_POST['farmPhone']);
	$farmEmail = testInput($_POST['farmEmail']);
	$farmAddr = testInput($_POST['farmAddr']);
	$farmLoc = testInput($_POST['farmLoc']);
	$farmNote = testInput($_POST['farmNote']);
	$usrId = $_SESSION['sessUserId'];
	if($_POST['act'] == 'FARMUPD'){
		$txt = "แก้ไข";
		$farmId = testInput($_POST['farm_id']);
		$sql = "UPDATE farm SET Farm_Name=\"$farmName\", Farm_Description=\"$farmDesc\", Farm_Type=$farmType, Farm_Note=\"$farmNote\", Farm_Email=\"$farmEmail\", Farm_Phone=\"$farmPhone\", Farm_Address=\"$farmAddr\", Farm_Location=\"$farmLoc\", Farm_Updated=NOW() WHERE Farm_ID=".$farmId;
	}else{
		$sql = "INSERT INTO farm (Farm_ID, Farm_Name, Farm_Description, Farm_Type, Farm_Note, Farm_Email, Farm_Phone, Farm_Address, Farm_Location, Farm_Added, Farm_Updated, User_ID) ";
		$sql.= "VALUES (NULL, \"$farmName\", \"$farmDesc\", $farmType, \"$farmNote\", \"$farmEmail\", \"$farmPhone\", \"$farmAddr\", \"$farmLoc\", NOW(), '0000-00-00 00:00:00', $usrId)";
	}
	//echo $sql;
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">การ'.$txt.'ข้อมูลฟาร์ม</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if (!$result) {
		echo '<p>การ'.$txt.'ข้อมูลฟาร์มผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="2; url=../auths/farm_form.php">';
	}else{
		echo '<p>การ'.$txt.'ข้อมูลฟาร์มสำเร็จ<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="2; url=../auths/farm_info.php">';
	}
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
} // Add new and update farm

if(isset($_GET['act']) == 'FARMDEL' && $_GET['act'] == 'FARMDEL'){
	$txt = "ลบ";
	$farmId = testInput($_GET['farm_id']);
	$sql = "DELETE FROM farm WHERE Farm_ID=".$farmId;
	//echo $sql;
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">การ'.$txt.'ข้อมูลฟาร์ม</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if (!$result) {
		echo '<p>การ'.$txt.'ข้อมูลฟาร์มผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
	}else{
		echo '<p>การ'.$txt.'ข้อมูลฟาร์มสำเร็จ<br>';
		echo 'กรุณารอสักครู่...</p>';
	}
	echo '<meta http-equiv="refresh" content="2; url=../auths/farm_info.php">';
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
} // Delete farm

if(isset($_POST['act']) == 'PRODADD' && ($_POST['act'] == 'PRODADD' || $_POST['act'] == 'PRODUPD')){
	$txt = "เพิ่ม";
	$act = $_POST['act'];
	$proTitle = testInput($_POST['proTitle']);
	$proDesc = testInput($_POST['proDesc']);
	$proPhoto = testInput($_POST['proPhotoTmp']);
	$proQuan = testInput($_POST['proQuan']);
	$proUnit = testInput($_POST['proUnit']);
	$proPpu = testInput($_POST['proPpu']);
	$proMonth = testInput($_POST['proMonth']);
	$proYear = testInput($_POST['proYear']);
	$proCont = testInput($_POST['proCont']);
	$farmId = testInput($_POST['farm_id']);
	$usrId = $_SESSION['sessUserId'];

	/******/
	if(isset($_FILES["proPhoto"]["name"]) && !empty($_FILES["proPhoto"]["name"])){
		$target_dir = "../figs/prod_figs/";
		$target_file_old = $target_dir . basename($_FILES["proPhoto"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file_old,PATHINFO_EXTENSION));
		$proPhoto = $target_dir . "prod_".date("YmdHis").".".$imageFileType;

		// Check if image file is a actual image or fake image
		if(isset($_POST["act"])) {
		  $check = getimagesize($_FILES["proPhoto"]["tmp_name"]);
		  if($check !== false) {
		    $err = "File is an image - " . $check["mime"] . ".<br>";
		    $uploadOk = 1;
		  } else {
		    $err = "File is not an image.<br>";
		    $uploadOk = 0;
		  }
		}

		// Check if file already exists
		if (file_exists($proPhoto)) {
		  $err.= "Sorry, file already exists.<br>";
		  $uploadOk = 0;
		}

		// Check file size: 2M
		if ($_FILES["proPhoto"]["size"] > 2000000) {
		  $err.= "Sorry, your file is too large.<br>";
		  $uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		  $err.= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
		  $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		  	$err.= "Sorry, your file was not uploaded.<br>";
			echo '<p>การอัปโหลดไฟล์ผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>'.$err;
			echo 'กรุณารอสักครู่...</p>';
			echo '<meta http-equiv="refresh" content="2; url=../auths/product_form.php">';
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["proPhoto"]["tmp_name"], $proPhoto)) {
				$err.= 'การอัปโหลดไฟล์สำเร็จ<br>';
			}else{
				echo '<p>การอัปโหลดไฟล์ผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>'.$err;
				echo 'กรุณารอสักครู่...</p>';
				echo '<meta http-equiv="refresh" content="2; url=../auths/product_form.php">';
			}
		}
	} // Check empty input file

	/******/
	if($_POST['act'] == 'PRODUPD'){
		$txt = "แก้ไข";
		$farmId = testInput($_POST['farm_id']);
		$proId = testInput($_POST['pro_id']);
		$sql = "UPDATE product SET Pro_Title=\"$proTitle\", Pro_Description=\"$proDesc\", Pro_Photo=\"$proPhoto\", Pro_Quantity=\"$proQuan\", Pro_Unit=\"$proUnit\", Pro_PricePU=\"$proPpu\", Pro_Month=\"$proMonth\", Pro_Year=\"$proYear\", Pro_Contact=\"$proCont\", Pro_Updated=NOW() WHERE Pro_ID=".$proId;
	}else{
		if(empty($proPhoto)) $proPhoto = "../figs/prod_figs/default.png";
		$sql = "INSERT INTO product (Pro_ID, Pro_Title, Pro_Description, Pro_Photo, Pro_Quantity, Pro_PricePU, Pro_Month, Pro_Year, Pro_Unit, Pro_Contact, Pro_Added, Pro_Updated, Farm_ID) ";
		$sql.= "VALUES (NULL, \"$proTitle\", \"$proDesc\", \"$proPhoto\", \"$proQuan\", \"$proPpu\", \"$proMonth\", \"$proYear\", \"$proUnit\", \"$proCont\", NOW(), '0000-00-00 00:00:00', $farmId)";
	}
	//echo $sql;
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">การ'.$txt.'ข้อมูลผลผลิต</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if (!$result) {
		echo '<p>การ'.$txt.'ข้อมูลผลผลิตผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="2; url=../auths/product_form.php?act='.$act.'&farm_id='.$farmId.'">';
	}else{
		echo '<p>การ'.$txt.'ข้อมูลผลผลิตสำเร็จ<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="2; url=../auths/farm_product.php?act=PRODADD&farm_id='.$farmId.'">';
	}
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
} // Add new product

if(isset($_GET['act']) == 'PRODDEL' && $_GET['act'] == 'PRODDEL'){
	$txt = "ลบ";
	$farmId = testInput($_GET['farm_id']);
	$proId = testInput($_GET['pro_id']);

	$sql_pho = "SELECT P.Pro_Photo FROM product AS P WHERE Pro_ID=".$proId;
	$res_pho = $conn->query($sql_pho);
	$row_pho = $res_pho->fetch_assoc();

	$sql = "DELETE FROM product WHERE Pro_ID=".$proId;
	//echo $sql;
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">การ'.$txt.'ข้อมูลผลผลิต</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if (!$result) {
		echo '<p>การ'.$txt.'ข้อมูลผลผลิตผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
	}else{
		unlink($row_pho['Pro_Photo']);
		echo '<p>การ'.$txt.'ข้อมูลผลผลิตสำเร็จ<br>';
		echo 'กรุณารอสักครู่...</p>';
	}
	echo '<meta http-equiv="refresh" content="2; url=../auths/farm_product.php?act=PRODADD&farm_id='.$farmId.'">';
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
} // Delete product

if(isset($_POST['act']) == 'JOBADD' && ($_POST['act'] == 'JOBADD' || $_POST['act'] == 'JOBUPD')){
	$txt = "เพิ่ม";
	$act = $_POST['act'];
	$jobTitle = testInput($_POST['jobTitle']);
	$jobDesc = testInput($_POST['jobDesc']);
	$jobSalary = testInput($_POST['jobSalary']);
	$jobPhone = testInput($_POST['jobPhone']);
	$jobNote = testInput($_POST['jobNote']);
	$jobStatus = testInput($_POST['jobStatus']);
	$farmId = testInput($_POST['farmId']);
	$occId = testInput($_POST['occId']);

	/******/
	if($_POST['act'] == 'JOBUPD'){
		$txt = "แก้ไข";
		$jobId = testInput($_POST['job_id']);
		$sql = "UPDATE jobs SET Job_Title=\"$jobTitle\", Job_Description=\"$jobDesc\", Job_Salary=\"$jobSalary\", Job_Phone=\"$jobPhone\", Job_Note=\"$jobNote\", Job_Status=\"$jobStatus\", Farm_ID=\"$farmId\", Job_Updated=NOW() WHERE Job_ID=".$jobId;

		$sql_occ = "UPDATE jobs_occupation SET Occ_ID=$occId WHERE Job_ID=".$jobId;
	}else{
		$sql = "INSERT INTO jobs (Job_ID, Job_Title, Job_Description, Job_Salary, Job_Phone, Job_Note, Job_Status, Job_Added, Job_Updated, Farm_ID) ";
		$sql.= "VALUES (NULL, \"$jobTitle\", \"$jobDesc\", \"$jobSalary\", \"$jobPhone\", \"$jobNote\", \"$jobStatus\", NOW(), '0000-00-00 00:00:00', $farmId)";
	}
	//echo $sql;
	$result = $conn->query($sql);

	if($_POST['act'] == 'JOBADD'){
		$sql_tmp = "SELECT LAST_INSERT_ID() AS tmpId";
		$res_tmp = $conn->query($sql_tmp);
		$row_tmp = $res_tmp->fetch_assoc();

		$sql_occ = "INSERT INTO jobs_occupation (Job_ID, Occ_ID) VALUES (".$row_tmp['tmpId'].", $occId)";
	}

	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">การ'.$txt.'ประกาศจ้างงาน</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if (!$result) {
		echo '<p>การ'.$txt.'ประกาศจ้างงานผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="2; url=../auths/job_form.php?act='.$act.'&job_id='.$jobId.'">';
	}else{
		$res_occ = $conn->query($sql_occ);
		echo '<p>การ'.$txt.'ประกาศจ้างงานสำเร็จ<br>';
		echo 'กรุณารอสักครู่...</p>';
		echo '<meta http-equiv="refresh" content="2; url=../auths/job_info.php">';
	}
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
} // Add new and update job

if(isset($_GET['act']) == 'JOBDEL' && $_GET['act'] == 'JOBDEL'){
	$txt = "ลบ";
	$jobId = testInput($_GET['job_id']);

	$sql = "DELETE FROM jobs_occupation WHERE Job_ID=".$jobId;
	$result = $conn->query($sql);
	echo '<br><div class="w3-container">';
	echo '<div class="w3-card w3-border w3-pale-yellow">';
	echo '<div class="w3-center w3-padding-64">';
	echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">การ'.$txt.'ประกาศจ้างงาน</span>';
	echo '</div>';
	echo '<div class="w3-center w3-container">';
	if (!$result) {
		echo '<p>การ'.$txt.'ประกาศจ้างงานผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'กรุณารอสักครู่...</p>';
	}else{
		$sql = "DELETE FROM jobs WHERE Job_ID=".$jobId;
		$result = $conn->query($sql);
		echo '<p>การ'.$txt.'ประกาศจ้างงานสำเร็จ<br>';
		echo 'กรุณารอสักครู่...</p>';
	}
	echo '<meta http-equiv="refresh" content="2; url=../auths/job_info.php">';
	echo '<br><br></div>';
	echo '</div>';
	echo '</div>';
} // Delete job
?>