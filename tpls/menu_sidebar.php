<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="../figs/avatar01.png" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span>ยินดีต้อนรับ <strong><?=$_SESSION['sessUserEmail']?></strong></span><br>
      <a href="user_profile.php" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="user_setting.php" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
      <a href="../src/proc_data.php?act=LOGOUT" class="w3-bar-item w3-button" onclick="return confirmInfo('กรุณายืนยันการออกจากระบบ?')"><i class="fa fa-sign-out"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i> Close Menu</a>
    <a href="index.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-home fa-fw"></i> หน้าแรก</a>
    <?php
    if($_SESSION['sessUserType'] == 1){
      include '../tpls/menu_auths_1.php';
    }else if($_SESSION['sessUserType'] == 2){
      include '../tpls/menu_auths_2.php';
    }else if($_SESSION['sessUserType'] == 3){
      include '../tpls/menu_auths_3.php';
    }
    ?>
  </div>
</nav>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
</script>