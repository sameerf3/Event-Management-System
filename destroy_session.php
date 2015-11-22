<?php
  //Buffer larger content areas like the main page content
  session_start();
  session_destroy();
  setcookie("flash_success", "Logged out successfully", time() + 3600);
	header("Location: index.php");
?>