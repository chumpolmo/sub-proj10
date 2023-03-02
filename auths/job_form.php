<?php
session_start();

include '../libs/config.inc.php';
include '../libs/functions.php';
include '../tpls/header_auths.php';

if(!isset($_SESSION['sessLoggedIn']) || $_SESSION['sessLoggedIn'] === false){
    echo '<br><div class="w3-container">';
    echo '<div class="w3-card w3-border w3-pale-yellow">';
    echo '<div class="w3-center w3-padding-64">';
    echo '<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">คุณไม่มิสิทธิ์ใช้งานระบบ กรุณาเข้าสู่ระบบ...</span>';
    echo '</div>';
    echo '<div class="w3-center w3-container">';
    echo '<p>กรุณารอสักครู่...</p>';
    echo '<meta http-equiv="refresh" content="3; url=../index.php">';
    echo '<br><br></div>';
    echo '</div>';
    echo '</div>';
    die();
}
?>
</head>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i> Menu</button>
  <span class="w3-bar-item w3-left">
    <i class="fa fa fa-users"></i>
  </span>
  <span class="w3-bar-item w3-right"><?=_TITLE?></span>
</div>

<?php include '../tpls/menu_sidebar.php'; ?>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <?php
  $conn = connectDB();

  $act = "JOBADD";
  $btn = "บันทึก";
  $jobId = $farmId = $jobStatus = $jobSalary = 0;
  $jobTitle = $jobDesc = $jobNote = $jobPhone = "";
  if(isset($_GET['act']) && $_GET['act'] == 'JOBUPD'){
    $act = $_GET['act'];
    $btn = "แก้ไข";
    $sql = "SELECT J.*, O.* FROM jobs AS J ";
    $sql.= "INNER JOIN jobs_occupation AS O ON J.Job_ID=O.Job_ID ";
    $sql.= "WHERE J.Job_ID=".$_GET['job_id'];
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $jobId = $row['Job_ID'];
    $jobTitle = $row['Job_Title'];
    $jobDesc = $row['Job_Description'];
    $jobSalary = $row['Job_Salary'];
    $jobNote = $row['Job_Note'];
    $jobStatus = $row['Job_Status'];
    $jobPhone = $row['Job_Phone'];
    $farmId = $row['Farm_ID'];
    $occId = $row['Occ_ID'];
  }
  ?>

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-bullhorn fa-fw"></i> <?=$btn?>ประกาศการจ้างงาน</b></h5>
  </header>

  <div id="outuser" class="w3-container">
    <div class="w3-row w3-container">
      <div>
          <table class="w3-table-all">
            <form action="../src/proc_data.php" method="POST">
              <tr>
                <th>ชื่อฟาร์ม<i class="w3-text-red">**</i></th>
                <td colspan="3">
                  <select name="farmId" class="w3-select w3-border" required>
                    <option value="">-ระบุฟาร์ม-</option>
                    <?php
                    $sql_fa = "SELECT F.* FROM farm AS F";
                    $res_fa = $conn->query($sql_fa);
                    while($row_fa = $res_fa->fetch_assoc()){
                      $sel = "";
                      if($farmId == $row_fa['Farm_ID']) $sel = "selected";
                      echo '<option value="'.$row_fa['Farm_ID'].'" '.$sel.'>'.$row_fa['Farm_Name'].'</option>';
                    }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <th>ตำแหน่งงาน<i class="w3-text-red">**</i></th>
                <td><input class="w3-input w3-border" type="text" name="jobTitle" id="jobTitle" minlength="1" maxlength="100" value="<?=$jobTitle?>" required></td>
                <th>อาชีพ<i class="w3-text-red">**</i></th>
                <td>
                  <select name="occId" class="w3-select w3-border" required>
                    <option value="">-ระบุอาชีพ-</option>
                    <?php
                    $sql_occ = "SELECT O.* FROM occupation AS O";
                    $res_occ = $conn->query($sql_occ);
                    while($row_occ = $res_occ->fetch_assoc()){
                      $sel = "";
                      if($occId == $row_occ['Occ_ID']) $sel = "selected";
                      echo '<option value="'.$row_occ['Occ_ID'].'" '.$sel.'>'.$row_occ['Occ_Name'].'</option>';
                    }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <th>รายละเอียด</th>
                <td colspan="3"><textarea class="w3-input w3-border" type="text" name="jobDesc" id="jobDesc"><?=$jobDesc?></textarea></td>
              </tr>
              <tr>
                <th>อัตราค่าจ้าง (<?=_THB?>)<i class="w3-text-red">**</i></th>
                <td><input class="w3-input w3-border" type="number" name="jobSalary" id="jobSalary" value="<?=$jobSalary?>" required></td>
                <th>โทรศัพท์<i class="w3-text-red">**</i></th>
                <td><input class="w3-input w3-border" type="text" name="jobPhone" id="jobPhone" minlength="1" maxlength="20" value="<?=$jobPhone?>" required></td>
              </tr>
              <tr>
                <th>หมายเหตุ</th>
                <td><textarea class="w3-input w3-border" type="text" name="jobNote" id="jobNote"><?=$jobNote?></textarea></td>
                <th>สถานะ</th>
                <td>
                  <input class="w3-radio" type="radio" name="jobStatus" id="jobStatus_1" value="10" <?php if($jobStatus == 10) echo 'checked'; ?> required> เปิดรับคนทำงาน<br>
                  <input class="w3-radio" type="radio" name="jobStatus" id="jobStatus_2" value="20" <?php if($jobStatus == 20) echo 'checked'; ?> required> ปิดรับคนทำงาน
                </td>
              </tr>
              <tr>
                <td></td>
                <td class="w3-text-red">
                  <button class="w3-button w3-green w3-section w3-padding" onclick="return confirmInfo('กรุณายืนยันการ<?=$btn?>ประกาศจ้างงาน?');"><?=$btn?></button>
                  <button class="w3-button w3-grey w3-section w3-padding" type="reset">เคลียร์</button>
                  <br>**กรุณากรอกข้อมูลให้สมบูรณ์
                  <input type="hidden" name="act" value="<?=$act?>">
                  <input type="hidden" name="job_id" value="<?=$jobId?>">
                </td>
              </tr>
            </form>
          </table>
      </div>
      <div class="w3-button w3-yellow"><a href="job_info.php"><i class="fa fa-arrow-left"></i> ย้อนกลับ</a></div>
    </div>
  </div>
  <hr>
  <br>

  <!-- Footer -->
  <?php
  include '../tpls/footer.php';
  ?>

  <!-- End page content -->
</div>

<script src="../js/sp10.js"></script>

</body>
</html>
