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

	<div style="-moz-border-radius-topleft:7px;-webkit-border-radius-topleft:7px;border-top-left-radius:7px;background: #F05A25; color:#fff; padding:5px;padding-left:10px;">Radius Search</div>
	<div style="background:#e5e5e5; font-size:90%;padding-left:5px;padding-bottom:5px;padding-top:5px;">
		<div id="divZipcode" style="font-size:13px;">
			<form id="frmFilters">
				Zip Code <input type="text" size="6" maxlength="5" id = "q">
			</form>
		</div>
		<br />
		<div id="slider" style = "font-size: 62.5%; width:160px;"></div> 
		<div id="radius" style="border:0; color:#F05A25; font-weight:bold;"></div>
	</div>
	<br />
	
	<div style="-moz-border-radius-topleft:7px;-webkit-border-radius-topleft:7px;border-top-left-radius:7px;background: #F05A25; color:#fff; padding:5px;padding-left:10px;">Farm Type</div>
	<div id="divFarmTypes" style="background:#e5e5e5; font-size:90%;padding-left:5px;padding-bottom:5px;padding-top:5px;font-size:13px;"></div>
	
	<br />
	<div id="removeFilters">
		<a id="imgRemoveFilters" href="#" style="font-size:13px;text-decoration:none;">Remove Filters</a>
	</div>
	
</div>
 
<div id="popupContact"> 
	<a id="popupClose">X</a> 
	<div id="divAllFarmTypes"></div>
</div> 
<div id="backgroundPopup"></div>
<div id="backgroundWhitePopup"></div> 