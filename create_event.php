<?php
  ob_start(); // This is buffer area where cookies and session are set and again set to expire them
  session_start(); // If Session Variable is present on the page?
  include("authentication/authenticated_user.php");

  function validateForm($event_name_param, $event_name_price, $event_name_description) {
    $errors = array();
    include("shared/config.php");
    if($event_name_param == ""){
      array_push($errors, "Name is required");
    }
    if($event_name_price == ""){
      array_push($errors, "Price is required");
    }
    if($event_name_description == "") {
      array_push($errors, "Description is required");
    }
    $user = "Select * from event_categories where name = '$event_name_param'";
    $result = $conn->query($user);
    if($result->num_rows > 0) {
      array_push($errors, "This Event is already created");
      $conn->close();
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
    $name = $_POST["event_name"];
    $price = $_POST["event_price"];
    $description = $_POST["event_description"];
    $event_images = $_FILES["event_images"]["name"];
    include("shared/config.php");
    if(validateForm($name, $price, $description)[1] == "true") {
      echo "<div class='alert alert-danger'>";
      echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
      echo "<ul>";
      $errors_length = count(validateForm($name, $price, $description)[0]);
      for($x = 0; $x < $errors_length; $x++) {
        echo "<li>" . validateForm($name, $price, $description)[0][$x] . "</li>";
      }
      echo "</ul>";
      echo "</div>";
    } else {
      

      $sql_event = "INSERT INTO `event_categories`(`name`, `description`, `price`) VALUES ('$name','$description','$price')";
      $result_for_event = mysqli_query($conn, $sql_event);
      if($result_for_event == true) {
        $event_id = mysqli_insert_id($conn);
        for($i = 0; $i < count($event_images); $i++) {

          $img_tmp_name = addslashes($_FILES['event_images']['tmp_name'][$i]); 
          $img_name = addslashes($event_images[$i]);

          $img_tmp_name = file_get_contents($img_tmp_name);
          $img_tmp_name = base64_encode($img_tmp_name);
          if($img_tmp_name == "") {
            $remove_inserted_event = "DELETE FROM `event_categories` WHERE id=$event_id";
            $result_for_removed_event = mysqli_query($conn, $remove_inserted_event);
            if($result_for_removed_event == true) {
              setcookie("flash_danger", "Please Select Images", time() + 3600);
              header("Location: new_event.php"); 
            }
          } else {
            $sql_event_images = "INSERT INTO `event_images`(`event_category_id`, `event_image`, `event_image_name`) VALUES ($event_id,'$img_tmp_name','$img_name')";

            $result_for_event_images = mysqli_query($conn, $sql_event_images);
            if($result_for_event_images == true) {
              setcookie("flash_danger", "Event Saved Successfully", time() + 3600);
              header("Location: manage_events.php");
            } else {
              setcookie("flash_danger", "Something went wrong", time() + 3600);
              header("Location: new_event.php");
            }
          }
        }
      } else {
        setcookie("flash_danger", "Something went wrong", time() + 3600);
        header("Location: new_event.php");
      }
    }
  }
?>
<div class="user_profile">
  <h1>Create a new Event</h1>
  <hr>
  <form action="create_event.php" method="post" enctype="multipart/form-data">
    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Name</label>
          <input class="form-control" placeholder="Event Name" name="event_name" type="text" />  
        </div>
        <div class="form-group">
          <label>Price</label>
          <input class="form-control" placeholder="Price" name="event_price" type="text" />  
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea class="form-control" rows="7" placeholder="About Event" name="event_description"></textarea>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-default">Create</button>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">Upload Event Images</div>
          <div class="panel-body">
            <input type="file" name="event_images[]" class="form-control" multiple="multiple">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<?php
  $conn->close();
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  include("application.php");
?>