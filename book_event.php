<?php
  ob_start(); // This is buffer area where cookies and session are set and again set to expire them
  session_start(); // If Session Variable is present on the page?
  include("authentication/authenticated_user.php")
?>
<div class="page-header">
	<h1>Book an Event</h1>
</div>
<?php
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  include("application.php");
?>