<?php
  ob_start();
  session_start();
?>
<div class="page-header">
  <h1>Contact Us</h1>
</div>
<div class="container">
	<form class="well">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label>First Name</label> 
          <input placeholder="Your First Name" type="text" class="form-control">
        </div>
        <div class="form-group">
          <label>Last Name</label>
          <input placeholder="Your Last Name" type="text" class="form-control">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input placeholder="Your Emal Address" type="text" class="form-control">
        </div>
        <div class="form-group">
          <label>Subject</label>
          <select id="subject" name="subject" class="form-control">
              <option selected value="">
                  Choose One:
              </option>

              <option value="service">
                  General Customer Service
              </option>

              <option value="suggestions">
                  Suggestions
              </option>

              <option value="product">
                  Product Support
              </option>
          </select>
        </div>
      </div>

      <div class="col-md-9">
          <label>Message</label> 
          <textarea name="message" class="form-control" rows="13"></textarea>
      </div>
    </div>
    <button class="btn btn-primary btn-lg" type="submit">Send Request</button>
  </form>
</div>
<?php
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  include("application.php");
?>