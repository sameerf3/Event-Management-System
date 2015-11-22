<?php
  session_start();
?>
e487fd81e647876d80d163f7f10977db4a74723ca991ee0873917698
e487fd81e647876d80d163f7f10977db4a74723ca991ee0873
<?php
	if(empty($_POST['email']) || empty($_POST['password'])) {
		setcookie("flash_danger", "Invalid Login or Email", time() + 3600);
		header("Location: index.php");
	} else {
		include("shared/config.php");
		$email = $_POST["email"];
		$password = $_POST["password"];
		$user = "SELECT * FROM users where password = sha2('$password', 224) and email = '$email'";

		$result = $conn->query($user);
		// var_dump($result); die();

		if($result->num_rows > 0) {
			$_SESSION["login_user"] = $email;
			setcookie("flash_success", "Log In Successfully", time() + 3600);
			header("Location: index.php");
		} else {
			setcookie("flash_danger", "Invalid Login or Email", time() + 3600);
			header("Location: index.php");
		}
		$conn->close();
	}
?>
