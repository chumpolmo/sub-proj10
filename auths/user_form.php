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
<script>
function validateEmail(){
  $(document).ready(function(){
    $.post("../src/get_data.php",
    { 
      usrEmail: $("#usrEmail").val(),
      type: 7
    },
    function(data, status){
      let txt = "";
      let obj = JSON.parse(data);
      if(obj.result == false){
        txt = "<span class='w3-text-red'><i class='fa fa-times-circle-o'></i> อีเมลนี้มีในระบบฐานข้อมูลแล้ว กรุณาใช้อีเมลอื่น!</span>";
        $("#outmail").html(txt);
        $("#usrEmail").val("");
        $("#usrEmail").focus();
      }else{
        txt = "<span class='w3-text-green'><i class='fa fa-check-circle-o'></i> อีเมลนี้สามารถใช้งานได้</span>";
        $("#outmail").html(txt);
      }
    });
  });
}
</script>
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

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-user-circle-o"></i> ข้อมูลผู้ใช้งาน</b></h5>
  </header>

  <?php
  $dis = "";
  $act = "ADDUSR";
  $btn = "บันทึก";
  $usrEmail = $usrPwd = $usrFullname = "";
  $usrType = 0;
  $usrId = $usrActive = 0;
  if(isset($_GET['act']) && $_GET['act'] == 'USRUPD'){
    $dis = "disabled";
    $act = "USRUPD";
    $btn = "แก้ไข";
    $conn = connectDB();
    $sql = "SELECT U.* FROM user AS U WHERE User_ID=".$_GET['user_id'];
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $usrId = $row['User_ID'];
    $usrEmail = $row['User_Email'];
    $usrPwd = $row['User_Password'];
    $usrFullname = $row['User_Fullname'];
    $usrType = $row['User_Type'];
    $usrActive = $row['User_Active'];
  }
  ?>

  <div id="outuser" class="w3-container">
    <div class="w3-row w3-container">
      <div>
          <table class="w3-table-all">
            <form action="../src/proc_data.php" method="POST">
              <tr>
                <th>อีเมล (E-mail)<i class="w3-text-red">**</i></th>
                <td><input class="w3-input w3-border" type="email" name="usrEmail" id="usrEmail" minlength="8" maxlength="100" value="<?=$usrEmail?>" onchange="validateEmail()" <?=$dis?> required><div id="outmail"></div></td>
              </tr>
              <tr>
                <th>รหัสผ่าน (Password)<i class="w3-text-red">**</i></th>
                <td><input class="w3-input w3-border" type="password" name="usrPwd" id="usrPwd" minlength="8" maxlength="100" value="<?=str_replace('.', '*', $usrPwd)?>" <?=$dis?> required>
                  <input class="w3-check" type="checkbox" onclick="showPwd()"> แสดงรหัสผ่าน</td>
              </tr>
              <tr>
                <th>ชื่อ-สกุล</th>
                <td><input class="w3-input w3-border" type="text" name="usrFullname" id="usrFullname" minlength="8" maxlength="100" value="<?=$usrFullname?>"></td>
              </tr>
              <tr>
                <th>สมัครสมาชิกประเภท<i class="w3-text-red">**</i></th>
                <td>
                  <input class="w3-radio" type="radio" name="usrType" id="usrType_2" value="2" required <?php if($usrType == 2) echo 'checked'; ?>> เจ้าของฟาร์ม / ตัวแทนฟาร์ม<br>
                  <input class="w3-radio" type="radio" name="usrType" id="usrType_3" value="3" required <?php if($usrType == 3) echo 'checked'; ?>> ฝากประวัติ / สมัครงาน
                </td>
              </tr>
              <tr>
                <th>สถานะการเปิดใช้งาน</th>
                <td>
                  <input class="w3-radio" type="radio" name="usrActive" id="usrActive_1" value="1" <?php if($usrActive == 1) echo 'checked'; ?>> Active<br>
                  <input class="w3-radio" type="radio" name="usrActive" id="usrActive_0" value="0" <?php if($usrActive == 0) echo 'checked'; ?>> In-active
                </td>
              </tr>
              <tr>
                <td></td>
                <td class="w3-text-red">
                  <button class="w3-button w3-green w3-section w3-padding" onclick="return confirmInfo('กรุณายืนยันการ<?=$btn?>ข้อมูลผู้ใช้งาน?');"><?=$btn?></button>
                  <button class="w3-button w3-grey w3-section w3-padding" type="reset">เคลียร์</button>
                  <br>*อีเมล และ รหัสผ่านควรระบุอย่างน้อย 8 ตัวอักษร<br>
                  **กรุณากรอกข้อมูลให้สมบูรณ์
                  <input type="hidden" name="act" value="<?=$act?>">
                  <input type="hidden" name="user_id" value="<?=$usrId?>">
                </td>
              </tr>
            </form>
          </table>
      </div>
      <div class="w3-button w3-yellow"><a href="user_info.php"><i class="fa fa-arrow-left"></i> ย้อนกลับ</a></div>
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
