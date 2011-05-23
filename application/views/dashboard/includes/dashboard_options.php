<?php
	$USER_GROUP = getUserGroupsArray();	
?>
	<div class="filterh">Personal Options</div>
	<div id="divRestaurantTypes" class="filterb">
		<a href = "/dashboard">Dashboard</a><br />
		<a href = "">My Food Log</a><br />
		<a href = "">My Comments</a><br />
		-----------------------------<br />
		<a href = "/dashboard/restaurants">Added Restaurants</a><br />
		<a href = "/dashboard/farms">Added Farms</a><br />
		<a href = "/dashboard/markets">Added Markets</a><br />
	</div>
	<br>
	
	<?php
		//print_r_pre($this->session->userdata);
	?>
	<?php
		if ( $this->session->userdata['userGroupId'] !=  $USER_GROUP['BUSINESS_OWNER']) {
	?>
	<div class="filterh">Business Options</div>
	<div id="divCuisines" class="filterb">
		<a href = "/business">Learn More</a><br />
	</div>
	<?php
		} else if ( $this->session->userdata['userGroupId'] ==  $USER_GROUP['BUSINESS_OWNER']) {
	?>
	<div class="filterh">Business Options</div>
	<div id="divCuisines" class="filterb">
		<a href = "">My Restaurants</a><br />
		<a href = "">My Farms</a><br />
		<a href = "">My Markets</a><br />
		
		<?php /* these options should only be available for paying businesses?>
		<a href = "">Search Suppliers</a><br />
		<a href = "">Supplier Bids</a><br />
		*/
		?>
	</div>
	<?php
		}
	?>
	
	
	
