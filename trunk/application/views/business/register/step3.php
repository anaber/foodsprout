<script>
	$(document).ready(function() {
		$("#frmAccount").validationEngine({
			scroll:false,
			unbindEngine:false
		});
	});
</script>

<?php
	$this->load->view('business/register/top_steps');
?>


<div class = "content">

	<div style = "border:1px dashed; padding:20px;margin-top:15px;" align = "center">
		<div style = "font-size:22px;">Congratulations. Let's get started.</div>
		<div class = "clear"></div>
		
	</div>
	<div class = "clear"></div>
	
	
	<div style = "padding:15px;margin-top:15px;" align = "center">
		<div id="signup-form2">
			<input type="submit" class = "big-submit-button" name="submit" value="Access Business Account">
		</div>
	</div>
	<div class = "clear"></div>
	
</div>
<div class = "clear"></div>
