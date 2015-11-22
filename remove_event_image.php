<?php
	session_start(); // If Session Variable is present on the page?
  include("authentication/authenticated_user.php");
  include("shared/config.php");
  $event_image_id = $_GET["id"];

  $event_id = $_GET["event_id"];
  // echo $event_image_id . " " . $event_id; die();
  $event_image = "DELETE FROM `event_images` WHERE id=$event_image_id";
  $result = mysqli_query($conn, $event_image);
  if($result == true) {
    setcookie("flash_success", "Image Removed", time() + 3600);
    header("Location: edit_event.php?id=" . $event_id);
  } else {
    setcookie("flash_danger", "Something went wrong", time() + 3600);
    header("Location: manage_events.php");
  }
?>