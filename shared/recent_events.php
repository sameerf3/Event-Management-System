<div class="row">
  <?php 
    include("shared/config.php");
    $sql = "SELECT * FROM `event_cateory` WHERE 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
    ?>
      <div class="col-sm-6 col-md-3">
        <div class="thumbnail">
          <img src="http://www.nimba.in/wp-content/uploads/2014/12/upcoming-events-demo-wallpaper.jpg" alt="...">
          <div class="caption">
            <h3><?php echo($row["name"]); ?></h3>
            <p><?php echo($row["description"]); ?></p>
            <p><a href="#" class="btn btn-primary" role="button">Book</a></p>
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