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
});
</script>
</head>
<body>

<?php include 'tpls/menu.php'; ?>

<!-- Content -->
<div class="w3-content" style="max-width:1100px;margin-top:80px;margin-bottom:80px">

  <div class="w3-panel w3-leftbar w3-border-khaki w3-pale-yellow">
    <p class="w3-xlarge">
    <i>"<?=_TITLE?>"</i></p>
  </div>

  <!-- Slideshow -->
  <div class="w3-container">
    <div class="w3-display-container mySlides">
      <img src="figs/figure_0001.jpg" style="width:100%">
      <div class="w3-display-topright w3-container w3-padding-32">
        <span class="w3-white w3-padding-large w3-animate-bottom">การทำไซเดอร์สับปะรดเพื่อสุขภาพ</span>
      </div>
    </div>
    <div class="w3-display-container mySlides">
      <img src="figs/figure_0002.jpg" style="width:100%">
      <div class="w3-display-topright w3-container w3-padding-32">
        <span class="w3-white w3-padding-large w3-animate-bottom">ถ่ายทอดเทคโนโลยี</span>
      </div>
    </div>
    <div class="w3-display-container mySlides">
      <img src="figs/figure_0001.jpg" style="width:100%">
      <div class="w3-display-topright w3-container w3-padding-32">
        <span class="w3-white w3-padding-large w3-animate-bottom">สับปะรดอบแห้ง</span>
      </div>
    </div>

    <!-- Slideshow next/previous buttons -->
    <div class="w3-container w3-dark-grey w3-padding w3-xlarge">
      <div class="w3-left" onclick="plusDivs(-1)"><i class="fa fa-arrow-circle-left w3-hover-text-teal"></i></div>
      <div class="w3-right" onclick="plusDivs(1)"><i class="fa fa-arrow-circle-right w3-hover-text-teal"></i></div>
    
      <div class="w3-center">
        <span class="w3-tag demodots w3-border w3-transparent w3-hover-white" onclick="currentDiv(1)"></span>
        <span class="w3-tag demodots w3-border w3-transparent w3-hover-white" onclick="currentDiv(2)"></span>
        <span class="w3-tag demodots w3-border w3-transparent w3-hover-white" onclick="currentDiv(3)"></span>
      </div>
    </div>
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
      <button class="w3-button w3-khaki">รายเดือน</button>
      <button class="w3-button w3-yellow">รายปี</button>
    </div>
    <canvas id="myChart01" style="width:100%;max-width:100%;height: 250px;"></canvas>
    <script>
      const ctx01 = document.getElementById('myChart01');

      new Chart(ctx01, {
        type: 'bar',
        data: {
          labels: [
            'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
          ],
          datasets: [
            {
              label: '#สมัครงาน',
              data: [12, 19, 3, 5, 2, 3, 7, 8, 2, 6, 0, 4],
              backgroundColor: '#FF9900',
              borderWidth: 1
            },
            {
              label: '#ได้งานทำ',
              data: [4, 10, 2, 1, 1, 2, 5, 6, 2, 4, 0, 3],
              backgroundColor: '#00CC66',
              borderWidth: 1
            }
          ]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    </script>
  </div>

  <div class="w3-center w3-padding-64" id="overview">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">ภาพรวมผลิตภัณฑ์ชุมชน</span>
  </div>
  <div class="w3-center">
    <div class="w3-right">
      <button class="w3-button w3-khaki">รายเดือน</button>
      <button class="w3-button w3-yellow">รายปี</button>
    </div>
    <canvas id="myChart02" style="width:100%;max-width:100%;height: 250px;"></canvas>
    <script>
      const ctx02 = document.getElementById('myChart02');

      new Chart(ctx02, {
        type: 'bar',
        data: {
          labels: [
            'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
          ],
          datasets: [
            {
              label: '#ผลิตภัณฑ์ชุมชน',
              data: [12, 19, 3, 5, 2, 3, 7, 8, 2, 6, 0, 4],
              backgroundColor: '#FF9900',
              borderWidth: 1
            }
          ]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    </script>
  </div>

  <div class="w3-center w3-padding-64" id="output">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">ภาพรวมผลผลิต</span>
  </div>
  <div class="w3-center">
    <div class="w3-right">
      <button class="w3-button w3-khaki">รายเดือน</button>
      <button class="w3-button w3-yellow">รายปี</button>
    </div>
    <canvas id="myChart03" style="width:100%;max-width:100%;height: 250px;"></canvas>
    <script>
      const ctx03 = document.getElementById('myChart03');

      new Chart(ctx03, {
        type: 'bar',
        data: {
          labels: [
            'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
          ],
          datasets: [
            {
              label: '#ผลผลิตฟาร์ม (หน่วย)',
              data: [12, 19, 3, 5, 2, 3, 7, 8, 2, 6, 0, 4],
              backgroundColor: '#FF9900',
              borderWidth: 1
            }
          ]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    </script>
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
    โดย<br>ผู้ช่วยศาสตราจารย์ณชภัทร พิชญมหุตม์<br>ได้รับเงินสนับสนุนทุนวิจัยจากเงินงบประมาณสำนักงานคณะกรรมการส่งเสริมวิทยาศาสตร์วิจัยและนวัตกรรม (สกสว.) 
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
