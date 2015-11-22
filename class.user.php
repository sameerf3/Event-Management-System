<?php 
	require_once("shared/class.config.php");
	class User extends Config {
		// public $param;

		public function __construct($user = "") {
			if (!empty($user)) {
    		$this->user = $user;
    	}
    }

    function __destruct() {
    	$conn = $this->get_connection();
    	$conn->close();
    }

		public function get_current_user() {
			try {
				$email = $this->user;
				$conn = $this->get_connection();
        $sql = "Select id, CONCAT(`first_name`, ' ', `last_name`) as 'name', first_name, last_name, email, image, admin from users where email = '$email' limit 1";
        $result = mysqli_query($conn, $sql);
        $field = mysqli_fetch_array($result);
		    return $field;
	    } catch (Exception $e) {
	    	echo "$e->getMessage();";
		  }
		}
		public function authenticate_user($email, $password) {
			try {
				$sql = "SELECT * FROM users where password = sha2('$password', 224) and email = '$email'";
				$conn = $this->get_connection();
				$result = $conn->query($sql);
		    return $result;
	    } catch (Exception $e) {
	    	echo "$e->getMessage();";
		  }
		}

		public function validate_uniqueness($email, $action) {
			try {
				if($action == "on_update") {
					$current_user_email = $this->user;
					$sql = 'select * from users where email = "' . $email . '" not in (select email from users where email != "' . $current_user_email . '")';	
				} else {
					$sql = 'select * from users where email = "' . $email . '"';	
				}
				
				$conn = $this->get_connection();
				$result = $conn->query($sql);
		    return $result;
	    } catch (Exception $e) {
	    	echo "$e->getMessage();";
		  }
		}

		public function update_user($first_name, $last_name, $email, $password, $image, $image_name) {
			try {
				$current_user_email = $this->user;
				if(!empty($image)) {
					$sql = "update users set first_name='$first_name', last_name = '$last_name', email = '$email', password = sha2('$password',224), image='$image', image_name='$image_name' where email = '$current_user_email'";
				} else {
					$sql = "update users set first_name='$first_name', last_name = '$last_name', email = '$email', password = sha2('$password',224) where email = '$current_user_email'";
				}
				$conn = $this->get_connection();
				$result = mysqli_query($conn, $sql);
		    return $result;
	    } catch (Exception $e) {
	    	echo "$e->getMessage();";
		  }
		}

		public function create_user($first_name, $last_name, $email, $password) {
			try {
				$current_user_email = $this->user;
				$sql = "insert into users (first_name, last_name, email, password)
				values('$first_name', '$last_name', '$email', sha2('$password',224))";
				$conn = $this->get_connection();
				$result = mysqli_query($conn, $sql);
		    return $result;
	    } catch (Exception $e) {
	    	echo "$e->getMessage();";
		  }
		}

		public function user_avatar($first_name, $last_name, $email, $password, $image, $image_name) {
			try {
				$current_user_email = $this->user;
				$sql = "update users set first_name='$first_name', last_name = '$last_name', email = '$email', password = sha2('$password',224), image='$image', image_name='$image_name' where email = '$current_user_email'";
				$conn = $this->get_connection();
				$result = mysqli_query($conn, $sql);
		    return $result;
	    } catch (Exception $e) {
	    	echo "$e->getMessage();";
		  }
		}
	}
?>