<?php 
	if(empty($_SESSION["login_user"])) {
		setcookie("flash_danger", "You need to sign in", time() + 3600);
		header("Location: index.php");
	}
?>