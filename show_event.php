<?php
  ob_start();
  try {
    include("shared/config.php");
    $event_id = $_GET["id"];
    $event = "SELECT * FROM event_categories WHERE id=$event_id";
    $result = mysqli_query($conn, $event);
    $field = mysqli_fetch_array($result);
  } catch (Exception $e) {
    setcookie("flash_danger", "$e->getMessage();", time() + 3600);
    header("Location: manage_events.php");
  }
  
?>
<div class="page-header">
  <h1><?php echo $field["name"]; ?></h1>
</div>
<div class="row">
  <div class="col-md-7"></div>
  <div class="col-md-5"></div>
</div>
<?php
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  include("application.php");
?>