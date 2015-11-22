<?php
  ob_start();
  session_start();
  include("authentication/authenticated_user.php");
?>
<div class="page-header">
  <h1>
  	Manage Events
  	<a href="new_event.php" class="btn btn-info pull-right">Add New</a>
	</h1>
</div>
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>Picture</th>
			<th colspan="2"></th>
		</tr>
	</thead>
	<tbody>
		<?php 
	    include("shared/config.php");
	    try {
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
		    	<tr>
						<td><?php echo($row["name"]); ?></td>
						<td><?php echo($row["description"]); ?></td>
						<td>
							<a href="#" data-toggle="popover" title="Title Picture" data-content='
								<a href="#" class="thumbnail" >
                  <?php 
                  	if (!empty($field['event_image'])) {
                  		echo('<img class="event_images" src="data:image;base64,' . $field['event_image'] . '">'); 	
                  	} else {
                  		echo('<img class="event_images" src="assets/images/notfound.png">'); 	
                  	}
                	?>
                </a>'
              >View Image</a>
              </td>
						<td><a href='edit_event.php?id=<?php echo($row["id"]); ?>'>Edit</a></td>
						<td><a href="remove_event.php?id=<?php echo($row["id"]); ?>" onclick="return confirm('Are you sure?');">Remove</a></td>
					</tr>
		    <?php
		      }
		    } else {
		        echo "<div class='alert alert-success'>No Events are present</div>";
		    }
	    } catch (Exception $e) {
	    	echo "<div class='alert alert-danger'>". $e->getMessage() ."</div>";
	    }
	  ?>
	</tbody>
</table>
<script type="text/javascript">
  $(function () {
    $('[data-toggle="popover"]').popover({
      placement: "top",
      html: true,
      trigger: "hover"
    });
  })
</script>
<?php
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  include("application.php");
?>