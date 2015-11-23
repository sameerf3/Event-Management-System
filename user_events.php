<?php
	ob_start();
	// If Session Variable is present on the page?
  session_start();
  
  require_once('class.user.php');
  if(isset($_SESSION["login_user"])) {
    $email = $_SESSION["login_user"];
    $user = new User($email);
    $user_field = $user->get_current_user();
    $user_events = $user->user_events($user_field["id"]);
  }
?>
<div class="page-header">
	<h1>My Events</h1>
</div>
<?php
  if ($user_events->num_rows > 0) { ?>
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Name</th>
        <th>Theme</th>
        <th>Price</th>
        <th>Description</th>
        <th></th>
        <th colspan="2"></th>
      </tr>
    </thead>
    <tbody>
    <?php
      // output data of each row
      while($row = $user_events->fetch_assoc()) {
        require_once('class.event.php');
        $event = new Event($row["event_category_id"]);
        $event_field = $event->get_event();

        $description = (strlen($event_field["description"]) > 13) ? substr($event_field["description"],0,150).'...' : $event_field["description"];
      ?>
        <tr>
          <td><?php echo($event_field["name"]); ?></td>
          <th>---</th>
          <td><?php echo($event_field["price"]); ?>$</td>
          <td><?php echo($description); ?></td>
          <td><a href="remove_user_event.php?id=<?php echo($row["id"]); ?>" onclick="return confirm('Are you sure?');" method="delete">Remove</a></td>
        </tr>
      <?php
        }
      } else {
        echo "<div class='alert alert-success'>No Events are present</div>";
      }
    ?>
  </tbody>
</table>
<?php
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  include("application.php");
?>