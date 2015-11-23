<?php 
	require_once("shared/class.config.php");
	class Event extends Config {

		public function __construct($event_id = "") {
			if (!empty($event_id)) {
    		$this->event_id = $event_id;
			}
    }

		public function get_event() {
			try {
				$id = $this->event_id;
		    $event = "SELECT * FROM event_categories WHERE id=$id";
		    $conn = $this->get_connection();
		    $result = mysqli_query($conn, $event);
		    $field = mysqli_fetch_array($result);
		    return $field;
	    } catch (Exception $e) {
	    	echo "$e->getMessage();";
		  }
		}

		public function get_event_image($event_id) {
			try {
				$id = $event_id;
		    $event_image_sql = "SELECT * FROM `event_images` WHERE event_category_id = $id limit 1";
		    $conn = $this->get_connection();
		    $result_event_img = mysqli_query($conn, $event_image_sql);
		    $field_for_image = mysqli_fetch_array($result_event_img);
		    return $field_for_image;
	    } catch (Exception $e) {
	    	echo "$e->getMessage();";
		  }
		}

		public function get_recent_events() {
			try {
		    $sql = "SELECT * FROM event_categories limit 4";
		    $conn = $this->get_connection();
		    $result = $conn->query($sql);
	      return $result;
	    } catch (Exception $e) {
	    	echo "$e->getMessage();";
		  }
		}

		public function get_all_events($event_name = "") {
			try {
				if (!empty($event_name)) {
					$sql = "SELECT * FROM event_categories WHERE name LIKE '%". $event_name ."%'";
				} else {
					$sql = "SELECT * FROM event_categories";
				}
		    
		    $conn = $this->get_connection();
		    $result = $conn->query($sql);
	      return $result;
	    } catch (Exception $e) {
	    	echo "$e->getMessage();";
		  }
		}

		public function get_event_all_images() {
			try {
				$id = $this->event_id;
        $sql = "SELECT * FROM `event_images` WHERE event_category_id = $id";
        $conn = $this->get_connection();
        $result = $conn->query($sql);
	      return $result;
			} catch (Exception $e) {
				echo "$e->getMessage();";
			}
		}

		public function validate_uniqueness_event($event_param, $current_event_param = "", $action) {
			try {
				if($action == "on_update") {
        	$sql = 'SELECT * FROM `event_categories` WHERE name = "' . $event_param . '" not in (select name from event_categories where not name = "' . $current_event_param . '")';
      	} else {
      		$sql = 'SELECT * FROM event_categories WHERE name = "' . $event_param . '"';
      	}
        $conn = $this->get_connection();
        $result = mysqli_query($conn, $sql);
        return $result;
			} catch (Exception $e) {
				echo "$e->getMessage();";
			}
		}

		public function update_event($name, $description, $price) {
			try {
				$id = $this->event_id;
				$conn = $this->get_connection();
				$sql = "UPDATE `event_categories` SET `name`='$name', `description`='$description', `price`='$price' WHERE id = $id";
				$result = mysqli_query($conn, $sql);
				return $result;
			} catch (Exception $e) {
				echo "$e->getMessage();";
			}
		}

		public function create_event($name, $description, $price) {
			try {
				$conn = $this->get_connection();
				$sql = "INSERT INTO `event_categories`(`name`, `description`, `price`) VALUES ('$name','$description','$price')";
	      $result = mysqli_query($conn, $sql);
	      return $result;
      } catch (Exception $e) {
				echo "$e->getMessage();";
			}
		}

		public function save_event_images($img_tmp_name, $img_name, $event_id) {
			try {
				$id = $event_id;
				$conn = $this->get_connection();
				$sql = "INSERT INTO `event_images`(`event_category_id`, `event_image`, `event_image_name`) VALUES ($id,'$img_tmp_name','$img_name')";
	      $result_for_event_images = mysqli_query($conn, $sql);
	      return $result_for_event_images;
      } catch (Exception $e) {
				echo "$e->getMessage();";
			}
		}

		public function remove_image($image_id) {
			try {
				$sql = "DELETE FROM `event_images` WHERE id=$image_id";
				$conn = $this->get_connection();
	  		$result = mysqli_query($conn, $sql);
	  		return $result;
  		} catch (Exception $e) {
				echo "$e->getMessage();";
			}
		}

		public function remove_event($event_id) {
			try {
				$id = $event_id;
				$sql = "DELETE FROM `event_categories` WHERE id=$id";
				$conn = $this->get_connection();
	  		$result = mysqli_query($conn, $sql);
	  		return $result;
  		} catch (Exception $e) {
				echo "$e->getMessage();";
			}
		}

		public function get_last_id() {
			try {
				$conn = $this->get_connection();
				$sql = "SELECT id FROM `event_categories` order by id desc limit 1";
	  		$result = mysqli_query($conn, $sql);
	  		$id = mysqli_fetch_array($result);
	  		return $id;
  		} catch (Exception $e) {
				echo "$e->getMessage();";
			}
		}

		public function book_event($user_id, $description, $card_no, $card_code, $expiry_date) {
			try {
				$event_id = $this->event_id;
				$conn = $this->get_connection();
				$sql = "INSERT INTO `book_event`(`event_category_id`, `user_id`, `description`, `card_no`, `card_code`, `expiry_date`) 
								VALUES ('$event_id','$user_id','$description','$card_no','$card_code','$expiry_date')";
	  		$result = mysqli_query($conn, $sql);
	  		return $result;
  		} catch (Exception $e) {
				echo "$e->getMessage();";
			}
		}
	}
?>