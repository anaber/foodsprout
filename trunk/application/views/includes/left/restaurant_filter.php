<script src="<?php echo base_url()?>js/popup.js" type="text/javascript"></script>

<?php
	if ( isset($CITY) ) { }
	else {
?>
	<div id="divZipcode" class="divZipcode" style="-moz-border-radius-topleft:7px;-webkit-border-radius-topleft:7px;-moz-border-radius-bottomleft:7px;-webkit-border-radius-bottomleft:7px;border-top-left-radius:7px;border-bottom-left-radius:7px;background: #F05A25; color:#fff; padding:5px;padding-left:10px;"><form id="frmFilters">Zip Code <input type="text" size="6" maxlength="5" id = "q"></form></div><br>
<?php
	}
	
?>
	<div style="-moz-border-radius-topleft:7px;-webkit-border-radius-topleft:7px;border-top-left-radius:7px;background: #F05A25; color:#fff; padding:5px;padding-left:10px;">Restaurant Type</div>
	<div id="divRestaurantTypes" style="background:#e5e5e5; font-size:90%;padding-left:5px;padding-bottom:5px;padding-top:5px;font-size:13px;"></div>
	<br>
		
	<div style="-moz-border-radius-topleft:7px;-webkit-border-radius-topleft:7px;border-top-left-radius:7px;background: #F05A25; color:#fff; padding:5px;padding-left:10px;">Cuisine</div>
	<div id="divCuisines" style="background:#e5e5e5; font-size:90%;padding-left:5px;padding-bottom:5px;padding-top:5px;font-size:13px;"></div>
	
	<br />
	<div id = "removeFilters">
		<a id = "imgRemoveFilters" href = "#" style="font-size:13px;text-decoration:none;">Remove Filters</a>
	</div>
	
	<br />
	<div style="-moz-border-radius-topleft:7px;-webkit-border-radius-topleft:7px;border-top-left-radius:7px;background: #F05A25; color:#fff; padding:5px;padding-left:10px;">More Options</div>
	<div id="" style="background:#e5e5e5; font-size:90%; padding:5px;"><a href = "/chain/fastfood" style="font-size:13px;text-decoration:none;">Restaurant Chains</a></div>

	
	<?php
	$city = $this->uri->segment(2);
	?>
	<br />
	<div style="-moz-border-radius-topleft:7px;-webkit-border-radius-topleft:7px;border-top-left-radius:7px;background: #F05A25; color:#fff; padding:5px;padding-left:10px;">View Sustainable Only</div>
	<div id="" style="background:#e5e5e5; font-size:90%; padding:5px;">
		<?php
			foreach ($RECOMMENDED_CITIES as $rec_city) {
				$browser_compatible_rec_city = implode('-', explode (' ', strtolower($rec_city)) );
				echo '<a href="/restaurant/' . $browser_compatible_rec_city . '" style="font-size:13px;text-decoration:none;">'. ( ($browser_compatible_rec_city == $city) ? '<b>'.$rec_city.'</b>' : $rec_city ) . '</a><br/>';
			}
		?>
	</div>

 
<div id="popupContact"> 
	<a id="popupClose">X</a> 
	<div id = "divAllCuisines"></div>
	<div id = "divAllRestaurantTypes"></div>
</div> 
<div id="backgroundPopup"></div>
<div id="backgroundWhitePopup"></div>  