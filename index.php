<?php 
include 'libs/config.inc.php'; 
include 'tpls/header.php';
?>
<script>
$(document).ready(function(){
  $.post("src/get_data.php",
  { type: 1 },
  function(data, status){
    $("#outprod").html(data);
  });
  $.post("src/get_data.php",
  { type: 2 },
  function(data, status){
    $("#outjob").html(data);
  });
  $.post("src/get_data.php",
  { type: 3 },
  function(data, status){
    let obj = JSON.parse(data);
    $("#dbapply").html(obj.apply);
    $("#dbaccept").html(obj.accept);
    $("#dbfarm").html(obj.farm);
    $("#dbprod").html(obj.prod);
  });
  $.post("src/get_data.php",
  { type: 36 },
  function(data, status){
    $("#slnews").html(data);
  });
});

function getEmpReport(t, f=null){
  $(document).ready(function(){
    $.post("src/get_data.php",
    { type: t, farm_id: f },
    function(data, status){
        //alert("Testing...\n"+data);
        console.log(data);
        data = JSON.parse(data);
        let ctx01 = document.getElementById('myChart01');
        document.getElementById('myChart01').height = '250px';
        let arr_data = data;
        let arr_labels = [];
        if(t == 'REPEMPBYYEAR'){
          const d = new Date();
          let year = d.getFullYear();
          for(let i=parseInt(year-5); i<=parseInt(year); i++){
            arr_labels.push(i);
          }
        }else if(t == 'REPEMPBYQUARTER'){
          arr_labels = ['ไตรมาส 1','ไตรมาส 2','ไตรมาส 3','ไตรมาส 4'];
        }else if(t == 'REPEMPBYMONTH'){
          arr_labels = [
              'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
          ];
        }
        
        if(window.myCharts01 != undefined)
          window.myCharts01.destroy();
        window.myCharts01 = new Chart(ctx01, {
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
} // End: getEmpReport

function getProdReport(t, f=null){
  $(document).ready(function(){
    $.post("src/get_data.php",
    { type: t, farm_id: f },
    function(data, status){
        //alert("Testing...\n"+data);
        //console.log(data);
        data = JSON.parse(data);
        let ctx02 = document.getElementById('myChart02');
        document.getElementById('myChart02').height = '250px';
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
        
        if(window.myCharts02 != undefined)
          window.myCharts02.destroy();
        window.myCharts02 = new Chart(ctx02, {
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
} // End: getProdReport
</script>
</head>
<body onload="getEmpReport('REPEMPBYMONTH');getProdReport('REPBYMONTH');">

<?php include 'tpls/menu.php'; ?>

<!-- Content -->
<div class="w3-content" style="max-width:1100px;margin-top:80px;margin-bottom:80px">

  <div class="w3-panel w3-leftbar w3-border-khaki w3-pale-yellow">
    <p class="w3-xlarge">
    <i>"<?=_TITLE?>"</i></p>
  </div>

  <!-- Slideshow -->
  <div class="w3-container" id="slnews">
    <i class="fa fa-refresh w3-text-gray" title="Loading..."></i>
  </div>
  
  <!-- Grid -->
  <div class="w3-row w3-container">
    <div class="w3-center w3-padding-64">
      <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16"><?=_TITLE_ITEM_1?></span>
    </div>
    <div class="w3-col l6 m6 w3-pale-yellow w3-container w3-padding-16">
      <h3 class="w3-bottombar w3-border-light-gray">รับสมัครงาน</h3>
      <p>
        <ul class="w3-ul w3-hoverable w3-bar">
          <div id="outjob"><i class="fa fa-refresh w3-text-gray" title="Loading..."></i></div>
        </ul>
        <div class="w3-button"><a href="apply.php"><i class="fa fa-angle-double-right"></i> เพิ่มเติม</a></div>
      </p>
    </div>

    <div class="w3-col l6 m6 w3-khaki w3-container w3-padding-16">
      <h3 class="w3-bottombar w3-border-light-gray">ผลิตภัณฑ์ใหม่</h3>
      <p>
        <ul class="w3-ul w3-hoverable">
          <div id="outprod"><i class="fa fa-refresh w3-text-gray" title="Loading..."></i></div>
        </ul>
        <div class="w3-button"><a href="products.php"><i class="fa fa-angle-double-right"></i> เพิ่มเติม</a></div>
      </p>
    </div>

  </div>

   <!-- Grid -->
  <div class="w3-row-padding" id="about">
    <div class="w3-center w3-padding-64">
      <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16"><?=_TITLE_ITEM_2?></span>
    </div>

    <div class="w3-quarter">
      <div class="w3-panel w3-leftbar w3-card-4 w3-border-khaki">
        <span class="w3-text-grey w3-right">จำนวนผู้สมัครงาน | คน</span><br>
        <i class='fa fa-user w3-text-khaki' style="font-size:60px;"></i>
        <span style="font-size:60px;" class="w3-right" id="dbapply">
          <i class="fa fa-refresh w3-text-gray" title="Loading..."></i>
        </span>
      </div>
    </div>

    <div class="w3-quarter">
      <div class="w3-panel w3-leftbar w3-card-4 w3-border-yellow">
        <span class="w3-text-grey w3-right">จำนวนผู้ได้งานทำ | คน</span><br>
        <i class='fa fa-user-plus w3-text-yellow' style="font-size:60px;"></i>
        <span style="font-size:60px;" class="w3-right" id="dbaccept">
          <i class="fa fa-refresh w3-text-gray" title="Loading..."></i>
        </span>
      </div>
    </div>

    <div class="w3-quarter">
      <div class="w3-panel w3-leftbar w3-card-4 w3-border-amber">
        <span class="w3-text-grey w3-right">จำนวนฟาร์ม | ฟาร์ม</span><br>
        <i class='fa fa-leaf w3-text-amber' style="font-size:60px;"></i>
        <span style="font-size:60px;" class="w3-right" id="dbfarm"><i class="fa fa-refresh w3-text-gray" title="Loading..."></i></span>
      </div>
    </div>

    <div class="w3-quarter">
      <div class="w3-panel w3-leftbar w3-card-4 w3-border-orange">
        <span class="w3-text-grey w3-right">จำนวนผลิตภัณฑ์ | ผลิตภัณฑ์</span><br>
        <i class='fa fa-shopping-cart w3-text-orange' style="font-size:60px;"></i>
        <span style="font-size:60px;" class="w3-right" id="dbprod">
          <i class="fa fa-refresh w3-text-gray" title="Loading..."></i>
        </span>
      </div>
    </div>

  </div>

  <!-- Job applicant -->
  <div class="w3-center w3-padding-64" id="overview">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">ภาพรวมผู้สมัครงาน</span>
  </div>
  <div class="w3-center">
    <div class="w3-right">
      <a class="w3-button w3-pale-yellow" onclick="getEmpReport('REPEMPBYMONTH')">รายเดือน</a>
      <a class="w3-button w3-khaki" onclick="getEmpReport('REPEMPBYQUARTER')">รายไตรมาส</a>
      <a class="w3-button w3-yellow" onclick="getEmpReport('REPEMPBYYEAR')">รายปี</a>
    </div>
    <canvas id="myChart01" style="width:100%;max-width:100%;height: 250px;"></canvas>
  </div>

  <div class="w3-center w3-padding-64" id="output">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">ภาพรวมผลผลิตจากฟาร์ม</span>
  </div>
  <div class="w3-center">
    <div class="w3-right">
      <a class="w3-button w3-pale-yellow" onclick="getProdReport('REPBYMONTH')">รายเดือน</a>
      <a class="w3-button w3-khaki" onclick="getProdReport('REPBYQUARTER')">รายไตรมาส</a>
      <a class="w3-button w3-yellow" onclick="getProdReport('REPBYYEAR')">รายปี</a>
    </div>
    <canvas id="myChart02" style="width:100%;max-width:100%;height: 250px;"></canvas>
    <div class="w3-left">
      <div>หมายเหตุ แสดงรายการผลผลิตในภาพรวมจากฟาร์มที่ปรากฎในระบบ</div>
    </div>
  </div>

  <!-- Contact -->
  <div class="w3-center w3-padding-64" id="contact">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16"><?=_TITLE_CONTACT?></span>
  </div>
  <div class="w3-panel w3-border w3-border-khaki w3-pale-yellow w3-padding-32">
    <p class="w3-large w3-center">
    โครงการย่อยที่ 10 การพัฒนาโปรแกรมประยุกต์เพื่อสนับสนุนการขจัดความยากจนแบบเบ็ดเสร็จและแม่นยำของกลุ่มเกษตรกรและวิสาหกิจชุมชนสับปะรดศรีราชา จังหวัดชลบุรี<br>โครงการวิจัยทุน (สกสว.) ปีงบประมาณ พ.ศ. 2565<br><br>
    ภายใต้ โครงการวิจัยชุดนวัตกรรมห่วงโซ่คุณค่าใหม่เพื่อยกระดับเศรษฐกิจฐานราก และการเพิ่มขีดความสามารถในการแข่งขันอย่างยั่งยืนของกลุ่มเกษตรกรและวิสาหกิจชุมชนสับปะรดศรีราชา จังหวัดชลบุรี<br><br>
    โดย<br>ผู้ช่วยศาสตราจารย์ณชภัทร พิชญมหุตม์<br>ได้รับเงินสนับสนุนทุนวิจัยจากเงินงบประมาณสำนักงานคณะกรรมการส่งเสริมวิทยาศาสตร์วิจัยและนวัตกรรม (สกสว.)<br><br>
    <i class="fa fa-envelope"></i> ติดต่อผู้ดูแลเว็บไซต์ <a href="mailto:<?=_ADMIN_EMAIL?>" class="w3-button w3-green"><?=_ADMIN_EMAIL?></a> 
    </p>
  </div>

</div>

<?php
include 'tpls/footer.php';
include 'tpls/login.php';
?>
<script src="js/sp10.js"></script>
</body>
</html>
