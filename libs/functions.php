<?php
function connectDB(){
	$servername = "xxx";
	$username = "xxx";
	$password = "xxx";
	$database = "xxx";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);

	$conn->query("SET sql_mode = 'allow_invalid_dates'");

	// Check connection
	if ($conn->connect_error) {
  		die("Connection failed: " . $conn->connect_error);
	}
	return $conn;
}

function closeConDB($conn){
	$conn->close();	
}

function getJobStatus($j){
	if($j == 10){
		return "เปิดรับคนทำงาน";
	}else if($j == 20){
		return "ปิดรับคนทำงาน";
	}
}

function getUsrStatus($j){
	if($j == 1){
		return "ผู้ดูแลระบบ";
	}else if($j == 2){
		return "เจ้าของฟาร์ม";
	}else if($j == 3){
		return "ผู้สมัครงาน";
	}
}

function getActiveStatus($j){
	if($j == 1){
		return "Active";
	}else{
		return "Inactive";
	}
}

function getResStatus($j){
	if($j == 10){
		return "ฝากประวัติ";
	}else if($j == 20){
		return "สมัครงาน";
	}else if($j == 30){
		return "ได้งานทำ";
	}
}

function getJobResStatus($j){
	if($j == 10){
		return "สมัครงาน";
	}else if($j == 20){
		return "ตอบรับเข้าทำงาน";
	}
}

function getPrefix($j){
	if($j == 1){
		return "นาย";
	}else if($j == 2){
		return "นางสาว";
	}else if($j == 3){
		return "นาง";
	}
}

function getSex($j){
	if($j == 1){
		return "ผู้ชาย";
	}else if($j == 2){
		return "ผู้หญิง";
	}else if($j == 3){
		return "ไม่ระบุ";
	}
}

function testInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>