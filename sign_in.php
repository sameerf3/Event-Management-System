<div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Login to your account</h4>
      </div>
      <div class="modal-body">
        <div class="row">
				  <div class="col-md-6">
				    <div class="well">
				      <form id="loginForm" method="POST" action="sessions.php">
				        <div class="form-group">
				            <label for="email" class="control-label">Email</label>
				            <input type="email" class="form-control" id="email" name="email" value="" required="true" title="Please enter your email" placeholder="example@gmail.com">
				            <span class="help-block"></span>
				        </div>
				        <div class="form-group">
				            <label for="password" class="control-label">Password</label>
				            <input type="password" class="form-control" id="password" name="password" value="" required="true" title="Please enter your password">
				            <span class="help-block"></span>
				        </div>
				        <div class="checkbox">
				          <label>
				              <input type="checkbox" name="remember" id="remember"> Remember login
				          </label>
				          <p class="help-block">(if this is a private computer)</p>
				        </div>
				        <button type="submit" class="btn btn-success btn-block">Login</button>
				      </form>
				    </div>
				  </div>
				  <div class="col-md-6">
			      <p class="lead">Register now for <span class="text-success">FREE</span></p>
			      <ul class="list-unstyled" style="line-height: 2">
		          <li><span class="glyphicon glyphicon-ok text-success"></span> See all your orders</li>
		          <li><span class="glyphicon glyphicon-ok text-success"></span> Fast re-order</li>
		          <li><span class="glyphicon glyphicon-ok text-success"></span> Save your favorites</li>
		          <li><span class="glyphicon glyphicon-ok text-success"></span> Fast checkout</li>
		          <li><span class="glyphicon glyphicon-ok text-success"></span> Get a gift <small>(only new customers)</small></li>
		          <li><a href="about.php"><u>Read more</u></a></li>
			      </ul>
			      <p><a href="sign_up.php" class="btn btn-info btn-block">Register for free!</a></p>
				  </div>
				</div>
      </div>
    </div>
  </div>
</div>