<?php 
	ob_start(); // This is buffer area where cookies and session are set and again set to expire them 
	session_start();
	include("authentication/is_user_signed_in.php")
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
						<input type="text" name="first_name" class="form-control" id="" value="" placeholder="First Name">
					</div>
					<div class="form-group col-lg-6">
						<label>Last Name</label>
						<input type="text" name="last_name" class="form-control" id="" value="" placeholder="Last Name">
					</div>
					<div class="form-group col-lg-12">
						<label>Email Address</label>
						<input type="email" name="email" class="form-control" id="" value="" placeholder="Email Address">
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