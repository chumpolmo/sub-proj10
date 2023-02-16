<?php
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

closeConDB($conn);
?>