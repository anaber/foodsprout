<br>To contact Food Sprout please use any of the following:
<br><br>

<?php
/*
if()
{

?>

	<strong class="redtxt">Send us an email</strong><br/>

		<div style="color: #990000; border: 1px solid #990000;"><?php echo validation_errors('<p>'); ?></div>
		
		<form action="/about/sendmail" name="emailcontact" method="post">
			Your Name: <input type="text" size="30" maxlenght="30" name="username" value="<?php echo $this->input->post('username'); ?>"><br />
			Your Email: <input type="text" size="30" maxlength="50" name="useremail" value="<?php echo $this->input->post('useremail'); ?>"><br/>
			Message:<br/>
			<textarea rows="12" cols="60" name="message"><?php echo $this->input->post('message'); ?></textarea><br/>
			<input type="submit" name="sendemail" value="Send Email">
		</form>
		
<?php
}
*/
if($this->input->post('sendemail') == FALSE)
{

?>

<strong class="redtxt">Send us an email</strong><br/>
<form action="/about/sendmail" name="emailcontact" method="post">
Your Name: <input type="text" size="30" maxlenght="30" name="username"><br />
Your Email: <input type="text" size="30" maxlength="50" name="useremail"><br/>
Message:<br/>
<textarea rows="12" cols="60" name="message"></textarea><br/>
<input type="submit" name="sendemail" value="Send Email">
</form>

<?php
}

else
{
	echo '<strong>Thank you for your email, we will respond as soon as possible.</strong>';
}
?>

<br>
<br>

<strong class="redtxt">Reach us via the post office</strong><br>
655 12th Street Suite 110<br>
Oakland, CA 94607<br>