<?php
  session_start();
?>
<?php
	if(empty($_POST['email']) || empty($_POST['password'])) {
		setcookie("flash_danger", "Invalid Login or Email", time() + 3600);
		header("Location: index.php");
	} else {
		$email = $_POST["email"];
		$password = $_POST["password"];
		// var_dump($result); die();
		require_once('class.user.php');
		$user = new User;
    $users = $user->authenticate_user($email, $password);

		if($users->num_rows > 0) {
			$_SESSION["login_user"] = $email;
			setcookie("flash_success", "Log In Successfully", time() + 3600);
			header("Location: index.php");
		} else {
			setcookie("flash_danger", "Invalid Login or Email", time() + 3600);
			header("Location: index.php");
		}
	}
?>
