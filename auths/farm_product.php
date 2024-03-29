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

function getReport(t, f=null){
  $(document).ready(function(){
    $.post("../src/get_data.php",
    { type: t, farm_id: f },
    function(data, status){
        //alert("Testing...\n"+data);
        console.log(data);
        data = JSON.parse(data);
        let ctx01 = document.getElementById('myChart01');
        document.getElementById('myChart01').height = '250px';
        let arr_data = data;
        let arr_labels = [];
        if(t == 'REPBYYEAR'){
          const d = new Date();
          let year = d.getFullYear();
          for(let i=parseInt(year-5); i<=parseInt(year); i++){
            arr_labels.push(i);
          }
        }else if(t == 'REPBYQUARTER'){
          arr_labels = ['ไตรมาส 1','ไตรมาส 2','ไตรมาส 3','ไตรมาส 4'];
        }else if(t == 'REPBYMONTH'){
          arr_labels = [
              'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
          ];
        }
        
        if(window.myCharts != undefined)
          window.myCharts.destroy();
        window.myCharts = new Chart(ctx01, {
          type: 'bar',
          data: {
            labels: arr_labels,
            datasets: arr_data
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
    });
  });
}
</script>
</head>
<body class="w3-light-grey" onload="getData(<?=$t?>, 0, 0, null, <?=$farm_id?>);getReport('REPBYMONTH',<?=$farm_id?>);">

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
  <div class="w3-container">
    <header class="w3-container" style="padding-top:16px">
      <h5><b><i class="fa fa-bar-chart-o"></i> รายงานผลผลิต</b></h5>
    </header>
    <div class="w3-container w3-right">
      <a class="w3-button w3-pale-yellow" onclick="getReport('REPBYMONTH',<?=$farm_id?>)">รายเดือน</a>
      <a class="w3-button w3-khaki" onclick="getReport('REPBYQUARTER',<?=$farm_id?>)">รายไตรมาส</a>
      <a class="w3-button w3-yellow" onclick="getReport('REPBYYEAR')">รายปี</a>
    </div>
    <div id="outreport" class="w3-container">
      <canvas id="myChart01" style="width:100%;max-width:100%;height: 250px;">
        <i class="fa fa-refresh w3-text-gray w3-center" title="Loading..."></i>
      </canvas>
    </div>
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
