<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Event Management System</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php 
          if(isset($_SESSION["login_user"])) { 
            include("shared/config.php");
            $email = $_SESSION["login_user"];
            $sql = "Select * from users where email = '$email' limit 1";
            $result = mysqli_query($conn, $sql);
            $field = mysqli_fetch_array($result);
            if($field["admin"] == true) {
              echo('<li><a href="manage_events.php">Manage Events</a></li>');
            } else {
              echo('<li><a href="about.php">About Us</a></li>');
              echo('<li><a href="contact.php">Contact</a></li>');
              echo('<li><a href="book_event.php">Book Event</a></li>');
            }
          } else {
            echo('<li><a href="about.php">About Us</a></li>');
            echo('<li><a href="contact.php">Contact</a></li>');
          }
        ?>

      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <?php if(!isset($_SESSION["login_user"])) { ?>
          <li><a href="#" data-toggle="modal" data-target="#login_modal">Login</a></li>
          <li><a href="sign_up.php">Register</a></li>
        <?php } else { ?>
          <?php
            include("shared/config.php");
            $email = $_SESSION["login_user"];
            $sql = "Select CONCAT(`first_name`, ' ', `last_name`) as 'name', image from users where email = '$email' limit 1";
            ob_start();
            $result = mysqli_query($conn, $sql);
            $field = mysqli_fetch_array($result);
            if(!empty($field['image'])) {
              echo('<li><img class="nav-img" src="data:image;base64,' . $field['image'] . '"></li>');
            } else {
              echo('<li><img class="nav-img" src="assets/images/user_img.png"></li>');
            }
            
            echo("<li><a href='#' >$field[name]</a></li>");
            $conn->close();
          ?>
          <li><a href="profile.php" >Profile</a></li>
          <li><a href="destroy_session.php" method="delete">Log Out</a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>