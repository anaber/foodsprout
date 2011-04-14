<script src="<?php echo base_url()?>js/popup.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.slider.js"></script>


<style type="text/css">
	#demo-frame > div.demo { padding: 10px !important; };
</style>
<script type="text/javascript">
$(function() {
	
	$("#slider").slider({
		range: "min",
		value: <?php echo $FARM_DEFAULT_RADIUS; ?>,
		min: <?php echo $FARM_RADIUS['min']; ?>,
		max: <?php echo $FARM_RADIUS['max']; ?>,
		step: <?php echo $FARM_RADIUS['step']; ?>,
		slide: function(event, ui) {
			$("#radius").html(ui.value + ' miles');
		}
	});
	$("#radius").html( $("#slider").slider("value") + ' miles' );
});
</script>

	<div class="filterh">Radius Search</div>
	<div class="filterb">
		<div id="divZipcode" style="font-size:13px;">
			<form id="frmFilters" method = "get" action = "/farm">
				Zip Code <input type="text" size="6" maxlength="5" id = "q" name  = "q" value = "<?php echo ($PARAMS ? $PARAMS['q'] : '') ; ?>">
			<?php
				if ($PARAMS) {
			?>
				<input type = "hidden" name = "p" value = "<?php echo $PARAMS['page'];?>">
				<input type = "hidden" name = "pp" value = "<?php echo $PARAMS['perPage'];?>">
				<input type = "hidden" name = "sort" value = "<?php echo $PARAMS['sort'];?>">
				<input type = "hidden" name = "order" value = "<?php echo $PARAMS['order'];?>">
				<input type = "hidden" name = "f" value = "<?php echo $PARAMS['filter'];?>">
				<input type = "hidden" name = "r" value = "<?php echo $PARAMS['radius'];?>">
			<?php
				}
			?>
			</form>
		</div>
		<br />
		<div id="slider" style = "font-size: 62.5%; width:160px;"></div> 
		<div id="radius" style="border:0; color:#F05A25; font-weight:bold;"></div>
	</div>
	<br />
	
	<div class="filterh">Certifications/Methods</div>
	<div id="divCertifications" class="filterb"></div>
	<br />
	
	<div class="filterh">Farm Crops</div>
	<div id="divFarmCrops" class="filterb"></div>
	<br />
	
	<div class="filterh">Farm Livestock</div>
	<div id="divFarmLivestocks" class="filterb"></div>
	<br />
	
	<div id="removeFilters">
		<a id="imgRemoveFilters" href="#" style="font-size:13px;text-decoration:none;">Remove Filters</a>
	</div>
	

 
<div id="popupContact"> 
	<a id="popupClose">X</a> 
	<div id="divAllFarmCrops"></div>
</div> 
<div id="backgroundPopup"></div>
<div id="backgroundWhitePopup"></div> 
