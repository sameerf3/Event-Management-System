<?php
  ob_start(); // This is buffer area where cookies and session are set and again set to expire them
  session_start(); // If Session Variable is present on the page?
  include("authentication/authenticated_user.php");
?>
<div class="user_profile">
  <h1>Create a new Event</h1>
  <hr>
  <form action="create_event.php" method="post" enctype="multipart/form-data">
    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Name</label>
          <input class="form-control" placeholder="Event Name" name="event_name" type="text" />  
        </div>
        <div class="form-group">
          <label>Price</label>
          <input class="form-control" placeholder="Price" name="event_price" type="text" />  
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea class="form-control" rows="7" placeholder="About Event" name="event_description"></textarea>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-default">Create</button>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">Upload Event Images</div>
          <div class="panel-body">
            <input type="file" name="event_images[]" class="form-control" multiple="multiple">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<?php
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  include("application.php");
?>