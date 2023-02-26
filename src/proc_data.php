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
	$sql.= "VALUES (NULL, \"$usrEmail\", \"$usrPwd\", \"\", $usrType, false, NOW(), NOW())";
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
}

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
	$resName = testInput($_POST['resName']);
	$resSurname = testInput($_POST['resSurname']);
	$resAge = testInput($_POST['resAge']);
	$resPhone = testInput($_POST['resPhone']);
	$resEmail = testInput($_POST['resEmail']);
	$resAddress = testInput($_POST['resAddress']);
	$resNote = testInput($_POST['resNote']);
	$resStatus = $_POST['resStatus'];
	$occId = $_POST['Occ_ID'];
	$sql = "INSERT INTO resume (Res_ID, Res_Name, Res_Surname, Res_Age, Res_Phone, Res_Email, Res_Address, Res_Note, Res_Status, Res_Added, Res_Updated, Occ_ID, User_ID) ";
	$sql.= "VALUES (NULL, \"$resName\", \"$resSurname\", \"$resAge\", \"$resPhone\", \"$resEmail\", \"$resAddress\", \"$resNote\", $resStatus, NOW(), NOW(), $occId, ";
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
	$resName = testInput($_POST['resName']);
	$resSurname = testInput($_POST['resSurname']);
	$resAge = testInput($_POST['resAge']);
	$resPhone = testInput($_POST['resPhone']);
	$resEmail = testInput($_POST['resEmail']);
	$resAddress = testInput($_POST['resAddress']);
	$resNote = testInput($_POST['resNote']);
	$resStatus = $_POST['resStatus'];
	$occId = $_POST['Occ_ID'];
	$sql = "UPDATE resume SET Res_Name='".$resName."', Res_Surname='".$resSurname."', ";
	$sql.= "Res_Age=".$resAge.", Res_Phone='".$resPhone."', Res_Email='".$resEmail."', ";
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
		$sql_jr = "INSERT INTO jobs_resume (Job_ID, Res_ID, JobRes_Status, JobRes_Note) ";
		$sql_jr.= "VALUES($job_id, ".$row['Res_ID'].", 10, '')"; // รอตรวจสอบข้อมูล
		$res_jr = $conn->query($sql_jr);
		if($res_jr){
			$sql_r = "UPDATE resume SET Res_Status=20, Res_Updated=NOW() WHERE Res_ID=".$row['Res_ID']; // สมัครงาน
			$res_r = $conn->query($sql_r);
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
?>