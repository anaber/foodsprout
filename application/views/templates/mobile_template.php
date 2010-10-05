<?php 
	if (isset($SEO) ) {
		$this->load->view('mobile/includes/header', array('SEO' => $SEO));
	} else {
		$this->load->view('mobile/includes/header');
	}
?>

<?php
	if (isset($BREADCRUMB)) {
		
		$this->load->view('includes/breadcrumb', array('BREADCRUMB' => $BREADCRUMB ) );
	}
	else {
		echo '<br>';
	}
?>

<div id="mainarea">

	<ul id="menu">
		<li><a href="/mobile/restaurants">Restaurants <span>Find sustainable restaurants near you</span></a></li>
		<li><a href="/mobile/farmersmarket">Farmers Markets <span>Find farmers markets near you</span></a></li>

		<li><a href="/mobile/Farms">Farms <span>Daily Programs, Upcoming Events</span></a></li>
		<li><a href="/mobile/tips">Tips <span>Transit, Driving Directions and Parking</span></a></li>
		<li><a href="/mobile/fish">Fish <span>Seafood watch list</span></a></li>

	</ul>

</div>

<br />

<div id="mainarea">

	<br /><br /><br /><br />

</div>

<?php $this->load->view('mobile/includes/footer'); ?>