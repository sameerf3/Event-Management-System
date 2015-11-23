<?php
  ob_start(); // This is buffer area where cookies and session are set and again set to expire them
  require_once('class.user.php');
  if(isset($_SESSION["login_user"])) {
    $email = $_SESSION["login_user"];
    $user = new User($email);
    $user_field = $user->get_current_user();
  }
 ?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Event Store</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php 
          if(isset($_SESSION["login_user"])) {
            if($user_field["admin"] == true) {
              echo('<li><a href="manage_events.php">Manage Events</a></li>');
            } else {
              echo('<li><a href="about.php">About Us</a></li>');
              echo('<li><a href="contact.php">Contact</a></li>');
              echo('<li><a href="events.php">Events</a></li>');
            }
          } else {
            echo('<li><a href="about.php">About Us</a></li>');
            echo('<li><a href="contact.php">Contact</a></li>');
          }
        ?>

      </ul>
      <?php 
        if(isset($_SESSION["login_user"])) { ?>
            <form class="navbar-form navbar-left" action="events.php" role="search">
              <div class="form-group">
                <input type="text" name="event_name" class="form-control" placeholder="Category Name">
              </div>
              <button type="submit" class="btn btn-default">Search</button>
            </form>
      <?php } ?>
      <ul class="nav navbar-nav navbar-right">
        <?php if(!isset($_SESSION["login_user"])) { ?>
          <li><a href="#" data-toggle="modal" data-target="#login_modal">Login</a></li>
          <li><a href="sign_up.php">Register</a></li>
        <?php } else { ?>
          <?php
            if(!empty($user_field['image'])) {
              echo('<li><img class="nav-img" src="data:image;base64,' . $user_field['image'] . '"></li>');
            } else {
              echo('<li><img class="nav-img" src="assets/images/user_img.png"></li>');
            }
          ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo("$user_field[name]"); ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <?php
                if($user_field["admin"] != true) {
                  echo('<li><a href="user_events.php">My Events</a></li>');
                } ?>
              <li><a href="profile.php" >Profile</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="destroy_session.php" method="delete">Log Out</a></li>
            </ul>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
