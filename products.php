<?php
include 'libs/config.inc.php';
include 'tpls/header.php';
?>
<script>
function getData(t, np, st, key=null){
  $(document).ready(function(){
    $.post("src/get_data.php",
    { type: t, pagenum: np, st: st, key: key },
    function(data, status){
      $("#outprod").html(data);
    });
  });
}
</script>
</head>
<body onload="getData(5, 1, 0)">

<?php include 'tpls/menu.php'; ?>

<!-- Content -->
<div class="w3-content" style="max-width:1100px;margin-top:20px;margin-bottom:80px">

  <!-- Grid -->
  <div class="w3-center w3-padding-64">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16"><?=_TITLE_PRODUCT?></span>
  </div>
  <div class="w3-row w3-container">
    <form>
    <div class="w3-center">
    <div class="w3-bar">
      <input type="text" name="keyword" id="keyword" class="w3-bar-item w3-input w3-border" required>
      <button type="button" class="w3-bar-item w3-button w3-blue" onclick="getData(5, 1, 0, document.getElementById('keyword').value)"><i class="fa fa-search"></i> ค้นหา</button>
    </div>
    </div>
    </form>
    <div>
      <div id="outprod"><i class="fa fa-refresh w3-text-gray w3-center" title="Loading..."></i></div>
    </div>
  </div>

</div>

<?php
include 'tpls/footer.php';
include 'tpls/login.php';
?>

</body>
</html>
