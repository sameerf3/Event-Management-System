<html>
	<head>
		<title>Event Management System</title>
		<script src="assets/js/jQuery.js"></script>
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-theme.css">
		<link rel="stylesheet" type="text/css" href="assets/css/home.css">
		<script src="assets/js/bootstrap.js"></script>
	</head>
	<body>
		<header>
			<?php include("shared/navigation.php") ?>
		</header>
		<div class="container">
			<?php 
				include("shared/messages.php");
				echo($pagemaincontent);
			?>
		</div>
		<footer>
			<?php include("shared/footer.php") ?>
		</footer>
		<?php include("sign_in.php") ?>

	</body>
</html>