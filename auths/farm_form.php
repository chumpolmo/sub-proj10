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
<?php
include '../tpls/top_container.php'; 
include '../tpls/menu_sidebar.php'; 
?>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <?php
  $act = "FARMADD";
  $btn = "บันทึก";
  $farmId = $farmType = 0;
  $farmName = $farmDesc = $farmEmail = $farmNote = "";
  $farmPhone = $farmAddr = $farmLoc = "";
  if(isset($_GET['act']) && $_GET['act'] == 'FARMUPD'){
    $act = $_GET['act'];
    $btn = "แก้ไข";
    $conn = connectDB();
    $sql = "SELECT F.*, U.User_Fullname FROM farm AS F ";
    $sql.= "INNER JOIN user AS U ON F.User_ID=U.User_ID AND F.Farm_ID=".$_GET['farm_id'];
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $farmId = $row['Farm_ID'];
    $farmEmail = $row['Farm_Email'];
    $farmName = $row['Farm_Name'];
    $farmType = $row['Farm_Type'];
    $farmDesc = $row['Farm_Description'];
    $farmAddr = $row['Farm_Address'];
    $farmLoc = $row['Farm_Location'];
    $farmNote = $row['Farm_Note'];
    $farmPhone = $row['Farm_Phone'];
  }
  ?>

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-leaf fa-fw"></i> ข้อมูลฟาร์ม</b></h5>
  </header>

  <div id="outuser" class="w3-container">
    <div class="w3-row w3-container">
      <div>
          <table class="w3-table-all">
            <form action="../src/proc_data.php" method="POST">
              <tr>
                <th>ชื่อฟาร์ม<i class="w3-text-red">**</i></th>
                <td><input class="w3-input w3-border" type="text" name="farmName" id="farmName" minlength="1" maxlength="100" value="<?=$farmName?>" required></td>
                <th>ประเภทฟาร์ม<i class="w3-text-red">**</i></th>
                <td>
                  <input class="w3-radio" type="radio" name="farmType" id="farmType_1" value="10" <?php if($farmType == 10) echo 'checked'; ?> required> ขนาดเล็ก (ไม่เกิน 10 ไร่)<br>
                  <input class="w3-radio" type="radio" name="farmType" id="farmType_2" value="20" <?php if($farmType == 20) echo 'checked'; ?> required> ขนาดกลาง (ตั้งแต่ 10 - 30 ไร่)<br>
                  <input class="w3-radio" type="radio" name="farmType" id="farmType_3" value="30" <?php if($farmType == 30) echo 'checked'; ?> required> ขนาดใหญ่ (30 ไร่ ขึ้นไป)
                </td>
              </tr>
              <tr>
                <th>รายละเอียด</th>
                <td colspan="3"><textarea class="w3-input w3-border" type="text" name="farmDesc" id="farmDesc"><?=$farmDesc?></textarea></td>
              </tr>
              <tr>
                <th>อีเมล<i class="w3-text-red">**</i></th>
                <td><input class="w3-input w3-border" type="email" name="farmEmail" id="farmEmail" minlength="1" maxlength="100" value="<?=$farmEmail?>" required></td>
                <th>โทรศัพท์<i class="w3-text-red">**</i></th>
                <td><input class="w3-input w3-border" type="text" name="farmPhone" id="farmPhone" minlength="1" maxlength="20" value="<?=$farmPhone?>" required></td>
              </tr>
              <tr>
                <th>ที่อยู่<i class="w3-text-red">**</i></th>
                <td colspan="3"><textarea class="w3-input w3-border" type="text" name="farmAddr" id="farmAddr" required><?=$farmAddr?></textarea></td>
              </tr>
              <tr>
                <th>ตำแหน่ง (Lat, Long)<div class="w3-tiny w3-text-grey">ตัวอย่าง:<br>13.781339662707444,100.56005135178566</div></th>
                <td><input class="w3-input w3-border" type="text" name="farmLoc" id="farmLoc" minlength="1" maxlength="50" value="<?=$farmLoc?>"></td>
                <th>หมายเหตุ</th>
                <td><textarea class="w3-input w3-border" type="text" name="farmNote" id="farmNote"><?=$farmNote?></textarea></td>
              </tr>
              <tr>
                <td></td>
                <td class="w3-text-red">
                  <button class="w3-button w3-green w3-section w3-padding" onclick="return confirmInfo('กรุณายืนยันการ<?=$btn?>ข้อมูลฟาร์ม?');"><?=$btn?></button>
                  <button class="w3-button w3-grey w3-section w3-padding" type="reset">เคลียร์</button>
                  <br>**กรุณากรอกข้อมูลให้สมบูรณ์
                  <input type="hidden" name="act" value="<?=$act?>">
                  <input type="hidden" name="farm_id" value="<?=$farmId?>">
                </td>
              </tr>
            </form>
          </table>
      </div>
      <div class="w3-button w3-yellow"><a href="farm_info.php"><i class="fa fa-arrow-left"></i> ย้อนกลับ</a></div>
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
