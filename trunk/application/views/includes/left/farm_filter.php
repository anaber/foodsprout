<script src="<?php echo base_url()?>js/popup.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.slider.js"></script>

<link type="text/css" href="<?php echo base_url()?>css/jquery-ui/jquery.ui.slider.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url()?>css/jquery-ui/jquery.ui.theme.css" rel="stylesheet" />
<style type="text/css">
	#demo-frame > div.demo { padding: 10px !important; };
</style>
<script type="text/javascript">
$(function() {
	
	$("#slider").slider({
		range: "min",
		value: 20,
		min: 0,
		max: 120,
		step: 20,
		slide: function(event, ui) {
			$("#amount").html(ui.value + ' miles');
		}
	});
	$("#amount").html( $("#slider").slider("value") + ' miles' );
});
</script>
	<?php /* ?>
	<div id="divZipcode" style="-moz-border-radius-topleft:7px;-webkit-border-radius-topleft:7px; -moz-border-radius-bottomleft:7px;-webkit-border-radius-bottomleft:7px;background: #F05A25; color:#fff; padding:5px;padding-left:10px;">
		<form id="frmFilters">
			Zip Code <input type="text" size="6" maxlength="5" id = "q">
		</form>
	</div><br>
	<?php */ ?>
	
	<div style="-moz-border-radius-topleft:7px;-webkit-border-radius-topleft:7px;background: #F05A25; color:#fff; padding:5px;padding-left:10px;">Radius Search</div>
	<div id="" style="background:#e5e5e5; font-size:90%;padding-left:5px;padding-bottom:5px;padding-top:5px;">
		<form id="frmFilters">
			Zip Code <input type="text" size="6" maxlength="5" id = "q">
		</form>
		<br />
		<div id="slider" style = "font-size: 62.5%; width:160px;"></div> 
		<div id="amount" style="border:0; color:#F05A25; font-weight:bold;"></div>
	</div>
	<br />
	
	<div style="-moz-border-radius-topleft:7px;-webkit-border-radius-topleft:7px;background: #F05A25; color:#fff; padding:5px;padding-left:10px;">Farm Type</div>
	<div id="divFarmTypes" style="background:#e5e5e5; font-size:90%;padding-left:5px;padding-bottom:5px;padding-top:5px;"></div>
	
	<br />
	<div id="removeFilters">
		<a id="imgRemoveFilters" href="#">Remove Filters</a>
	</div>
	
	 
</div>
 
<div id="popupContact"> 
	<a id="popupClose">X</a> 
	<div id="divAllFarmTypes"></div>
</div> 
<div id="backgroundPopup"></div>
<div id="backgroundWhitePopup"></div>  