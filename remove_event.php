<?php
	session_start(); // If Session Variable is present on the page?
  include("authentication/authenticated_user.php");
  include("shared/config.php");
  $event_id = $_GET["id"];
  // echo $event_image_id . " " . $event_id; die();
  $event_image = "DELETE FROM `event_categories` WHERE id=$event_id";
  $result = mysqli_query($conn, $event_image);
  if($result == true) {
    setcookie("flash_success", "Event Removed", time() + 3600);
    header("Location: manage_events.php");
  } else {
    setcookie("flash_danger", "Something went wrong", time() + 3600);
    header("Location: manage_events.php");
  }
?>