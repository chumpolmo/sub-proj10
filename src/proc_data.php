<?php
include '../libs/config.inc.php';
include '../libs/functions.php';

$conn = connectDB();

if($_POST['act'] == 'REGIS'){
	$usrEmail = testInput($_POST['usrEmail']);
	$usrPwd = testInput($_POST['usrPwd']);
	$usrType = $_POST['usrType'];
	$sql = "INSERT INTO user (User_ID, User_Email, User_Password, User_Fullname, User_Type, User_Active, User_Added, User_Updated) ";
	$sql.= "VALUES (NULL, \"$usrEmail\", \"$usrPwd\", \"\", $usrType, false, NOW(), NOW())";
	$result = $conn->query($sql);
	if (!$result) {
		echo 'การสมัครสมาชิกเกิดข้อผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง<br>';
		echo 'รอสักครู่...';
		echo '<meta http-equiv="refresh" content="3; url=../register.php">';
	}else{
		echo 'การสมัครสมาชิกเรียบร้อย กรุณารอการยืนยันจากผู้ดูแลระบบ ภายใน 30 นาที<br>';
		echo 'กรณีที่ไม่สามารถเข้าใช้งานระบบ หลังจาก 30 นาที กรุณาติดต่อที่ '._ADMIN_EMAIL.'<br>';
		echo 'รอสักครู่...';
		echo '<meta http-equiv="refresh" content="5; url=../index.php">';
	}
}

if($_POST['act'] == 'APPLYNOW'){
}
?>