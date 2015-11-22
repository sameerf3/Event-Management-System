<?php if(!empty($_COOKIE["flash_success"])) { ?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	</button>
	<?php echo("<strong>" . $_COOKIE["flash_success"] . "</strong>"); setcookie("flash_success", "", time() - 3600); ?>
</div>
<?php } else if (!empty($_COOKIE["flash_danger"])) { ?>
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	</button>
	<?php echo("<strong>" . $_COOKIE["flash_danger"] . "</strong>"); setcookie("flash_danger", "", time() - 3600); ?>
</div>
<?php } ?>