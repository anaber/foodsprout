<strong>Password reset</strong>
<hr />
<?php 
	
	if(isset($error)){		
		echo '<div align="center" style="font-weight: bolder;" >'.$error.'</div>';
	}

?>

<p>Please provide following information for password reset.</p>



<form name="password_reset" method="post" action="<?php echo base_url();?>login/resetnow">
	<label for="email_reset" >Email: </label>
	<input name="email_reset" id="email_reset"  value="" />
	<input type="submit" value="Reset" />
</form>