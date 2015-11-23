<?php
	session_start(); // If Session Variable is present on the page?
  include("authentication/authenticated_user.php");
  $book_event_id = $_GET["id"];
  // echo $event_image_id . " " . $event_id; die();
  require_once('class.user.php');
  $user = new User;
  $result = $user->remove_user_events($book_event_id);
  if($result) {
    setcookie("flash_success", "You Removed your Booked Event.", time() + 3600);
    header("Location: user_events.php");
  } else {
    setcookie("flash_danger", "Something went wrong", time() + 3600);
    header("Location: user_events.php");
  }
?>