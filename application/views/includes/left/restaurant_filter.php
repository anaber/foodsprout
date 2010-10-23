<script src="<?php echo base_url()?>js/popup.js" type="text/javascript"></script>

<?php
	if ( isset($CITY) ) { }
	else {
?>
	<div id="divZipcode" class="divZipcode" style="-moz-border-radius-topleft:7px;-webkit-border-radius-topleft:7px;-moz-border-radius-bottomleft:7px;-webkit-border-radius-bottomleft:7px;border-top-left-radius:7px;border-bottom-left-radius:7px;background: #F05A25; color:#fff; padding:5px;padding-left:10px;"><form id="frmFilters">Zip Code <input type="text" size="6" maxlength="5" id = "q"></form></div><br>
<?php
	}
	
?>

	<?php
	$city = $this->uri->segment(2);
	?>
<div class="filterh">Sustainable In:</div>
<div id="" class="filterb">
	<?php
		foreach ($RECOMMENDED_CITIES as $rec_city) {
			$browser_compatible_rec_city = implode('-', explode (' ', strtolower($rec_city)) );
			echo '<a href="/sustainable/' . $browser_compatible_rec_city . '" style="font-size:13px;text-decoration:none;">'. ( ($browser_compatible_rec_city == $city) ? '<b>'.$rec_city.'</b>' : $rec_city ) . '</a><br/>';
		}
	?>
</div><br />

	<div class="filterh">Restaurant Type</div>
	<div id="divRestaurantTypes" class="filterb"></div>
	<br>
		
	<div class="filterh">Cuisine</div>
	<div id="divCuisines" class="filterb"></div>
	
	<br />
	<div id="removeFilters">
		<a id="imgRemoveFilters" href="#" style="font-size:13px;text-decoration:none;">Remove Filters</a>
	</div>
	
	<br />
	<div class="filterh">More Options</div>
	<div class="filterb"><a href = "/chain/fastfood" style="font-size:13px;text-decoration:none;">Restaurant Chains</a></div>

 
<div id="popupContact"> 
	<a id="popupClose">X</a> 
	<div id = "divAllCuisines"></div>
	<div id = "divAllRestaurantTypes"></div>
</div> 
<div id="backgroundPopup"></div>
<div id="backgroundWhitePopup"></div>  