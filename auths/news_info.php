<?php
session_start();

include '../libs/config.inc.php';
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
$t = 18;
if(isset($_POST['type'])){
  $t = 19;
}
?>
<script>
function getData(t, np, st, key=null){
  $(document).ready(function(){
    $.post("../src/get_data.php",
    { type: t, pagenum: np, st: st, key: key },
    function(data, status){
      $("#outnews").html(data);
    });
  });
}
</script>
</head>
<body class="w3-light-grey" onload="getData(<?=$t?>, 0, 0)">

<!-- Top container -->
<?php
include '../tpls/top_container.php'; 
include '../tpls/menu_sidebar.php'; 
?>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-newspaper-o"></i> ข้อมูลข่าวประชาสัมพันธ์</b></h5>
  </header>

  <div class="w3-container w3-right">
    <a href="news_form.php" class="w3-button w3-blue"><i class="fa fa-plus-circle"></i> เพิ่มข่าวประชาสัมพันธ์</a>
  </div>
  <div id="outnews" class="w3-container">
    <i class="fa fa-refresh w3-text-gray w3-center" title="Loading..."></i>
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
