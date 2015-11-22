<?php
  ob_start(); // This is buffer area where cookies and session are set and again set to expire them
  session_start(); // If Session Variable is present on the page?
  include("authentication/authenticated_user.php");
  $event_id = $_GET["id"];
  require_once('class.event.php');
  $event = new Event($event_id);
  $event_field = $event->get_event();
  
?>
<div class="user_profile">
  <h1>Edit <?php echo $event_field["name"]; ?></h1>
  <hr>
  <form action="update_event.php?id=<?php echo $event_id; ?>" method="post" enctype="multipart/form-data">
    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Name</label>
          <input class="form-control" placeholder="Event Name" value="<?php echo($event_field["name"]); ?>" name="event_name" type="text" />  
        </div>
        <div class="form-group">
          <label>Price</label>
          <input class="form-control" placeholder="Price" value="<?php echo($event_field["price"]); ?>" name="event_price" type="text" />  
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea class="form-control" rows="7" placeholder="About Event" name="event_description"><?php echo($event_field["description"]); ?></textarea>
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
                $result_images = $event->get_event_all_images();
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
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  include("application.php");
?>