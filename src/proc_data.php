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

if(isset($_POST['act']) == 'APPLYNOW' && $_POST['act'] == 'APPLYNOW'){
}
?>