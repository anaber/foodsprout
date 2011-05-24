<?php
$tab = $this->uri->segment(2);
?>

<p />

<?php
$aboutclass=NULL;
if($this->uri->segment(1) == "about" && $tab == '') { 
	$aboutclass = 'class="abouton"';
}
else{
	$aboutclass = 'class="aboutoff"';
}
echo anchor('/business/why', 'Why Food Sprout', $aboutclass);
?><br>

<?php
$teamclass=NULL;
if($tab == "team") { 
	$teamclass = 'class="abouton"';
}
else{
	$teamclass = 'class="aboutoff"';
}
echo anchor('/business/services', 'Services', $teamclass);
?><br>

<?php
$contactclass=NULL;
if($tab == "contact") { 
	$contactclass = 'class="abouton"';
}
else{
	$contactclass = 'class="aboutoff"';
}
echo anchor('/business/success-stories', 'Success Stories', $contactclass);
?><br>

<?php

if ($this->session->userdata('isAuthenticated') == 1 ) {
	$contactclass=NULL;
	if($tab == "contact") { 
		$contactclass = 'class="abouton"';
	}
	else{
		$contactclass = 'class="aboutoff"';
	}
	echo anchor('/business/register', 'Upgrade Your Account', $contactclass);
}
else{
	$contactclass=NULL;
	if($tab == "contact") { 
		$contactclass = 'class="abouton"';
	}
	else{
		$contactclass = 'class="aboutoff"';
	}
	echo anchor('/business/register', 'Plans & Pricing', $contactclass);
	
}
	
?><br>