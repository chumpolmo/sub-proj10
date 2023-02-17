<?php
include 'libs/config.inc.php';
include 'tpls/header.php';
?>
<script>
$(document).ready(function(){
  $.post("src/get_data.php",
  { type: 6, pro_id: <?=$_GET['pro_id']?> },
  function(data, status){
    $("#outproddesc").html(data);
  });
});
</script>
</head>
<body>

<?php include 'tpls/menu.php'; ?>

<!-- Content -->
<div class="w3-content" style="max-width:1100px;margin-top:20px;margin-bottom:80px">

  <!-- Grid -->
  <div class="w3-center w3-padding-64">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16"><?=_TITLE_PRODUCT_DESCRIPTION?></span>
  </div>
  <div class="w3-row w3-container">
    <div id="outproddesc"><i class="fa fa-refresh w3-text-gray w3-center" title="Loading..."></i></div>
    <div class="w3-button w3-yellow"><a href="products.php"><i class="fa fa-angle-double-left"></i> ย้อนกลับ</a></div>
  </div>

</div>

<?php
include 'tpls/footer.php';
include 'tpls/login.php';
?>

</body>
</html>
