<?php
  ob_start(); // This is buffer area where cookies and session are set and again set to expire them 
  session_start();
  require_once('class.user.php');
  $email = $_SESSION["login_user"];
  $user = new User($email);
  $current_user = $user->get_current_user();

  function validateForm($__initialized_user, $email_param, $password_param, $confirm_password_param) {
    $errors = array();

    if($email_param == ""){
      array_push($errors, "Email is required");
    }
    if($password_param == ""){
      array_push($errors, "Password is required");
    }
    // Validating Uniqueness
    $current_user_email = $_SESSION["login_user"];
    $result = $__initialized_user->validate_uniqueness($current_user_email, "on_update");
    if($result->num_rows > 0) {
      array_push($errors, "This Email has already been taken");
    }
    if($password_param != $confirm_password_param) {
      array_push($errors, "Password Confiramtion is not matched with password");
    }
    $password_length = strlen($password_param);
    if($password_length <= 8) {
      array_push($errors, "Password must be of at least 8 characters");
    }
    $return_values = array($errors);
    if(count($errors) > 0) {
      array_push($return_values, "true");
      return $return_values;
    } else {
      array_push($return_values, "false");
      return $return_values;
    }
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if(validateForm($user, $email, $password, $confirm_password)[1] == "true") {
      echo "<div class='alert alert-danger'>";
      echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
      echo "<ul>";
      $errors_length = count(validateForm($user, $email, $password, $confirm_password)[0]);
      for($x = 0; $x < $errors_length; $x++) {
        echo "<li>" . validateForm($user, $email, $password, $confirm_password)[0][$x] . "</li>";
      }
      echo "</ul>";
      echo "</div>";
    } else {
      $pw = str_replace(' ', '', $password);
      // file_get_contents() //SQL Injection defence!
      $image = addslashes($_FILES['profile_image']['tmp_name']); 
      $image_name = addslashes($_FILES['profile_image']['name']);
      $image = file_get_contents($image);
      $image = base64_encode($image);

      $current_user_email = $_SESSION["login_user"];
      
      $result = $user->update_user($first_name, $last_name, $email, $pw, $image, $image_name);
      if ($result == true) {
        $_SESSION["login_user"] = $email;
        setcookie("flash_success", "Profile Updated.", time() + 3600);
        header("Location: profile.php");
      } else {
        setcookie("flash_danger", "Something went wrong", time() + 3600);
        header("Location: profile.php");
      }
      
    }
  }
?>
<div class="user_profile">
  <h1>Edit Profile</h1>
  <hr>
  <form action="update_profile.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <!-- left column -->
        <div class="col-md-3">
          <div class="text-center">
            <?php
              if(!empty($current_user['image'])) {
                echo('<img class="avatar img-circle" src="data:image;base64,' . $current_user['image'] . '">');
              } else {
                echo('<img class="avatar img-circle" src="assets/images/user_img.png">');
              } 
             ?>
            <h6>Upload a different photo...</h6>
            
            <input type="file" name="profile_image" class="form-control">
          </div>
        </div>
        
        <!-- edit form column -->
        <div class="col-md-9">
          <div class="alert alert-info alert-dismissable">
            <i class="glyphicon glyphicon-info-sign"></i> This is an <strong>.alert</strong>. Use this to show important messages to the user.
          </div>

          <h3>Personal info</h3>
          <div class="row form-group">
            <label class="col-lg-3 control-label">First name:</label>
            <div class="col-lg-8">
              <input type="text" name="first_name" class="form-control" id="" value="<?php echo($first_name); ?>" placeholder="First Name">
            </div>
          </div>
          <div class="row form-group">
            <label class="col-lg-3 control-label">Last name:</label>
            <div class="col-lg-8">
              <input type="text" name="last_name" class="form-control" id="" value="<?php echo($last_name); ?>" placeholder="Last Name">
            </div>
          </div>
          <div class="row form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
              <input type="email" name="email" class="form-control" id="" value="<?php echo($email); ?>" placeholder="Email Address">
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label">Password:</label>
            <div class="col-md-8">
              <input type="password" name="password" class="form-control" id="" value="" placeholder="Password">
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label">Confirm Password:</label>
            <div class="col-md-8">
              <input type="password" name="confirm_password" class="form-control" id="" value="" placeholder="Password Confirmation">
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <button type="submit" class="btn btn-default">Save</button>
            </div>
          </div>
        </div>
    </div>
  </form>
</div>
<hr>
<?php
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  include("application.php");
?>