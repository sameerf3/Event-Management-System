<blockquote>
	<p style="font-size: 46px;">Book Now</p>	
</blockquote>

<div class="form-group">
	<label>Credit Card Number</label>
	<input class="form-control" id="card_no" placeholder="9999 9999 9999 9999" type="text" />
</div>
<div class="form-group">
	<label>Security Code</label>
	<input class="form-control" id="card_code" placeholder="Example: 123" type="text" />
</div>

<div class="form-group">
	<label>Expiry Date</label>
</div>
<div class="row">
	<div class="form-group col-md-6">
		<select id="ex_date_month" class="form-control">
			<option selected value="">
		    Select Month:
			</option>
			<option selected value="jan">
				January
			</option>
			<option selected value="feb">
				Feburary
			</option>
			<option selected value="mar">
				March
			</option>
			<option selected value="apr">
				April
			</option>
			<option selected value="may">
				May
			</option>
			<option selected value="june">
				June
			</option>
			<option selected value="july">
				July
			</option>
			<option selected value="aug">
				August
			</option>
			<option selected value="sep">
				September
			</option>
			<option selected value="oct">
				October
			</option>
			<option selected value="nov">
				November
			</option>
			<option selected value="dec">
				December
			</option>
	  </select>
	</div>
	<div class="form-group col-md-6">
		<select id="ex_date_year" class="form-control">
			<option selected value="">
				Select Year:
			</option>
			<?php for($i = date("Y");$i <= date("Y") + 10; $i++) { ?>
				<option value="<?php echo $i; ?>">
					<?php echo $i; ?>
				</option>
			<?php } ?>
	  </select>
	</div>
</div>

<div class="form-group">
	<button class="btn btn-warning" data-toggle="modal" data-target="#book_modal">Book Now</button>
</div>

<script type="text/javascript">
	$(function(){
		$('#book_modal').on('shown.bs.modal', function () {
		  var get_card_no = $("#card_no").val();
		  var get_card_code = $("#card_code").val();
		  var get_card_expiry_year = $("#ex_date_year").val();
		  var get_card_expiry_month = $("#ex_date_month").val();
		  var expiry_date = get_card_expiry_month + "-" + get_card_expiry_year
		  $("#hidden_card_no").val(get_card_no);
		  $("#hidden_card_code").val(get_card_code);
		  $("#hidden_card_ex_date").val(expiry_date);
		})
	});
</script>
<?php
	if(isset($_SESSION["login_user"])) {
    require_once('class.user.php');
    $email = $_SESSION["login_user"];
    $user = new User($email);
    $current_user = $user->get_current_user();
  }
?>
<div class="modal fade" id="book_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<form action="book.php?event_id=<?php echo $event_id; ?>&user_id=<?php echo $current_user['id']; ?>" method="post">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
	      </div>
	      <div class="modal-body">
	        
	      	<input id="hidden_card_no" name="card_no" type="hidden" />
	      	<input id="hidden_card_code" name="card_code_no" type="hidden" />
	      	<input id="hidden_card_ex_date" name="card_expiry_date" type="hidden" />
	        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	        quis nostrud exercitation <strong>ullamco laboris</strong> nisi ut aliquip ex ea commodo
	        consequat.</p>
	        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	        consequat. Duis aute irure dolor <strong>helloworld@example.com</strong> in voluptate velit esse
	        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-warning">Yes Continue</button>
	      </div>
	    </div>
	  </div>
  </form>
</div>
