<?php
include 'libs/config.inc.php';
include 'tpls/header.php';
?>
<script>
function procData(){
  $(document).ready(function(){
    alert("xxx");
    let usr_type = 0;
    if($("#usrType_2").checked){
      alert($("#usrType_2").val());
    }
    if($("#usrType_3").checked){
      alert($("#usrType_3").val());
    }
    $.post("src/proc_data.php",
    { 
      act: $("#act").val(),
      usrEmail: $("#usrEmail").val(),
      usrPwd: $("#usrEmail").val(), 
      usrType: usr_type
    },
    function(data, status){
      alert(data);
      let obj = JSON.parse(data);
      $("#outproc").css("display", "block");
      $("#outproc").html(obj.result);
    });
  });
}
</script>
</head>
<body>

<?php include 'tpls/menu.php'; ?>

<!-- Content -->
<div class="w3-content" style="max-width:1100px;margin-top:20px;margin-bottom:80px">

  <!-- Grid -->
  <div class="w3-center w3-padding-64">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16"><?=_TITLE_REGISTER?></span>
  </div>
  <div class="w3-row w3-container">
    <div>
        <table class="w3-table-all">
          <form action="src/proc_data.php" method="POST">
            <tr>
              <th>อีเมล (E-mail)</th>
              <td><input class="w3-input w3-border" type="email" name="usrEmail" id="usrEmail" minlength="8" maxlength="100" required></td>
            </tr>
            <tr>
              <th>รหัสผ่าน (Password)</th>
              <td><input class="w3-input w3-border" type="password" name="usrPwd" id="usrPwd" minlength="8" maxlength="100" required>
                <br><input class="w3-check" type="checkbox" onclick="showPwd()"> แสดงรหัสผ่าน</td>
            </tr>
            <tr>
              <th>สมัครสมาชิกประเภท</th>
              <td>
                <input class="w3-radio" type="radio" name="usrType" id="usrType_2" value="2" required> เจ้าของฟาร์ม / ตัวแทนฟาร์ม<br>
                <input class="w3-radio" type="radio" name="usrType" id="usrType_3" value="3" required> ฝากประวัติ / สมัครงาน / เผยแพร่ผลิตภัณฑ์ชุมชุน
              </td>
            </tr>
            <tr>
              <td></td>
              <td class="w3-text-red">
                <button class="w3-button w3-green w3-section w3-padding" onclick="return confirmInfo('กรุณายืนยันการสมัครสมาชิก?');">ลงทะเบียน</button>
                <button class="w3-button w3-grey w3-section w3-padding" type="reset">เคลียร์</button>
                <br>*อีเมล และ รหัสผ่านควรระบุอย่างน้อย 8 ตัวอักษร<br>
                **กรุณากรอกข้อมูลให้สมบูรณ์ทุกช่อง
                <input type="hidden" name="act" value="REGIS">
              </td>
            </tr>
          </form>
        </table>
    </div>
    <div class="w3-button w3-yellow"><a href="index.php"><i class="fa fa-angle-double-left"></i> กลับหน้าแรก</a></div>
  </div>

</div>

<div id="outproc" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

      <div class="w3-center"><br>
        <span onclick="document.getElementById('outproc').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
      </div>

      <div class="w3-container">
        <div class="w3-center">
           <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">xxx</span>
        </div>
        <p class="w3-container w3-padding-64">xxx</p>       
      </div>

      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button onclick="document.getElementById('outproc').style.display='none'" type="button" class="w3-button w3-red"><?=_CANCEL?></button>
      </div>

    </div>
</div>

<?php
include 'tpls/footer.php';
include 'tpls/login.php';
?>

</body>
</html>
