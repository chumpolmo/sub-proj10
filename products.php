<?php
include 'libs/config.inc.php';
include 'tpls/header.php';
?>
<script>
$(document).ready(function(){
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
<div class="w3-content" style="max-width:1100px;margin-top:20px;margin-bottom:80px">

  <!-- Grid -->
  <div class="w3-center w3-padding-64">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16"><?=_TITLE_PRODUCT?></span>
  </div>
  <div class="w3-row w3-container">
    <div class="w3-col l4 m4 w3-pale-yellow w3-container w3-padding-16 w3-border-right w3-border-bottom">
      <img src="figs/figure_0001.jpg" title="xxx" style="width:100%;">
      <div class="w3-container w3-center">
        <p>xxx</p>
      </div>
    </div>

    <div class="w3-col l4 m4 w3-pale-yellow w3-container w3-padding-16 w3-border-right w3-border-bottom">
      <img src="figs/figure_0002.jpg" title="xxx" style="width:100%;">
      <div class="w3-container w3-center">
        <p>xxx</p>
      </div>
    </div>

    <div class="w3-col l4 m4 w3-pale-yellow w3-container w3-padding-16 w3-border-right w3-border-bottom">
      <img src="figs/figure_0001.jpg" title="xxx" style="width:100%;">
      <div class="w3-container w3-center">
        <p>xxx</p>
      </div>
    </div>
  </div>

</div>

<?php
include 'tpls/footer.php';
include 'tpls/login.php';
?>

</body>
</html>
