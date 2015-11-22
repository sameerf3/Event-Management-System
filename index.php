<?php
  ob_start(); // This is buffer area where cookies and session are set and again set to expire them
  session_start(); // If Session Variable is present on the page?
?>
<div class="page-header">
  <?php if(!isset($_SESSION["login_user"])) { ?>
    <h1>Welcome <small>to our Website</small></h1>
  <?php } else { ?>
    <?php
      include("shared/config.php");
      $email = $_SESSION["login_user"];
      $sql = "Select CONCAT(`first_name`, ' ', `last_name`) as 'name' from users where email = '$email' limit 1";
      
      $result = mysqli_query($conn, $sql);
      $field = mysqli_fetch_array($result);
      echo("<h1>Welcome <small>$field[name]</small></h1>");
      $conn->close();
    ?>
  <?php } ?>
</div>
<?php 
  if(isset($_SESSION["login_user"]) || !isset($_SESSION["login_user"])) { 
    include("shared/config.php");
    if (!empty($_SESSION["login_user"])) {
      $email = $_SESSION["login_user"];
    } else {
      $email = '';
    }
    $sql = "Select * from users where email = '$email' limit 1";
    $result = mysqli_query($conn, $sql);
    $field = mysqli_fetch_array($result);
    if($field["admin"] != true) { 
      include("shared/index_slider.html");
    ?>
      <br />
    <?php
      include("shared/recent_events.php");
    }
  }
?>

<?php
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  include("application.php");
?>