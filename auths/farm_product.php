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

// Check action type
$t = 26;
if(isset($_POST['type'])){
  $t = 27;
}

$farm_id = 0;
if(isset($_GET['farm_id'])){
  $farm_id = $_GET['farm_id'];
}
?>
<script>
function getData(t, np, st, key=null, f){
  $(document).ready(function(){
    $.post("../src/get_data.php",
    { type: t, pagenum: np, st: st, key: key, farm: f },
    function(data, status){
      $("#outproduct").html(data);
    });
  });
}
</script>
</head>
<body class="w3-light-grey" onload="getData(<?=$t?>, 0, 0, null, <?=$farm_id?>)">

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
  $act = "PRODADD";
  $btn = "บันทึก";
  $farmId = $farmType = 0;
  $farmName = $farmDesc = $farmEmail = $farmNote = "";
  $farmPhone = $farmAddr = $farmLoc = "";
  if(isset($_GET['act']) && $_GET['act'] == 'PRODADD'){
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
    <h5><b><i class="fa fa-shopping-cart fa-fw"></i> ข้อมูลผลผลิต <br>
    <i class="fa fa-leaf fa-fw"></i> ฟาร์ม : <?=$farmName?></b></h5>
  </header>
  <div class="w3-container w3-right">
    <a href="product_form.php?act=PRODADD&farm_id=<?=$farm_id?>" class="w3-button w3-blue"><i class="fa fa-plus-circle"></i> เพิ่มข้อมูลผลผลิต</a>
  </div>
  <div id="outproduct" class="w3-container">
    <i class="fa fa-refresh w3-text-gray w3-center" title="Loading..."></i>
  </div>
  <header class="w3-container" style="padding-top:16px">
    <h5><b><i class="fa fa-bar-chart-o"></i> รายงานผลผลิต</h5>
  </header>
  <div class="w3-container w3-right">
    <a class="w3-button w3-pale-yellow">รายเดือน</a>
    <a class="w3-button w3-khaki">รายไตรมาส</a>
    <a class="w3-button w3-yellow">รายปี</a>
  </div>
  <div id="outreport" class="w3-container">
    <i class="fa fa-refresh w3-text-gray w3-center" title="Loading..."></i>
  </div>
  <div class="w3-container w3-padding-16 w3-margin">
    <div class="w3-button w3-yellow"><a href="product_info.php"><i class="fa fa-arrow-left"></i> ย้อนกลับ</a></div>
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
