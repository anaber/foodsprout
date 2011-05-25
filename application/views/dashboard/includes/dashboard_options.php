<?php
	$USER_GROUP = getUserGroupsArray();	
?>
	<div class="filterh">Personal Options</div>
	<div id="divRestaurantTypes" class="filterb" style="line-height:170%;">
		<a href = "/dashboard">Dashboard</a><br />
		<a href = "/dashboard/foodlog">My Food Log</a><br />
		<a href = "/dashboard/comments">My Comments</a><br />
		<a href = "/dashboard/menu">My Menu</a><br />
		<a href = "/dashboard/suppliers">My Suppliers</a><br />
		<hr size="1">
		<a href = "/dashboard/data">Add Data</a><br />
		<a href = "/dashboard/managedata">Manage Data</a><br />
	</div>
	<br>
	
	<?php
		//print_r_pre($this->session->userdata);
	?>
	<?php
		if ( $this->session->userdata['accessId'] !=  $USER_GROUP['BUSINESS_OWNER']) {
	?>
	<div class="filterh">Business Options</div>
	<div id="divCuisines" class="filterb">
		<a href = "/business">Learn More</a><br />
	</div>
	<?php
		} else if ( $this->session->userdata['accessId'] ==  $USER_GROUP['BUSINESS_OWNER']) {
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
	
	
	
