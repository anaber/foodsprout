Step 1: Select the plan for your business.<br/><br/>

<div style="float:left;width:440px;border:1px solid #dedede;padding:5px;">
	<div style="background:#dedede;">Free</div>
	<hr size="1">
	Features:<br/>
	Manage up to 3 businesses<br>
	Manage Your Supplier Data</br>
	Manage Your Menu</br>
	Embed Your Suppliers and Menu on your site
	
	<?php
		if ($this->session->userdata('isAuthenticated') == 1 ) {
	?>
	<a href="/business/register/step3">Upgrade > Step 3 (confirmation)</a>	
	
	<?php } else{ ?>
	<a href="/business/register/step1">Sign Up > Step 1 (create account)</a>
	<? } ?>
</div>

<div style="float:right;width:440px;border:1px solid #dedede;padding:5px;">
	<div style="background:#dedede;">Pro - $24.95 per month</div>
	<hr size="1">
	All the features of the free account<br>
	AND<br>
	Access to tools<br>
	Access to ______<br>
	Option _______<br>
	Option _______<br>
	Unlimited users<br>
	
	<?php
		if ($this->session->userdata('isAuthenticated') == 1 ) {
	?>
	<a href="/business/register/step2">Upgrade > Step 2 (payment)</a>	
	
	<?php } else{ ?>
	<a href="/business/register/step1">Sign Up > Step 1 (create account)</a>
	<? } ?>
</div>