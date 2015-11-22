<?php
  ob_start();
  session_start();
  $event_id = $_GET["id"];
  require_once('class.event.php');
  $event = new Event($event_id);
  $event_field = $event->get_event();
  $event_image_field = $event->get_event_image($event_id);
?>

<div class="page-header">
  <div class="row">
    <div class="col-md-6">
      <blockquote>
        <p style="font-size: 92px;"><?php echo $event_field["name"]; ?></p>
      </blockquote>
    </div>
    <div class="col-md-6">
      <a href="#" class="thumbnail pull-right" style="width: 48%;">
        <img src="data:image;base64,<?php echo $event_image_field['event_image']; ?>">
      </a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-7">
    <div class="panel panel-success">
      <div class="panel-heading">Please take a look on our new Event's setup</div>
      <div class="panel-body">
        <div class="row">
          <?php 
            $result_images = $event->get_event_all_images();
            if ($result_images->num_rows > 0) {
              while($row = $result_images->fetch_assoc()) {
            ?>
              <div class="col-xs-4">
                <div id="links">
                  <a data-toggle="tooltip" data-placement="top" title="Click to View" href="data:image;base64, <?php echo $row['event_image']; ?>" title="<?php echo $row['event_image_name']; ?>" data-gallery class="thumbnail" >
                    <?php echo('<img title="" class="event_images" src="data:image;base64,' . $row['event_image'] . '">'); ?>
                  </a>
                </div>
              </div>
            <?php
              }
            } else {
              echo '<div class="col-xs-12 col-md-12">';
              echo "<div class='alert alert-success'>No Events Images are present</div>";
              echo '</div>';
            }
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-5">
    <div class="panel panel-warning">
      <div class="panel-heading">Book & Details</div>
      <div class="panel-body">

        <ul class="nav nav-tabs" id="book_and_details_tab" role="tablist">
          <li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab"><strong>Details</strong></a></li>
          <li role="presentation"><a href="#book" aria-controls="book" role="tab" data-toggle="tab"><strong>Book</strong></a></li>
        </ul>
        <br />

        <div class="tab-content">
          <div role="tabpanel" class="tab-pane fade in active" id="details">
            <p style="font-size: 26px;">About Event</p>
            <hr />
            <blockquote class="blockquote-reverse">
              <p style="font-size: 46px;">Price: <?php echo $event_field["price"]; ?>$</p>
            </blockquote>
            <blockquote>
              <p style="font-size: 25px;"><?php echo $event_field["description"]; ?></p>
            </blockquote>
          </div>
          <div role="tabpanel" class="tab-pane" id="book">
            <?php 
              if(isset($_SESSION["login_user"])) { 
                include("book_event.php");
              } else {
            ?>
              <div class="alert alert-success">Please Login or Register to Book this event</div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('#book_and_details_tab a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    })
  });
</script>
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-use-bootstrap-modal="true">
  <!-- The container for the modal slides -->
  <div class="slides"></div>
  <!-- Controls for the borderless lightbox -->
  <h3 class="title"></h3>
  <a class="prev">‹</a>
  <a class="next">›</a>
  <a class="close">×</a>
  <a class="play-pause"></a>
  <ol class="indicator"></ol>
</div>  
<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">

<?php
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  include("application.php");
?>