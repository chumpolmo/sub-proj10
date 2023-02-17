<!-- Login modal -->
<div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

      <div class="w3-center"><br>
        <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
        <img src="figs/avatar01.png" style="width:20%;" class="w3-circle w3-margin-top w3-text-orange">
      </div>

      <form class="w3-container" action="auths/index.php">
        <div class="w3-section">
          <label><b>อีเมล (E-mail)</b></label>
          <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter E-mail" name="usremail" required>
          <label><b>รหัสผ่าน (Password)</b></label>
          <input class="w3-input w3-border" type="password" placeholder="Enter Password" name="psw" required>
          <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">Login</button>
        </div>
      </form>

      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button onclick="document.getElementById('id01').style.display='none'" type="button" class="w3-button w3-red"><?=_CANCEL?></button>
        <span class="w3-right w3-padding w3-hide-small"><a href="register.php">สมัครสมาชิก</a></span>
        <span class="w3-right w3-padding w3-hide-small">ลืม<a href="forgot_password.php">รหัสผ่าน?</a></span>
      </div>

    </div>
</div>