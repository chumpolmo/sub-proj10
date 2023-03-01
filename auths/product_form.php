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

  $farmId = $proId = 0;
  if(isset($_GET['farm_id'])){
    $farmId = $_GET['farm_id'];
  }
  if(isset($_GET['pro_id'])){
    $proId = $_GET['pro_id'];
  }
  $act = "PRODADD";
  $btn = "บันทึก";
  $proMonth = $proYear = $proPpu = $proQuan = 0;
  $proTitle = $proDesc = $proCont = $proPhoto = $proUnit = $farmName = "";
  if(isset($_GET['act']) && $_GET['act'] == 'PRODUPD'){
    $act = $_GET['act'];
    $btn = "แก้ไข";
    $sql = "SELECT P.*, F.Farm_Name FROM product AS P ";
    $sql.= "INNER JOIN farm AS F ON P.Farm_ID=F.Farm_ID AND F.Farm_ID=".$farmId." AND P.Pro_ID=".$proId;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $farmName = $row['Farm_Name'];
    $proId = $row['Pro_ID'];
    $proTitle = $row['Pro_Title'];
    $proDesc = $row['Pro_Description'];
    $proCont = $row['Pro_Contact'];
    $proPhoto = $row['Pro_Photo'];
    $proUnit = $row['Pro_Unit'];
    $proMonth = $row['Pro_Month'];
    $proYear = $row['Pro_Year'];
    $proPpu = $row['Pro_PricePU'];
    $proQuan = $row['Pro_Quantity'];
  }else{
    $sql = "SELECT F.Farm_Name FROM farm AS F ";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $farmName = $row['Farm_Name'];
  }
  ?>
  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-shopping-cart fa-fw"></i> ข้อมูลผลผลิต <br>
    <i class="fa fa-leaf fa-fw"></i> ฟาร์ม : <?=$farmName?></b></h5>
  </header>

  <div id="outuser" class="w3-container">
    <div class="w3-row w3-container">
      <div>
          <table class="w3-table-all">
            <form action="../src/proc_data.php" method="POST" enctype="multipart/form-data">
              <tr>
                <th>ชื่อผลิตภัณฑ์<i class="w3-text-red">**</i></th>
                <td><input class="w3-input w3-border" type="text" name="proTitle" id="proTitle" minlength="1" maxlength="100" value="<?=$proTitle?>" required></td>
                <th>รูปภาพ</th>
                <td><input class="w3-input w3-border" type="file" name="proPhoto" id="proPhoto" value="<?=$proPhoto?>">
                  <input type="hidden" name="proPhotoTmp" value="<?=$proPhoto?>"></td>
              </tr>
              <tr>
                <th>รายละเอียด</th>
                <td colspan="3"><textarea class="w3-input w3-border" type="text" name="proDesc" id="proDesc"><?=$proDesc?></textarea></td>
              </tr>
              <tr>
                <th>จำนวน<i class="w3-text-red">**</i></th>
                <td><input class="w3-input w3-border" type="number" name="proQuan" id="proQuan" minlength="1" maxlength="100" value="<?=$proQuan?>" required></td>
                <th>หน่วย<i class="w3-text-red">**</i></th>
                <td><input class="w3-input w3-border" type="text" name="proUnit" id="proUnit" minlength="1" maxlength="20" value="<?=$proUnit?>" required></td>
              </tr>
              <tr>
                <th>ราคาต่อหน่วย<i class="w3-text-red">**</i></th>
                <td><input class="w3-input w3-border" type="number" name="proPpu" id="proPpu" value="<?=$proPpu?>" required></td>
                <th>ผลผลิต เดือน/ปี<i class="w3-text-red">**</i></th>
                <td><select name="proMonth" class="w3-border" required>
                  <option value="">-ระบุเดือน-</option>
                <?php
                $months = array("1"=>"มกราคม","2"=>"กุมภาพันธ์","3"=>"มีนาคม","4"=>"เมษายน","5"=>"พฤษภาคม","6"=>"มิถุนายน","7"=>"กรกฎาคม","8"=>"สิงหาคม","9"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");
                foreach ($months as $key => $value) {
                  if($key == $row['Pro_Month'])
                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
                  else
                    echo '<option value="'.$key.'">'.$value.'</option>';
                }
                ?></select> / 
                <select name="proYear" class="w3-border" required>
                  <option value="">-ระบุปี-</option>
                <?php
                $y = date("Y");
                for($i=-5; $i<=5; $i++) {
                  if(($y+$i) == $row['Pro_Year'])
                    echo '<option value="'.($y+$i).'" selected>'.($y+$i).'</option>';
                  else
                    echo '<option value="'.($y+$i).'">'.($y+$i).'</option>';
                }
                ?></select>
                </td>
              </tr>
              <tr>
                <th>ข้อมูลติดต่อผลิตภัณฑ์</th>
                <td colspan="3"><textarea class="w3-input w3-border" type="text" name="proCont" id="proCont"><?=$proCont?></textarea></td>
              </tr>
              <tr>
                <td></td>
                <td class="w3-text-red">
                  <button class="w3-button w3-green w3-section w3-padding" onclick="return confirmInfo('กรุณายืนยันการ<?=$btn?>ข้อมูลผลิตภัณฑ์?');"><?=$btn?></button>
                  <button class="w3-button w3-grey w3-section w3-padding" type="reset">เคลียร์</button>
                  <br>**กรุณากรอกข้อมูลให้สมบูรณ์
                  <input type="hidden" name="act" value="<?=$act?>">
                  <input type="hidden" name="farm_id" value="<?=$farmId?>">
                  <input type="hidden" name="pro_id" value="<?=$proId?>">
                </td>
              </tr>
            </form>
          </table>
      </div>
      <div class="w3-button w3-yellow"><a href="farm_product.php?act=PRODADD&farm_id=<?=$farmId?>"><i class="fa fa-arrow-left"></i> ย้อนกลับ</a></div>
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
