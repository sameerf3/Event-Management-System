<?php
  ob_start(); // This is buffer area where cookies and session are set and again set to expire them
  session_start(); // If Session Variable is present on the page?
  include("authentication/authenticated_user.php");
  include("shared/config.php");
  $event_id = $_GET["id"];
  $event = "SELECT * FROM `event_categories` WHERE id=$event_id";
  $result = mysqli_query($conn, $event);
  if($result == true) {
    $field = mysqli_fetch_array($result);
  } else {
    setcookie("flash_danger", "Something went wrong", time() + 3600);
    header("Location: manage_events.php");
  }
  function validateForm($event_name_param, $event_name_price, $event_name_description, $field_name_param) {
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
    $current_event = 'SELECT * FROM `event_categories` WHERE name = "$event_name_param" not in (select name from event_categories where not name = "$field_name_param")';
    
    $result_current_event = $conn->query($current_event);
    if($result_current_event->num_rows > 0) {
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
    if(validateForm($name, $price, $description, $field["name"])[1] == "true") {
      echo "<div class='alert alert-danger'>";
      echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
      echo "<ul>";
      $errors_length = count(validateForm($name, $price, $description, $field["name"])[0]);
      for($x = 0; $x < $errors_length; $x++) {
        echo "<li>" . validateForm($name, $price, $description, $field["name"])[0][$x] . "</li>";
      }
      echo "</ul>";
      echo "</div>";
    } else {
      

      $sql_event = "UPDATE `event_categories` SET `name`='$name',`description`='$description',`price`='$price' WHERE id = $event_id";
      $result_for_event = mysqli_query($conn, $sql_event);
      if($result_for_event == true) {
        if(!empty($_FILES["event_images"]["name"][0])) {
          for($i = 0; $i < count($event_images); $i++) {

            $img_tmp_name = addslashes($_FILES['event_images']['tmp_name'][$i]); 
            $img_name = addslashes($event_images[$i]);

            $img_tmp_name = file_get_contents($img_tmp_name);
            $img_tmp_name = base64_encode($img_tmp_name);
            $sql_event_images = "INSERT INTO `event_images`(`event_category_id`, `event_image`, `event_image_name`) VALUES ($event_id,'$img_tmp_name','$img_name')";

            $result_for_event_images = mysqli_query($conn, $sql_event_images);
          }
          if($result_for_event_images == true) {
            setcookie("flash_success", "Event Saved Successfully with Images", time() + 3600);
            header("Location: manage_events.php");
          } else {
            setcookie("flash_danger", "Something went wrong", time() + 3600);
            header("Location: edit_event.php?id". $event_id);
          }
        }
        setcookie("flash_success", "Event Updated Successfully", time() + 3600);
        header("Location: manage_events.php");
      } else {
        setcookie("flash_danger", "Something went wrong", time() + 3600);
        header("Location: edit_event.php?id". $event_id);
      }
    }
  }
?>
<div class="user_profile">
  <h1>Edit <?php echo $field["name"]; ?></h1>
  <hr>
  <form action="update_event.php?id=<?php echo $event_id; ?>" method="post" enctype="multipart/form-data">
    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Name</label>
          <input class="form-control" placeholder="Event Name" value='<?php echo($name != "" ? $name : $field["name"]); ?>' name="event_name" type="text" />  
        </div>
        <div class="form-group">
          <label>Price</label>
          <input class="form-control" placeholder="Price" value="<?php echo($price != "" ? $price : $field["price"]); ?>" name="event_price" type="text" />  
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea class="form-control" rows="7" placeholder="About Event" name="event_description"><?php echo($description != "" ? $description : $field["description"]); ?></textarea>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-default">Update</button>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">Update Event Images</div>
          <div class="panel-body">
            <div class="row">
              <?php 
                try {
                  $event_images = "SELECT `id`, `event_image`, `event_image_name` FROM `event_images` WHERE event_category_id=$event_id";
                  $result_images = mysqli_query($conn, $event_images);
                  if ($result_images->num_rows > 0) {
                    while($row = $result_images->fetch_assoc()) {
                  ?>
                    <div class="col-xs-4" data-toggle="tooltip" data-placement="left" title="Click for options">
                      <a href="#" class="thumbnail" data-toggle="popover" data-content="<a onclick='return confirm('Are you sure?');' href='remove_event_image.php?id=<?php echo($row['id']); ?>&event_id=<?php echo($event_id); ?>'><i class='glyphicon glyphicon-trash'></i> Remove</a>">
                        <?php echo('<img class="event_images" src="data:image;base64,' . $row['event_image'] . '">'); ?>
                      </a>
                    </div>
                  <?php
                    }
                  } else {
                    echo '<div class="col-xs-12 col-md-12">';
                    echo "<div class='alert alert-success'>No Events Images are present</div>";
                    echo '</div>';
                  }
                } catch(Exception $e) {
                  echo "<div class='alert alert-danger'>". $e->getMessage() ."</div>";
                }
              ?>
            </div>
            <script type="text/javascript">
              $(function () {
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="popover"]').popover({
                  placement: "top",
                  html: true,
                  trigger: "focus"
                });
              })
            </script>
          </div>
          <div class="panel-footer">
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