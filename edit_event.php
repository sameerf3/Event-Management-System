<?php
  ob_start(); // This is buffer area where cookies and session are set and again set to expire them
  session_start(); // If Session Variable is present on the page?
  include("authentication/authenticated_user.php");
  include("shared/config.php");
  $event_id = 0;
  $event_id = $_GET["id"];
  $event = "SELECT * FROM `event_categories` WHERE id=$event_id";
  $result = mysqli_query($conn, $event);
  if($result == true) {
    $field = mysqli_fetch_array($result);
  } else {
    setcookie("flash_danger", "Something went wrong", time() + 3600);
    header("Location: manage_events.php");
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
          <input class="form-control" placeholder="Event Name" value="<?php echo($field["name"]); ?>" name="event_name" type="text" />  
        </div>
        <div class="form-group">
          <label>Price</label>
          <input class="form-control" placeholder="Price" value="<?php echo($field["price"]); ?>" name="event_price" type="text" />  
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea class="form-control" rows="7" placeholder="About Event" name="event_description">
            <?php echo($field["description"]); ?>
          </textarea>
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
                  $event_images = "SELECT `event_image`, `event_image_name` FROM `event_images` WHERE event_category_id=$event_id";
                  $result_images = mysqli_query($conn, $event_images);
                  if ($result_images->num_rows > 0) {
                    while($row = $result_images->fetch_assoc()) {
                  ?>
                    <div class="col-xs-4">
                      <a href="#" class="thumbnail">
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