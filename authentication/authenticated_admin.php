<?php 
	if(!empty($_SESSION["login_user"])) {
		require_once('class.user.php');
    $email = $_SESSION["login_user"];
    $user = new User($email);
    $user_field = $user->get_current_user();
    if($user_field["admin"] != true) {
			setcookie("flash_danger", "This area is authenticated for admin users only.", time() + 3600);
			header("Location: index.php");
		}
	}
?>