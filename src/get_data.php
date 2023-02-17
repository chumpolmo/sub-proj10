<?php
include '../libs/config.inc.php';
include '../libs/functions.php';

$conn = connectDB();

if($_POST['type'] == 1){
	$sql = "SELECT * FROM product LIMIT 0,5";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
	    echo "<li><a href='prod_description.php?act=GET&pro_id=".$row["Pro_ID"]."' style='text-decoration: none;'>".$row["Pro_Title"]."</a></li>";
	  }
	} else {
	  echo "<li>ไม่มีข้อมูล</li>";
	}
}

if($_POST['type'] == 2){
	$sql = "SELECT * FROM jobs ORDER BY Job_Added DESC LIMIT 0,5";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
	    echo "<li><a href='job_description.php?act=APPLY&job_id=".$row["Job_ID"]."' style='text-decoration: none;'>".$row["Job_Title"]."</a></li>";
	  }
	} else {
	  echo "<li>ไม่มีข้อมูล</li>";
	}
}

if($_POST['type'] == 3){
	$sql = "SELECT count(Res_ID) AS Res_Num1 FROM resume";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	echo "{\"apply\":".$row['Res_Num1'].",";

	$sql = "SELECT count(Res_ID) AS Res_Num2 FROM resume WHERE Res_Status=20";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	echo "\"accept\":".$row['Res_Num2'].",";

	$sql = "SELECT count(Farm_ID) AS Farm_Num FROM farm";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	echo "\"farm\":".$row['Farm_Num'].",";

	$sql = "SELECT count(Pro_ID) AS Prod_Num FROM product";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	echo "\"prod\":".$row['Prod_Num']."}";
}

if($_POST['type'] == 4){
	$st = $_POST['st'];
	$end = $_POST['end'];

	$sql = "SELECT J.Job_ID, J.Job_Title, F.Farm_Name FROM jobs AS J INNER JOIN farm AS F ON J.Farm_ID=F.Farm_ID LIMIT $st,$end";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
    	echo '<div class="w3-col l4 m4 w3-pale-yellow w3-container w3-padding-16 w3-border-left w3-border-bottom">';
    	echo '<div class="w3-container">';
   	 	echo '<p><b>ตำแหน่ง: '.$row['Job_Title'].'</b><br>';
   	 	echo 'หน่วยงาน: '.$row['Farm_Name'].'</p>';
    	echo '<a href="job_description.php?act=APPLY&job_id='.$row['Job_ID'].'" class="w3-button w3-yellow w3-right">สมัครงาน</a>';
    	echo '</div></div>';
	  }
	} else {
    	echo '<div class="w3-col l4 m4 w3-pale-yellow w3-container w3-padding-16 w3-border-left w3-border-bottom">';
    	echo '<div class="w3-container">';
   	 	echo '<p>ไม่มีข้อมูล</p>';
    	echo '</div></div>';
	}
}


if($_POST['type'] == 41){
	$sql = "SELECT J.*, F.*, U.User_Fullname FROM jobs AS J ";
	$sql.= "INNER JOIN farm AS F ON J.Farm_ID=F.Farm_ID AND Job_ID=".$_POST['job_id']." ";
	$sql.= "INNER JOIN user AS U ON F.User_ID=U.User_ID";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

  echo '<h5><i class="fa fa-vcard"></i> ตำแหน่งงาน: '.$row['Job_Title'].'</h5>';
  echo '<table class="w3-table-all w3-hoverable">';
  echo '<tr class="w3-khaki"><th colspan="2">รายละเอียดงานรับสมัคร</th><th colspan="2">หน่วยงานรับสมัคร</th></tr>';
  echo '</td><th>ตำแหน่งงาน</th><td>'.$row['Job_Title'].'</td><th>ชื่อหน่วยงาน</th><td>'.$row['Farm_Name'].'</td></tr>';
  echo '<tr><th>รายละเอียดงาน</th><td>'.$row['Job_Description'].'</td><th>รายละเอียด</th><td>'.$row['Farm_Description'].'</td></tr>';
  echo '<tr><th>ค่าจ้างต่อเดือน</th><td>'.$row['Job_Salary'].'</td><th>ข้อมูลติดต่อ</th><td>'.$row['Farm_Address'].$row['Farm_Email'].$row['Farm_Phone'].'</td></tr>';
  echo '<tr><th>ติดต่องาน</th><td>'.$row['Job_Phone'].'</td><td></td><td></td></tr>';
  echo '<tr><th>หมายเหตุ</th><td>'.$row['Job_Note'].'</td><td></td><td></td></tr>';
  echo '<tr><th>สถานะตำแหน่งงาน</th><td>'.getJobStatus($row['Job_Status']).'</td><td></td><td></td></tr>';
  echo '<tr><th>เริ่มเผยแพร่</th><td>'.$row['Job_Added'].'</td><td></td><td></td></tr>';
  echo '<tr><th>ปรับปรุงล่าสุด</th><td>'.$row['Job_Updated'].'</td><td></td><td></td></tr>';
	echo '<tr><th>ผู้เผยแพร่ข้อมูล</th><td>'.$row['User_Fullname'].'</td><td></td><td></td></tr>';
  echo '<tr><td colspan="4"><div class="w3-button w3-right w3-green"><a href="applynow.php?act=APPLYNOW&job_id='.$row['Job_ID'].'"><i class="fa fa-paper-plane"></i> ยืนยันการสมัครงาน</a></div></td></tr>';
  echo '</table>';
}

if($_POST['type'] == 5){
	$st = $_POST['st'];
	$end = $_POST['end'];

	$sql = "SELECT P.Pro_ID, P.Pro_Photo, P.Pro_Title FROM product AS P LIMIT $st,$end";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
    	echo '<div class="w3-col l4 m4 w3-pale-yellow w3-container w3-padding-16 w3-border-right w3-border-bottom">';
    	echo '<a href="prod_description.php?act=GET&pro_id='.$row["Pro_ID"].'" style="text-decoration: none;">';
      echo '<img src="figs/'.$row['Pro_Photo'].'" title="'.$row['Pro_Title'].'" style="width:100%;">';
      echo '<div class="w3-container w3-center">';
      echo '<p>'.$row['Pro_Title'].'</p>';
      echo '</div></a>';
    	echo '</div>';
	  }
	} else {
    	echo '<div class="w3-col l4 m4 w3-pale-yellow w3-container w3-padding-16 w3-border-left w3-border-bottom">';
    	echo '<div class="w3-container">';
   	 	echo '<p>ไม่มีข้อมูล</p>';
    	echo '</div></div>';
	}
}

if($_POST['type'] == 6){
	$sql = "SELECT P.*, U.User_ID, U.User_Fullname FROM product AS P INNER JOIN user AS U ON P.User_ID=U.User_ID AND Pro_ID=".$_POST['pro_id'];
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

  echo '<h5><i class="fa fa-shopping-cart"></i> ชื่อผลิตภัณฑ์: '.$row['Pro_Title'].'</h5>';
  echo '<table class="w3-table-all w3-hoverable">';
  echo '<tr><td rowspan="7" width="40%"><img src="figs/'.$row['Pro_Photo'].'" style="width:100%;">';
  echo '</td><th>รายละเอียด</th><td>'.$row['Pro_Description'].'</td></tr>';
  echo '<tr><th>จำนวน</th><td>'.$row['Pro_Quantity'].' '.$row['Pro_Unit'].'</td></tr>';
  echo '<tr><th>ราคาต่อหน่วย</th><td>'.$row['Pro_PricePU'].' '._THB.'</td></tr>';
  echo '<tr><th>สนใจผลิตภัณฑ์ติดต่อ</th><td>'.$row['Pro_Contact'].'</td></tr>';
  echo '<tr><th>เริ่มเผยแพร่</th><td>'.$row['Pro_Added'].'</td></tr>';
  echo '<tr><th>ปรับปรุงล่าสุด</th><td>'.$row['Pro_Updated'].'</td></tr>';
	echo '<tr><th>ผู้เผยแพร่ผลิตภัณฑ์</th><td>'.$row['User_Fullname'].'</td></tr>';
  echo '</table>';
}

closeConDB($conn);
?>