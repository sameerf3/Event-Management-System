<?php
	require_once('class.event.php');
	$event_id = $_GET["event_id"];
  $user_id = $_GET["user_id"];
  $description = $_POST["description"];
  $card_no = $_POST["card_no"];
  $card_code_no = $_POST["card_code_no"];
  $card_expiry_date = $_POST["card_expiry_date"];
  $event = new Event($event_id);
  if(empty($card_no) || empty($card_code_no) || empty($card_expiry_date)) {
  	setcookie("flash_danger", "Please fill booking form correctly", time() + 3600);
		header("Location: show_event.php?id=" . $event_id);
  } else {
  	$result = $event->book_event($user_id, $description, $card_no, $card_code_no, $card_expiry_date);
  	if ($result == true) {
  		setcookie("flash_success", "Thanks for booking our event. We will contact you very soon.", time() + 3600);
			header("Location: index.php");
  	} else {
  		die();
  	}
  }
?>