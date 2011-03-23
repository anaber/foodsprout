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
echo anchor('/about', 'About', $aboutclass);
?><br>

<?php
$teamclass=NULL;
if($tab == "team") { 
	$teamclass = 'class="abouton"';
}
else{
	$teamclass = 'class="aboutoff"';
}
echo anchor('/about/team', 'Team', $teamclass);
?><br>

<?php
$contactclass=NULL;
if($tab == "contact") { 
	$contactclass = 'class="abouton"';
}
else{
	$contactclass = 'class="aboutoff"';
}
echo anchor('/about/contact', 'Contact', $contactclass);
?><br>

<?php
$faqclass=NULL;
if($tab == "faq") { 
	$faqclass = 'class="abouton"';
}
else{
	$bizclass = 'class="aboutoff"';
}
echo anchor('/about/faq', 'FAQ', $faqclass);
?><br>

<?php
$bizclass=NULL;
if($tab == "business") { 
	$bizclass = 'class="abouton"';
}
else{
	$bizclass = 'class="aboutoff"';
}
echo anchor('/about/business', 'Business', $bizclass);
?><br>