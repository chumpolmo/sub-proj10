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
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16"><?=_TITLE_PRODUCT_DESCRIPTION?></span>
  </div>
  <div class="w3-row w3-container">
    <b><i class="fa fa-shopping-cart"></i> ชื่อผลิตภัณฑ์: สับปะรดอบแห้ง</b>

    <table class="w3-table-all w3-hoverable">
      <thead>
        <tr class="w3-light-grey">
          <th>First Name</th>
          <th>Last Name</th>
          <th>Points</th>
        </tr>
      </thead>
      <tr>
        <td>Jill</td>
        <td>Smith</td>
        <td>50</td>
      </tr>
      <tr>
        <td>Eve</td>
        <td>Jackson</td>
        <td>94</td>
      </tr>
      <tr>
        <td>Adam</td>
        <td>Johnson</td>
        <td>67</td>
      </tr>
    </table>
  </div>

</div>

<?php
include 'tpls/footer.php';
include 'tpls/login.php';
?>

</body>
</html>
