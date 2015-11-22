<?php
  ob_start(); // This is buffer area where cookies and session are set and again set to expire them
  session_start(); // If Session Variable is present on the page?
  include("authentication/authenticated_user.php");
  include("shared/config.php");
  $email = $_SESSION["login_user"];
  $sql = "Select * from users where email = '$email' limit 1";
  $result = mysqli_query($conn, $sql);
  $field = mysqli_fetch_array($result);
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
              if(!empty($field['image'])) {
                echo('<img class="avatar img-circle" src="data:image;base64,' . $field['image'] . '">');
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
              <input type="text" name="first_name" class="form-control" id="" value="<?php echo($field['first_name']); ?>" placeholder="First Name">
            </div>
          </div>
          <div class="row form-group">
            <label class="col-lg-3 control-label">Last name:</label>
            <div class="col-lg-8">
              <input type="text" name="last_name" class="form-control" id="" value="<?php echo($field['last_name']); ?>" placeholder="Last Name">
            </div>
          </div>
          <div class="row form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
              <input type="email" name="email" class="form-control" id="" value="<?php echo($field['email']); ?>" placeholder="Email Address">
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
  $conn->close();
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  include("application.php");
?>