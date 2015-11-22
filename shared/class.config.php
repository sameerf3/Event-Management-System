<?php 
	class Config {
		public function get_connection() {
			$servername="localhost";
			$username="root";
			$password="";
			$dbname = "event";
			
			$conn = new mysqli($servername, $username, $password, $dbname);
			
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}	

			return $conn;
		}
	}
 ?>