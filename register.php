<?php
include 'libs/config.inc.php';
include 'tpls/header.php';
?>
<script>
function validateEmail(){
  $(document).ready(function(){
    $.post("src/get_data.php",
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
              <td><input class="w3-input w3-border" type="email" name="usrEmail" id="usrEmail" minlength="8" maxlength="100" onchange="validateEmail()" required><div id="outmail"></div></td>
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
                <input class="w3-radio" type="radio" name="usrType" id="usrType_3" value="3" required> ฝากประวัติ / สมัครงาน
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

<?php
include 'tpls/footer.php';
include 'tpls/login.php';
?>

</body>
</html>
