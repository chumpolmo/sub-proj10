<?php
session_start();

include '../libs/config.inc.php';
include '../libs/functions.php';

$conn = connectDB();

if($_POST['type'] == 1){
	$sql = "SELECT * FROM product ORDER BY Pro_Added DESC LIMIT 0,5";
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
	$key = "";
	$cond = "";
	if(isset($_POST['key']) && !empty($_POST['key'])){
		$key = $_POST['key'];
		$cond = "AND (J.Job_Title LIKE \"%$key%\" OR J.Job_Description LIKE \"%$key%\" OR J.Job_Note LIKE \"%$key%\")";
	}
	if(isset($_POST['pagenum'])){
		$pagenum = $_POST['pagenum'];
	}
	$st = $_POST['st'];

	$sql = "SELECT J.Job_ID, J.Job_Title, F.Farm_Name FROM jobs AS J INNER JOIN farm AS F ON J.Farm_ID=F.Farm_ID $cond LIMIT $st, "._PER_PAGE_1;
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  echo '<div class="w3-container">';
	  echo '<i class="fa fa-info-circle"></i> จำนวน '.$result->num_rows.' รายการ';
	  echo '</div>';
	  echo '<div class="w3-container">';
	  while($row = $result->fetch_assoc()) {
    	echo '<div class="w3-col l4 m4 w3-pale-yellow w3-container w3-padding-16 w3-border-left w3-border-bottom">';
    	echo '<div class="w3-container">';
   	 	echo '<p><b>ตำแหน่ง: '.$row['Job_Title'].'</b><br>';
   	 	echo 'หน่วยงาน: '.$row['Farm_Name'].'</p>';
    	echo '<a href="job_description.php?act=APPLY&job_id='.$row['Job_ID'].'" class="w3-button w3-yellow w3-right">สมัครงาน</a>';
    	echo '</div></div>';
	  }
	  echo '</div>';
		echo '<div class="w3-container">';
	  echo '<div class="w3-center">';
	  echo '<div class="w3-bar w3-border-bottom w3-border-left w3-border-right">';
	  echo '<div class="w3-bar-item w3-button">หน้า</div>';
	  $nop = ceil($result->num_rows / _PER_PAGE_1);
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
  			echo '<a class="w3-bar-item w3-button" onclick="getData(4, '.($p+1).','.($p * _PER_PAGE_1).',\''.$key.'\')">'.($p+1).'</a>';
  	    }
		echo '</div></div>';
		echo '</div>';
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
  echo '<tr><td colspan="4"><div class="w3-button w3-right w3-pale-yellow"><i class="fa fa-paper-plane"></i> *** กรุณาเข้าสู่ระบบ เพื่อยืนยันการสมัครงาน ***</div></td></tr>';
  echo '</table>';
}

if($_POST['type'] == 5){
	$key = "";
	$cond = "";
	if(isset($_POST['key']) && !empty($_POST['key'])){
		$key = $_POST['key'];
		$cond = "WHERE (P.Pro_Title LIKE \"%$key%\" OR P.Pro_Description LIKE \"%$key%\" OR P.Pro_Contact LIKE \"%$key%\")";
	}
	if(isset($_POST['pagenum'])){
		$pagenum = $_POST['pagenum'];
	}
	$st = $_POST['st'];

	$sql = "SELECT P.Pro_ID, P.Pro_Photo, P.Pro_Title FROM product AS P $cond LIMIT $st, "._PER_PAGE_1;
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  echo '<div class="w3-container">';
	  echo '<i class="fa fa-info-circle"></i> จำนวน '.$result->num_rows.' รายการ';
	  echo '</div>';
	  echo '<div class="w3-container">';
	  while($row = $result->fetch_assoc()) {
    	echo '<div class="w3-col l4 m4 w3-pale-yellow w3-container w3-padding-16 w3-border-right w3-border-bottom">';
    	echo '<a href="prod_description.php?act=GET&pro_id='.$row["Pro_ID"].'" style="text-decoration: none;">';
      echo '<img src="figs/'.$row['Pro_Photo'].'" title="'.$row['Pro_Title'].'" style="width:100%;">';
      echo '<div class="w3-container w3-center">';
      echo '<p>'.$row['Pro_Title'].'</p>';
      echo '</div></a>';
    	echo '</div>';
	  }
	  echo '</div>';
	  echo '<div class="w3-container">';
	  echo '<div class="w3-center">';
	  echo '<div class="w3-bar w3-border-bottom w3-border-left w3-border-right">';
	  echo '<div class="w3-bar-item w3-button">หน้า</div>';
	  $nop = ceil($result->num_rows / _PER_PAGE_1);
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
  			echo '<a class="w3-bar-item w3-button" onclick="getData(5, '.($p+1).','.($p * _PER_PAGE_1).',\''.$key.'\')">'.($p+1).'</a>';
  	}
		echo '</div></div>';
		echo '</div>';
	} else {
    	echo '<div class="w3-col l4 m4 w3-pale-yellow w3-container w3-padding-16 w3-border-left w3-border-bottom">';
    	echo '<div class="w3-container">';
   	 	echo '<p>ไม่มีข้อมูล</p>';
    	echo '</div></div>';
	}
}

if($_POST['type'] == 6){
	$sql = "SELECT P.*, F.Farm_ID, F.Farm_Name FROM product AS P INNER JOIN farm AS F ON P.Farm_ID=F.Farm_ID AND Pro_ID=".$_POST['pro_id'];
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
	echo '<tr><th>ผู้เผยแพร่ผลิตภัณฑ์</th><td>'.$row['Farm_Name'].'</td></tr>';
  echo '</table>';
}

if($_POST['type'] == 7){
	$usrEmail = testInput($_POST['usrEmail']);
	$sql = "SELECT * FROM user WHERE User_Email Like \"".$usrEmail."\" ";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		echo '{ "result": false }';
	} else {
	  echo '{ "result": true }';
	}
}

if(isset($_POST['type']) && $_POST['type'] == 8){
	$sql = "SELECT * FROM user WHERE (User_Email Like \"".$_SESSION['sessUserEmail']."\" AND User_Active=1)";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

  echo '<table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">';
  echo '<tr><th width="30%">อีเมล (E-mail)</th><td>'.$row['User_Email'].'</td></tr>';
	echo '<tr><th>รหัสผ่าน</th><td>********</td></tr>';  
  echo '<tr><th>ชื่อ-สกุล</th><td>'.$row['User_Fullname'].'</td></tr>';
  echo '<tr><th>ประเภทผู้ใช้งาน</th><td>'.getUsrStatus($row['User_Type']).'</td></tr>';
  echo '<tr><th>การเปิดใช้งาน</th><td>'.getActiveStatus($row['User_Active']).'</td></tr>';
  echo '<tr><th>วันที่สมัคร</th><td>'.$row['User_Added'].'</td></tr>';
  echo '<tr><th>วันที่ปรับปรุงล่าสุด</th><td>'.$row['User_Updated'].'</td></tr>';
  echo '<tr><th></th><td><a href="user_setting.php" class="w3-button w3-orange"><i class="fa fa-pencil-square-o"></i> แก้ไขข้อมูล</a></td></tr>';
  echo '</table><br>';
  echo '<a href="index.php" class="w3-button w3-yellow"><i class="fa fa-arrow-left"></i> กลับหน้าแรก</a>';
}

if(isset($_POST['type']) && $_POST['type'] == 9){
	$sql = "SELECT * FROM user WHERE (User_Email Like \"".$_SESSION['sessUserEmail']."\" AND User_Active=1)";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	echo '<form action="../src/proc_data.php" method="POST">';
  	echo '<table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">';
  	echo '<tr><th width="30%">อีเมล (E-mail)</th><td>'.$row['User_Email'].'</td></tr>';
	echo '<tr><th>รหัสผ่าน</th><td>********</td></tr>';  
  	echo '<tr><th>ชื่อ-สกุล</th><td><input type="text" name="usrFullname" class="w3-input w3-border" value="'.$row['User_Fullname'].'" required></td></tr>';
  	echo '<tr><th>ประเภทผู้ใช้งาน</th><td>'.getUsrStatus($row['User_Type']).'</td></tr>';
  	echo '<tr><th>การเปิดใช้งาน</th><td>'.getActiveStatus($row['User_Active']).'</td></tr>';
  	echo '<tr><th>วันที่สมัคร</th><td>'.$row['User_Added'].'</td></tr>';
  	echo '<tr><th>วันที่ปรับปรุงล่าสุด</th><td>'.$row['User_Updated'].'</td></tr>';
  	echo '<tr><th></th><td><button type="submit" class="w3-button w3-green"><i class="fa fa-pencil-square-o"></i> แก้ไข</button><button type="reset" class="w3-button w3-red"><i class="fa fa-eraser"></i> เคลียร์</button></td></tr>';
  	echo '<input type="hidden" name="act" value="UPPROF">';
  	echo '</table><br>';
  	echo '</form>';
  	echo '<h5><b><i class="fa fa-key"></i> เปลี่ยนรหัสผ่าน</b></h5>';
  	echo '<form action="../src/proc_data.php" method="POST">';
  	echo '<table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">';
  	echo '<tr><th width="30%">รหัสผ่านปัจจุบัน</th><td><input type="password" name="usrPwdCur" id="usrPwdCur" class="w3-input w3-border" onchange="return checkPassword(1)" required><div id="outcur" class="w3-text-red"></div></td></tr>';
	echo '<tr><th>รหัสผ่านใหม่</th><td><input type="password" name="usrPwdNew" id="usrPwdNew" minlength="8" maxlength="100" class="w3-input w3-border" required></td></tr>';  
  	echo '<tr><th>ยืนยันรหัสผ่านใหม่</th><td><input type="password" name="usrCfPwdNew" id="usrCfPwdNew" minlength="8" maxlength="100" class="w3-input w3-border" onchange="return checkPassword(2)" required><div id="outnew" class="w3-text-red"></div></td></tr>';
  	echo '<tr><th></th><td><button type="submit" class="w3-button w3-green"><i class="fa fa-pencil-square-o"></i> แก้ไข</button><button type="reset" class="w3-button w3-red"><i class="fa fa-eraser"></i> เคลียร์</button></td></tr>';
  	echo '<input type="hidden" name="act" value="UPPWD">';
  	echo '<input type="hidden" name="usrPwdTmp" id="usrPwdTmp" value="'.$row['User_Password'].'">';
  	echo '</table><br>';
  	echo '</form>';
  	echo '<a href="user_profile.php" class="w3-button w3-yellow"><i class="fa fa-arrow-left"></i> ย้อนกลับ</a>';
}

if(isset($_POST['type']) && ($_POST['type'] == 10 || $_POST['type'] == 11)){
	$usrEmail = $_SESSION['sessUserEmail'];
	$sql = "SELECT U.User_ID, R.* FROM user AS U INNER JOIN resume AS R ON ";
	$sql.= "U.User_Email Like \"".$usrEmail."\" AND (U.User_ID=R.User_ID)";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	if ($result->num_rows <= 0 || $_POST['type'] == 11) {
	  echo '<form action="../src/proc_data.php" method="POST">';
	  $optPrefix = "";
	  $optSex = "";
	  $pSel1 = $pSel2 = $pSel3 = "";
	  $sSel1 = $sSel2 = $sSel3 = "";
	  if($_POST['type'] == 11){
	  	if($row['Res_Prefix'] == 1) $pSel1 = "selected";
	  	else if($row['Res_Prefix'] == 2) $pSel2 = "selected";
	  	else if($row['Res_Prefix'] == 3) $pSel3 = "selected";

	  	if($row['Res_Sex'] == 1) $sSel1 = "selected";
	  	else if($row['Res_Sex'] == 2) $sSel2 = "selected";
	  	else if($row['Res_Sex'] == 3) $sSel3 = "selected";

		$optPrefix = '<option value="">-ระบุคำนำหน้า-</option>';
	  	$optPrefix.= '<option value="1" '.$pSel1.'>นาย</option>';
	  	$optPrefix.= '<option value="2" '.$pSel2.'>นางสาว</option>';
	  	$optPrefix.= '<option value="3" '.$pSel3.'>นาง</option>';
		$optSex = '<option value="" selected>-ระบุเพศ-</option>';
	  	$optSex.= '<option value="1" '.$sSel1.'>ชาย</option>';
	  	$optSex.= '<option value="2" '.$sSel2.'>หญิง</option>';
	  	$optSex.= '<option value="3" '.$sSel3.'>ไม่ระบุ</option>';
	  	echo '<input type="hidden" name="Res_ID" value="'.$row['Res_ID'].'">';
	  	echo '<input type="hidden" name="act" value="UPRES">';
	  }else{
		echo '<input type="hidden" name="act" value="ADDRES">';
		$optPrefix = '<option value="" selected>-ระบุคำนำหน้า-</option>';
	  	$optPrefix.= '<option value="1">นาย</option>';
	  	$optPrefix.= '<option value="2">นางสาว</option>';
	  	$optPrefix.= '<option value="3">นาง</option>';
		$optSex = '<option value="" selected>-ระบุเพศ-</option>';
	  	$optSex.= '<option value="1">ชาย</option>';
	  	$optSex.= '<option value="2">หญิง</option>';
	  	$optSex.= '<option value="3">ไม่ระบุ</option>';
	  }
	  echo '<table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">';
	  echo '<tr><th>คำนำหน้า</th><td>';
	  echo '<select class="w3-select w3-border" name="resPrefix" required>'.$optPrefix.'</select>';
	  echo '</td></tr>';
	  echo '<tr><th width="30%">ชื่อ</th><td><input type="text" name="resName" class="w3-input w3-border" value="'.$row['Res_Name'].'" required></td></tr>';
	  echo '<tr><th>สกุล</th><td><input type="text" name="resSurname" class="w3-input w3-border" value="'.$row['Res_Surname'].'" required></td></tr>';  
	  echo '<tr><th>อายุ</th><td><input type="number" name="resAge" value="'.$row['Res_Age'].'" style="width:25%;" required> ปี</td></tr>';
	  echo '<tr><th>เพศ</th><td>';
	  echo '<select class="w3-select w3-border" name="resSex" required>'.$optSex.'</select>';
	  echo '</td></tr>';
	  echo '<tr><th>เบอร์ติดต่อ</th><td><input type="text" name="resPhone" class="w3-input w3-border" value="'.$row['Res_Phone'].'" required></td></tr>';
	  echo '<tr><th>อีเมล</th><td><input type="text" name="resEmail" class="w3-input w3-border" value="'.$row['Res_Email'].'"></td></tr>';
	  echo '<tr><th>ที่อยู่</th><td><textarea name="resAddress" class="w3-input w3-border">'.$row['Res_Address'].'</textarea></td></tr>';
	  echo '<tr><th>ตำแหน่งงานที่สนใจ</th><td>';
	  echo '<select class="w3-select w3-border" name="Occ_ID">';
	  echo '<option value="0">-ระบุตำแหน่งงานที่สนใจ-</option>';
	  $sql_occ = "SELECT * FROM occupation";
	  $res_occ = $conn->query($sql_occ);
	  while($row_occ = $res_occ->fetch_assoc()){
	  	if($row_occ['Occ_ID'] == $row['Occ_ID']){
		  $sel = 'selected';
	  	}else{
	  	  $sel = '';
	  	}
	  	echo '<option value="'.$row_occ['Occ_ID'].'" '.$sel.'>'.$row_occ['Occ_Name'].'</option>';
	  }
	  echo '</select></td></tr>';
	  echo '<tr><th>หมายเหตุ</th><td><textarea name="resNote" class="w3-input w3-border">'.$row['Res_Note'].'</textarea></td></tr>';
	  echo '<tr><th></th><td><button type="submit" class="w3-button w3-green" onclick="return confirmInfo(\'ยืนยันการฝากประวัติ?\');"><i class="fa fa-pencil-square-o"></i> ฝากประวัติ</button><button type="reset" class="w3-button w3-red"><i class="fa fa-eraser"></i> เคลียร์</button></td></tr>';
	  echo '</table><br>';
	  echo '</form>';
	  echo '<a href="resume.php" class="w3-button w3-yellow"><i class="fa fa-arrow-left"></i> ย้อนกลับ</a>';
	} else {
	  echo '<form action="resume.php" method="POST">';
	  echo '<table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">';
	  echo '<tr><th>คำนำหน้า</th><td>'.getPrefix($row['Res_Prefix']).'</td></tr>';
	  echo '<tr><th width="30%">ชื่อ</th><td>'.$row['Res_Name'].'</td></tr>';
	  echo '<tr><th>สกุล</th><td>'.$row['Res_Surname'].'</td></tr>';  
	  echo '<tr><th>อายุ</th><td>'.$row['Res_Age'].' ปี</td></tr>';
	  echo '<tr><th>เพศ</th><td>'.getSex($row['Res_Sex']).'</td></tr>';
	  echo '<tr><th>เบอร์ติดต่อ</th><td>'.$row['Res_Phone'].'</td></tr>';
	  echo '<tr><th>อีเมล</th><td>'.$row['Res_Email'].'</td></tr>';
	  echo '<tr><th>ที่อยู่</th><td>'.$row['Res_Address'].'</td></tr>';
	  echo '<tr><th>ตำแหน่งงานที่สนใจ</th><td>';
	  $sql_occ = "SELECT * FROM occupation WHERE Occ_ID=".$row['Occ_ID'];
	  $res_occ = $conn->query($sql_occ);
	  $row_occ = $res_occ->fetch_assoc();
	  echo $row_occ['Occ_Name'].'</td></tr>';
	  echo '<tr><th>หมายเหตุ</th><td>'.$row['Res_Note'].'</td></tr>';
	  echo '<tr><th></th><td><button class="w3-button w3-blue"><i class="fa fa-pencil-square-o"></i> ปรับปรุงประวัติ</button></td></tr>';
	  echo '</table><br>';
	  echo '<input type="hidden" name="type" value="11">';
	  echo '</form>';
	  echo '<a href="index.php" class="w3-button w3-yellow"><i class="fa fa-arrow-left"></i> กลับหน้าแรก</a>';
	}
} // Resume

if(isset($_POST['type']) && ($_POST['type'] == 12)){
	$key = "";
	$cond = "";
	if(isset($_POST['key']) && !empty($_POST['key'])){
		$key = $_POST['key'];
		$cond = "AND (J.Job_Title LIKE \"%$key%\" OR J.Job_Description LIKE \"%$key%\" OR J.Job_Note LIKE \"%$key%\")";
	}
	if(isset($_POST['pagenum'])){
		$pagenum = $_POST['pagenum'];
	}
	$st = $_POST['st'];

	$sql = "SELECT J.Job_ID, J.Job_Title, F.Farm_Name FROM jobs AS J INNER JOIN farm AS F ON J.Farm_ID=F.Farm_ID $cond LIMIT $st, "._PER_PAGE_1;
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  echo '<div class="w3-container">';
	  echo '<i class="fa fa-info-circle"></i> จำนวน '.$result->num_rows.' รายการ';
	  echo '</div>';
	  echo '<div class="w3-container">';
	  echo '<table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">';
	  echo '<tr><th>ตำแหน่ง</th><th>ฟาร์ม</th><th>รายละเอียด</th><th>สมัครงาน</th></tr>';
	  while($row = $result->fetch_assoc()) {
    	echo '<tr><td>'.$row['Job_Title'].'</td>';
   	 	echo '<td>'.$row['Farm_Name'].'</td>';
   	 	echo '<td><a onClick="document.getElementById(\'jd'.$row['Job_ID'].'\').style.display=\'block\'" class="w3-button w3-green w3-center">รายละเอียด</a>';

   	 	/****/
    	echo '<div id="jd'.$row['Job_ID'].'" class="w3-modal">';
    	echo '<div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:640px">';
      	echo '<div class="w3-center">';
        echo '<span onclick="document.getElementById(\'jd'.$row['Job_ID'].'\').style.display=\'none\'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>';
      	echo '</div>';
      	echo '<div class="w3-container">';
        echo '<p class="w3-container w3-padding">';

		$sql_jd = "SELECT J.*, F.*, U.User_Fullname FROM jobs AS J ";
		$sql_jd.= "INNER JOIN farm AS F ON J.Farm_ID=F.Farm_ID AND Job_ID=".$row['Job_ID']." ";
		$sql_jd.= "INNER JOIN user AS U ON F.User_ID=U.User_ID";
		$res_jd = $conn->query($sql_jd);
		$row_jd = $res_jd->fetch_assoc();

  		echo '<h5><i class="fa fa-vcard"></i> ตำแหน่งงาน: '.$row_jd['Job_Title'].'</h5>';
  		echo '<table class="w3-table-all w3-hoverable">';
  		echo '<tr class="w3-khaki"><th colspan="2">รายละเอียดงานรับสมัคร</th><th colspan="2">หน่วยงานรับสมัคร</th></tr>';
  		echo '</td><th>ตำแหน่งงาน</th><td>'.$row_jd['Job_Title'].'</td><th>ชื่อหน่วยงาน</th><td>'.$row_jd['Farm_Name'].'</td></tr>';
  		echo '<tr><th>รายละเอียดงาน</th><td>'.$row_jd['Job_Description'].'</td><th>รายละเอียด</th><td>'.$row_jd['Farm_Description'].'</td></tr>';
  		echo '<tr><th>ค่าจ้างต่อเดือน</th><td>'.$row_jd['Job_Salary'].'</td><th>ข้อมูลติดต่อ</th><td>'.$row_jd['Farm_Address'].$row_jd['Farm_Email'].$row_jd['Farm_Phone'].'</td></tr>';
  		echo '<tr><th>ติดต่องาน</th><td>'.$row_jd['Job_Phone'].'</td><td></td><td></td></tr>';
  		echo '<tr><th>หมายเหตุ</th><td>'.$row_jd['Job_Note'].'</td><td></td><td></td></tr>';
  		echo '<tr><th>สถานะตำแหน่งงาน</th><td>'.getJobStatus($row_jd['Job_Status']).'</td><td></td><td></td></tr>';
  		echo '<tr><th>เริ่มเผยแพร่</th><td>'.$row_jd['Job_Added'].'</td><td></td><td></td></tr>';
  		echo '<tr><th>ปรับปรุงล่าสุด</th><td>'.$row_jd['Job_Updated'].'</td><td></td><td></td></tr>';
		echo '<tr><th>ผู้เผยแพร่ข้อมูล</th><td>'.$row_jd['User_Fullname'].'</td><td></td><td></td></tr>';
  		echo '</table>';
        echo '</p>';       
      	echo '</div>';
      	echo '<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">';
        echo '<button onclick="document.getElementById(\'jd'.$row['Job_ID'].'\').style.display=\'none\'" type="button" class="w3-button w3-red">'._CANCEL.'</button>';
      	echo '</div></div></div>';
   	 	/****/

   	 	echo '</td>';
   	 	// ผู้ใช้สามารถสมัครงานได้มากกว่า 1 ตำแหน่ง
   	 	$sql_j = "SELECT JR.*,R.User_ID FROM jobs_resume AS JR INNER JOIN resume AS R ON JR.Res_ID=R.Res_ID AND JR.Job_ID=".$row['Job_ID']." AND R.User_ID=".$_SESSION['sessUserId'];
   	 	// ผู้ใช้สามารถสมัครงานได้เพียง 1 ตำแหน่ง
   	 	//$sql_j = "SELECT JR.*,R.User_ID FROM jobs_resume AS JR INNER JOIN resume AS R ON JR.Res_ID=R.Res_ID AND R.User_ID=".$_SESSION['sessUserId'];
   	 	$res_j = $conn->query($sql_j);
    	echo '<td>';
    	if ($res_j->num_rows > 0) {
    		$row_j = $res_j->fetch_assoc();
    		echo '<a href="../src/proc_data.php?act=RESCAN&job_id='.$row['Job_ID'].'&res_id='.$row_j['Res_ID'].'" class="w3-button w3-red w3-center" onClick="return confirmInfo(\'คุณต้องการยกเลิกการสมัครงาน?\')">'._CANCEL.'</a><br><div class="w3-tiny">(*อยู่ระหว่างรอการตอบรับ)</div>';
    	}else{
    		echo '<a href="../src/proc_data.php?act=APPLYNOW&job_id='.$row['Job_ID'].'" class="w3-button w3-yellow w3-center" onClick="return confirmInfo(\'ยืนยันการสมัครงาน?\')">สมัครงาน</a>';
    	}
    	echo '</td></tr>';
	  }
	  echo '</table>';
	  echo '</div>';
	}
	echo '<div class="w3-container">';
	echo '<div class="w3-center">';
	echo '<div class="w3-bar w3-border-bottom w3-border-left w3-border-right">';
	echo '<div class="w3-bar-item w3-button">หน้า</div>';
	$nop = ceil($result->num_rows / _PER_PAGE_1);
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
  		echo '<a class="w3-bar-item w3-button" onclick="getData(12, '.($p+1).','.($p * _PER_PAGE_1).',\''.$key.'\')">'.($p+1).'</a>';
  	}
	echo '</div></div>';
	echo '</div>';
} // Apply Job

if(isset($_POST['type']) && ($_POST['type'] == 14)){
	$key = "";
	if(isset($_POST['pagenum'])){
		$pagenum = $_POST['pagenum'];
	}
	$st = $_POST['st'];

	$sql = "SELECT JR.*,R.User_ID FROM jobs_resume AS JR INNER JOIN resume AS R ON JR.Res_ID=R.Res_ID AND R.User_ID=".$_SESSION['sessUserId']." LIMIT $st, "._PER_PAGE_1;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	  echo '<div class="w3-container">';
	  echo '<i class="fa fa-info-circle"></i> จำนวน '.$result->num_rows.' รายการ';
	  echo '</div>';
	  echo '<div class="w3-container">';
	  echo '<table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">';
	  echo '<tr><th>ตำแหน่ง</th><th>ฟาร์ม</th><th>รายละเอียด</th><th>ผลการสมัครงาน</th></tr>';
	  while($row = $result->fetch_assoc()) {
   	 	$sql_j = "SELECT J.*, F.*, U.User_Fullname FROM jobs AS J INNER JOIN farm AS F ON J.Farm_ID=F.Farm_ID AND J.Job_ID=".$row['Job_ID']." ";
   	 	$sql_j.= "INNER JOIN user AS U ON F.User_ID=U.User_ID";
   	 	$res_j = $conn->query($sql_j);
   	 	$row_j = $res_j->fetch_assoc();
    	echo '<tr><td>'.$row_j['Job_Title'].'</td>';
   	 	echo '<td>'.$row_j['Farm_Name'].'</td>';
   	 	echo '<td><a onClick="document.getElementById(\'jd'.$row_j['Job_ID'].'\').style.display=\'block\'" class="w3-button w3-green w3-center">รายละเอียด</a>';

   	 	/****/
    	echo '<div id="jd'.$row_j['Job_ID'].'" class="w3-modal">';
    	echo '<div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:640px">';
      	echo '<div class="w3-center">';
        echo '<span onclick="document.getElementById(\'jd'.$row_j['Job_ID'].'\').style.display=\'none\'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>';
      	echo '</div>';
      	echo '<div class="w3-container">';
        echo '<p class="w3-container w3-padding">';
  		echo '<h5><i class="fa fa-vcard"></i> ตำแหน่งงาน: '.$row_j['Job_Title'].'</h5>';
  		echo '<table class="w3-table-all w3-hoverable">';
  		echo '<tr class="w3-khaki"><th colspan="2">รายละเอียดงานรับสมัคร</th><th colspan="2">หน่วยงานรับสมัคร</th></tr>';
  		echo '</td><th>ตำแหน่งงาน</th><td>'.$row_j['Job_Title'].'</td><th>ชื่อหน่วยงาน</th><td>'.$row_j['Farm_Name'].'</td></tr>';
  		echo '<tr><th>รายละเอียดงาน</th><td>'.$row_j['Job_Description'].'</td><th>รายละเอียด</th><td>'.$row_j['Farm_Description'].'</td></tr>';
  		echo '<tr><th>ค่าจ้างต่อเดือน</th><td>'.$row_j['Job_Salary'].'</td><th>ข้อมูลติดต่อ</th><td>'.$row_j['Farm_Address'].$row_j['Farm_Email'].$row_j['Farm_Phone'].'</td></tr>';
  		echo '<tr><th>ติดต่องาน</th><td>'.$row_j['Job_Phone'].'</td><td></td><td></td></tr>';
  		echo '<tr><th>หมายเหตุ</th><td>'.$row_j['Job_Note'].'</td><td></td><td></td></tr>';
  		echo '<tr><th>สถานะตำแหน่งงาน</th><td>'.getJobStatus($row_j['Job_Status']).'</td><td></td><td></td></tr>';
  		echo '<tr><th>เริ่มเผยแพร่</th><td>'.$row_j['Job_Added'].'</td><td></td><td></td></tr>';
  		echo '<tr><th>ปรับปรุงล่าสุด</th><td>'.$row_j['Job_Updated'].'</td><td></td><td></td></tr>';
		echo '<tr><th>ผู้เผยแพร่ข้อมูล</th><td>'.$row_j['User_Fullname'].'</td><td></td><td></td></tr>';
  		echo '</table>';
        echo '</p>';       
      	echo '</div>';
      	echo '<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">';
        echo '<button onclick="document.getElementById(\'jd'.$row['Job_ID'].'\').style.display=\'none\'" type="button" class="w3-button w3-red">'._CANCEL.'</button>';
      	echo '</div></div></div>';
   	 	/****/

   	 	echo '</td>';
    	echo '<td>';
    	echo '<a class="w3-center">'.getJobResStatus($row['JobRes_Status']).'</a>';
    	echo '</td></tr>';
	  }
	  echo '</table>';
	  echo '</div>';
	}
	echo '<div class="w3-container">';
	echo '<div class="w3-center">';
	echo '<div class="w3-bar w3-border-bottom w3-border-left w3-border-right">';
	echo '<div class="w3-bar-item w3-button">หน้า</div>';
	$nop = ceil($result->num_rows / _PER_PAGE_1);
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
  		echo '<a class="w3-bar-item w3-button" onclick="getData(14, '.($p+1).','.($p * _PER_PAGE_1).',\''.$key.'\')">'.($p+1).'</a>';
  	}
	echo '</div></div>';
	echo '</div>';
} // Apply job history

if(isset($_POST['type']) && ($_POST['type'] == 16)){
	$key = "";
	if(isset($_POST['pagenum'])){
		$pagenum = $_POST['pagenum'];
	}
	$st = $_POST['st'];

	$sql = "SELECT U.* FROM user AS U LIMIT $st, "._PER_PAGE_1;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	  echo '<div class="w3-container">';
	  echo '<i class="fa fa-info-circle"></i> จำนวน '.$result->num_rows.' รายการ';
	  echo '</div>';
	  echo '<div class="w3-container">';
	  echo '<table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">';
	  echo '<tr><th>ID</th><th>อีเมล</th><th>ชื่อ-สกุล</th><th>รายละเอียด</th><th>สถานะ</th><th>ดำเนินการ</th></tr>';
	  while($row = $result->fetch_assoc()) {
    	echo '<tr><td>'.$row['User_ID'].'</td>';
   	 	echo '<td>'.$row['User_Email'].'</td>';
   	 	echo '<td>'.$row['User_Fullname'].'</td>';
   	 	echo '<td><a onClick="document.getElementById(\'uid'.$row['User_ID'].'\').style.display=\'block\'" class="w3-button w3-green w3-center">รายละเอียด</a>';

   	 	/****/
    	echo '<div id="uid'.$row['User_ID'].'" class="w3-modal">';
    	echo '<div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:640px">';
      	echo '<div class="w3-center">';
        echo '<span onclick="document.getElementById(\'uid'.$row['User_ID'].'\').style.display=\'none\'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>';
      	echo '</div>';
      	echo '<div class="w3-container">';
        echo '<p class="w3-container w3-padding">';
  		echo '<h5><i class="fa fa-user-circle-o"></i> หมายเลขผู้ใช้: '.$row['User_ID'].'</h5>';
  		echo '<table class="w3-table-all w3-hoverable">';
  		echo '<tr><th>อีเมล</th><td>'.$row['User_Email'].'</td></tr>';
  		echo '<tr><th>ชื่อ-สกุล</th><td>'.$row['User_Fullname'].'</td></tr>';
  		echo '<tr><th>ประเภทผู้ใช้งาน</th><td>'.getUsrStatus($row['User_Type']).'</td></tr>';
  		echo '<tr><th>การเปิดใช้งาน</th><td>'.getActiveStatus($row['User_Active']).'</td></tr>';
  		echo '<tr><th>วันที่สมัคร</th><td>'.$row['User_Added'].'</td></tr>';
  		echo '<tr><th>วันที่ปรับปรุงล่าสุด</th><td>'.$row['User_Updated'].'</td></tr>';
  		echo '</table>';
        echo '</p>';       
      	echo '</div>';
      	echo '<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">';
        echo '<button onclick="document.getElementById(\'uid'.$row['User_ID'].'\').style.display=\'none\'" type="button" class="w3-button w3-red">'._CANCEL.'</button>';
      	echo '</div></div></div>';
   	 	/****/

   	 	echo '</td>';
   	 	echo '<td>';
   	 	if($row['User_Active']){
			echo '<a class="w3-center"><i class="w3-xlarge fa fa-toggle-on w3-text-green"></i></a>';
   	 	}else{
    		echo '<a class="w3-center"><i class="w3-xlarge fa fa-toggle-off"></i></a>';
    	}
    	echo '</td>';
    	echo '<td>';
    	if($row['User_Type'] != 1 && $row['User_Fullname'] != 'Administrator'){
    		echo '<a class="w3-center w3-blue w3-button"><i class="fa fa-edit"></i> แก้ไข</a> ';
    		echo '<a class="w3-center w3-red w3-button"><i class="fa fa-trash"></i> ลบ</a>';
    	}
    	echo '</td></tr>';
	  }
	  echo '</table>';
	  echo '</div>';
	}
	echo '<div class="w3-container">';
	echo '<div class="w3-center">';
	echo '<div class="w3-bar w3-border-bottom w3-border-left w3-border-right">';
	echo '<div class="w3-bar-item w3-button">หน้า</div>';
	$nop = ceil($result->num_rows / _PER_PAGE_1);
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
  		echo '<a class="w3-bar-item w3-button" onclick="getData(16, '.($p+1).','.($p * _PER_PAGE_1).',\''.$key.'\')">'.($p+1).'</a>';
  	}
	echo '</div></div>';
	echo '</div>';
} // Apply job history

closeConDB($conn);
?>