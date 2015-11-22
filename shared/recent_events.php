<blockquote><h2>Recent Events</h2></blockquote>
<div class="row">
  <?php 
    include("shared/config.php");
    $sql = "SELECT * FROM `event_categories` WHERE 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $event_id = str_replace(' ', '', $row["id"]);
        $event_image_sql = "SELECT * FROM `event_images` WHERE event_category_id = $event_id limit 1";
        $result_event_img = mysqli_query($conn, $event_image_sql);
        $field = mysqli_fetch_array($result_event_img);
    ?>
      <div class="col-sm-6 col-md-3">
        <div class="thumbnail">
          <?php
            if (!empty($field['event_image'])) {
              echo('<img src="data:image;base64,' . $field['event_image'] . '">');   
            } else {
              echo('<img style="height: 128px !important;" src="assets/images/notfound.png">');  
            }
          ?>
          <div class="caption">
            <h3><?php echo($row["name"]); ?></h3>
            <p><?php echo($row["description"]); ?></p>
            <hr />
            <p>
              <div class="row">
                <div class="col-md-6 col-xs-6">
                  <a href="show_event.php?id=<?php echo $row['id']; ?>" class="btn btn-primary" role="button">Show</a>
                </div>
                <div class="col-md-6 col-xs-6">
                  <blockquote class="blockquote-reverse">
                    <strong><?php echo($row["price"]); ?>$</strong>
                  </blockquote>
                </div>
              </div>
            </p>
          </div>
        </div>
      </div>
    <?php
      }
    } else {
        echo "<div class='alert alert-success'>No Events are present</div>";
    }
  ?>
</div>