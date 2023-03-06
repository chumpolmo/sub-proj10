/**
 * JavaScript Functions
 **/
function plusDivs(n) {
  showDivs(slideIndex += n);
}

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demodots");
  if (n > x.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = x.length} ;
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" w3-white", "");
  }
  x[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " w3-white";
}

function showPwd() {
  if(document.getElementById('usrPwd').type === 'password'){
    document.getElementById('usrPwd').type = 'text';
  }else{
    document.getElementById('usrPwd').type = 'password';
  }
}

function checkPassword(t){
  if(t == 1){
    let pcur = document.getElementById('usrPwdCur').value;
    let ptmp = document.getElementById('usrPwdTmp').value;
    if(pcur !== ptmp){
      document.getElementById('usrPwdCur').value = "";
      document.getElementById('usrPwdCur').focus();
      document.getElementById('outcur').innerHTML = "<i class='fa fa-times-circle-o'></i> รหัสผ่านปัจจุบันไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง";
    }else{
      document.getElementById('outcur').innerHTML = "";
    }
  }
  if(t == 2){
    let pnew = document.getElementById('usrPwdNew').value;
    let pcf = document.getElementById('usrCfPwdNew').value;
    if(pnew !== pcf){
      document.getElementById('usrCfPwdNew').value = "";
      document.getElementById('usrCfPwdNew').focus();
      document.getElementById('outnew').innerHTML = "<i class='fa fa-times-circle-o'></i> รหัสผ่านใหม่ไม่ตรงกัน กรุณาตรวจสอบอีกครั้ง";
    }else{
      document.getElementById('outnew').innerHTML = "";
    }
  }
}

function confirmInfo(s){
  if(confirm(s)){
    return true;
  }
  return false;
}