<?php
	ob_start(); // This is buffer area where cookies and session are set and again set to expire them 
	session_start();
	include("authentication/is_user_signed_in.php");
	require_once('class.user.php');
	$user = new User;

	function validateForm($__initialized_user, $email_param, $password_param, $confirm_password_param) {
		$errors = array();

    if($email_param == ""){
    	array_push($errors, "Email is required");
    }
    if($password_param == ""){
    	array_push($errors, "Password is required");
    }
		// Validating Uniqueness
    $result = $__initialized_user->validate_uniqueness($email_param, "on_create");
    if($result->num_rows > 0) {
      array_push($errors, "This Email has already been taken");
    }

    if($password_param != $confirm_password_param) {
    	array_push($errors, "Password Confiramtion is not matched with password");
    }
    $password_length = strlen($password_param);
    if($password_length <= 8) {
    	array_push($errors, "Password must be of at least 8 characters");
    }
    $return_values = array($errors);
    if(count($errors) > 0) {
  		array_push($return_values, "true");
  	 	return $return_values;
    } else {
    	array_push($return_values, "false");
    	return $return_values;
    }
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$first_name = $_POST["first_name"];
		$last_name = $_POST["last_name"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$confirm_password = $_POST["confirm_password"];

		if(validateForm($user, $email, $password, $confirm_password)[1] == "true") {
			echo "<div class='alert alert-danger'>";
			echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
			echo "<ul>";
			$errors_length = count(validateForm($user, $email, $password, $confirm_password)[0]);
			for($x = 0; $x < $errors_length; $x++) {
				echo "<li>" . validateForm($user, $email, $password, $confirm_password)[0][$x] . "</li>";
			}
			echo "</ul>";
			echo "</div>";
		} else {
			$pw = str_replace(' ', '', $password);
			$result = $user->create_user($first_name, $last_name, $email, $pw);
			
			if ($result == TRUE) {
				$_SESSION["login_user"] = $email;
				setcookie("flash_success", "Your account has been created successfully.", time() + 3600);
				header("Location: index.php");
			} else {
				setcookie("flash_danger", "Something went wrong", time() + 3600);
				header("Location: sign_up.php");
			}
			
		}
	}
?>
<div class="page-header">
	<h1>Create a new account</h1>
</div>
<div class="">
  <section class="row">
		<div class="row">				
			<div class="col-md-6">
				<form action="registrations.php" method="post">
					<div class="form-group col-lg-6">
						<label>First Name</label>
						<input type="text" name="first_name" class="form-control" id="" value="<?php echo $first_name;?>" placeholder="First Name">
					</div>
					<div class="form-group col-lg-6">
						<label>Last Name</label>
						<input type="text" name="last_name" class="form-control" id="" value="<?php echo $last_name;?>" placeholder="Last Name">
					</div>
					<div class="form-group col-lg-12">
						<label>Email Address</label>
						<input type="email" name="email" class="form-control" id="$email" value="<?php echo $email;?>" placeholder="Email Address">
					</div>
					<div class="form-group col-lg-6">
						<label>Password</label>
						<input type="password" name="password" class="form-control" id="" value="" placeholder="Password">
					</div>
					
					<div class="form-group col-lg-6">
						<label>Repeat Password</label>
						<input type="password" name="confirm_password" class="form-control" id="" value="" placeholder="Password Confirmation">
					</div>
					<div class="form-group col-lg-12">
						<button type="submit" class="btn btn-success">Register</button>
					</div>
				</form>
			</div>
		
			<div class="col-md-6">
				<div class="panel panel-warning">
					<div class="panel-heading">
						<div class="panel-title">Terms and Conditions</div>
					</div>
					<div class="panel-body">
						<p>
							By clicking on "Register" you agree to The Company's' Terms and Conditions
						</p>
						<p>
							While rare, prices are subject to change based on exchange rate fluctuations - 
							should such a fluctuation happen, we may request an additional payment. You have the option to request a full refund or to pay the new price. (Paragraph 13.5.8)
						</p>
						<p>
							Should there be an error in the description or pricing of a product, we will provide you with a full refund (Paragraph 13.5.6)
						</p>
						<p>
							Acceptance of an order by us is dependent on our suppliers ability to provide the product. (Paragraph 13.5.6)
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<?php
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  include("application.php");
?>


