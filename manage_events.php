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
<table class="table table-striped">
	<thead>
		<tr>
			<td>Name</td>
			<td>Description</td>
			<td>Picture</td>
			<td colspan="2"></td>
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
		    ?>
		    	<tr>
						<td><?php echo($row["name"]); ?></td>
						<td><?php echo($row["description"]); ?></td>
						<td>Picture</td>
						<td><a href='edit_event.php?id=<?php echo($row["id"]); ?>'>Edit</a></td>
						<td><a href="events/remove_event.php">Remove</a></td>
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
<?php
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  include("application.php");
?>