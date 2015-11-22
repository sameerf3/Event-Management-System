<?php
  session_start(); // If Session Variable is present on the page?
  require_once('class.user.php');
  if(isset($_SESSION["login_user"])) {
    $email = $_SESSION["login_user"];
    $user = new User($email);
    $user_field = $user->get_current_user();
  }

  ob_start(); // This is buffer area where cookies and session are set and again set to expire them
  
?>
<div class="page-header">
  <?php if(!isset($_SESSION["login_user"])) { ?>
    <h1>Welcome <small>to our Website</small></h1>
  <?php } else { ?>
    <?php
      echo("<h1>Welcome <small>$user_field[name]</small></h1>");
    ?>
  <?php } ?>
</div>
<?php 
  if(isset($_SESSION["login_user"]) || !isset($_SESSION["login_user"])) { 
    if(empty($user_field) || $user_field["admin"] != true) { 
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