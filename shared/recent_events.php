<?php
  require_once('class.event.php');
  $event = new Event;
  $events = $event->get_all_events();
?>
<blockquote><h2>Recent Events</h2></blockquote>
<div class="row">
  <?php
    if ($events->num_rows > 0) {
      // output data of each row
      while($row = $events->fetch_assoc()) {
        $event_image_field = $event->get_event_image($row["id"]);
    ?>
      <div class="col-sm-6 col-md-3">
        <div class="thumbnail">
          <?php
            if (!empty($event_image_field['event_image'])) {
              echo('<img src="data:image;base64,' . $event_image_field['event_image'] . '">');   
            } else {
              echo('<img style="height: 128px !important;" src="assets/images/notfound.png">');  
            }
          ?>
          <div class="caption">
            <h3><?php echo($row["name"]); ?></h3>
            <?php $description = (strlen($row["description"]) > 13) ? substr($row["description"],0,150).'...' : $row["description"]; ?>
            <p><?php echo($description); ?></p>
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