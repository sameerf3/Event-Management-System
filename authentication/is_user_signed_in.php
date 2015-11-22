<?php 
	if(isset($_SESSION["login_user"])) {
		setcookie("flash_danger", "You are already signed in", time() + 3600);
		header("Location: index.php");
	}
?>