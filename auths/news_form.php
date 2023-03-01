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

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-newspaper-o"></i> เพิ่มข้อมูลข่าวประชาสัมพันธ์</b></h5>
  </header>

  <?php
  $act = "NEWSADD";
  $btn = "บันทึก";
  $newsTitle = $newsDesc = $newsPhoto = "";
  $newsId = 0;
  if(isset($_GET['act']) && $_GET['act'] == 'NEWSUPD'){
    $act = $_GET['act'];
    $btn = "แก้ไข";
    $conn = connectDB();
    $sql = "SELECT N.* FROM news AS N WHERE News_ID=".$_GET['news_id'];
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $newsId = $row['News_ID'];
    $newsTitle = $row['News_Title'];
    $newsDesc = $row['News_Description'];
    $newsPhoto = $row['News_Photo'];
  }
  ?>

  <div id="outuser" class="w3-container">
    <div class="w3-row w3-container">
      <div>
          <table class="w3-table-all">
            <form action="../src/proc_data.php" method="POST" enctype="multipart/form-data">
              <tr>
                <th>หัวข้อข่าว<i class="w3-text-red">**</i></th>
                <td><input class="w3-input w3-border" type="text" name="newsTitle" id="newsTitle" minlength="8" maxlength="100" value="<?=$newsTitle?>" required></td>
              </tr>
              <tr>
                <th>รายละเอียดข่าว</th>
                <td><textarea class="w3-input w3-border" name="newsDesc" id="newsDesc"><?=$newsDesc?></textarea></td>
              </tr>
              <tr>
                <th>รูปภาพข่าว<i class="w3-text-red">**</i></th>
                <td>
                  <input class="w3-input w3-border" type="file" name="newsPhoto" id="newsPhoto" required>
                </td>
              </tr>
              <tr>
                <td></td>
                <td class="w3-text-red">
                  <button class="w3-button w3-green w3-section w3-padding" onclick="return confirmInfo('กรุณายืนยันการ<?=$btn?>ข้อมูลข่าว?');"><?=$btn?></button>
                  <button class="w3-button w3-grey w3-section w3-padding" type="reset">เคลียร์</button>
                  <br>*ข้อมูลควรระบุอย่างน้อย 8 ตัวอักษร<br>*รูปภาพควรมีขนาดไม่เกิน 2M<br>*ไฟล์รูปภาพที่รองรับ ได้แก่ JPG, PJEG, PNG และ GIF<br>
                  **กรุณากรอกข้อมูลให้สมบูรณ์
                  <input type="hidden" name="act" value="<?=$act?>">
                  <input type="hidden" name="news_id" value="<?=$newsId?>">
                </td>
              </tr>
            </form>
          </table>
      </div>
      <div class="w3-button w3-yellow"><a href="news_info.php"><i class="fa fa-arrow-left"></i> ย้อนกลับ</a></div>
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
