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
	}else if($j == 30){
		return "ยกเลิกการสมัครงาน";
	}else if($j == 40){
		return "ยกเลิกการจ้างงาน";
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

function getPaging($type, $nr, $pp, $key, $farm=null){
		echo '<div class="w3-container">';
		echo '<div class="w3-center">';
		echo '<div class="w3-bar w3-border-bottom w3-border-left w3-border-right">';
		echo '<div class="w3-bar-item w3-button">หน้า</div>';
		$nop = ceil($nr / $pp);
		if($nop < 1){
			$nop = 1;
		}
		$pagenum = 1;
		if ($pagenum < 1) {
			$pagenum = 1;
		}
		else if ($pagenum > $nop) {
			$pagenum = $nop;
		}
		for($p = 0; $p < $nop; $p++){
		  if($pagenum == ($p+1))
	  		echo '<div class="w3-bar-item w3-button">'.($p+1).'</div>';
	  	  else
	  		echo '<a class="w3-bar-item w3-button" onclick="getData('.$type.', '.($p+1).','.($p * $pp).',\''.$key.'\')">'.($p+1).'</a>';
	  	}
		echo '</div></div>';
		echo '</div>';
}

function getFarmType($j){
	if($j == 10){
		return "ขนาดเล็ก (ไม่เกิน 10 ไร่)";
	}else if($j == 20){
		return "ขนาดกลาง (ตั้งแต่ 10 - 30 ไร่)";
	}else if($j == 30){
		return "ขนาดใหญ่ (30 ไร่ ขึ้นไป)";
	}
}

function testInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>