<?php
include 'libs/config.inc.php';
include 'tpls/header.php';
?>
<script>
$(document).ready(function(){
  $.post("src/get_data.php",
  { type: 4, st: 0, end: 8 },
  function(data, status){
    $("#outapply").html(data);
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
     <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16"><?=_TITLE_APPLY?></span>
  </div>
  <div class="w3-row w3-container">
    <div id="outapply"><i class="fa fa-refresh w3-text-gray w3-center" title="Loading..."></i></div>
  </div>

</div>

<?php
include 'tpls/footer.php';
include 'tpls/login.php';
?>

</body>
</html>
