<?php
	session_start(); // If Session Variable is present on the page?
  include("authentication/authenticated_user.php");
  $event_id = $_GET["id"];
  // echo $event_image_id . " " . $event_id; die();
  require_once('class.event.php');

  $event = new Event;
  $result = $event->remove_event($event_id);
  if($result == true) {
    setcookie("flash_success", "Event Removed", time() + 3600);
    header("Location: manage_events.php");
  } else {
    setcookie("flash_danger", "Something went wrong", time() + 3600);
    header("Location: manage_events.php");
  }
?>