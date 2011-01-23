<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.slider.js"></script>

<?php
	$city = $this->uri->segment(3);
	
	
?>

<style type="text/css">
	#demo-frame > div.demo { padding: 10px !important; };
</style>
<script type="text/javascript">
$(function() {
	
	$("#slider").slider({
		range: "min",
		value: <?php echo $FARMERS_MARKET_DEFAULT_RADIUS; ?>,
		min: <?php echo $FARMERS_MARKET_RADIUS['min']; ?>,
		max: <?php echo $FARMERS_MARKET_RADIUS['max']; ?>,
		step: <?php echo $FARMERS_MARKET_RADIUS['step']; ?>,
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
<?php
	
?>
<div class="filterh">Markets by Cities:</div>
<div id="" class="filterb">
	<a href="/farmersmarket/city/san-francisco-ca" style="font-size:13px;text-decoration:none;"><?php echo ($city == 'san-francisco-ca') ? '<b>San Francisco</b>' : 'San Francisco' ?></a><br />
	<a href="/farmersmarket/city/berkeley-ca" style="font-size:13px;text-decoration:none;"><?php echo ($city == 'berkeley-ca') ? '<b>Berkeley</b>' : 'Berkeley' ?></a><br />
	<a href="/farmersmarket/city/new-york-ny" style="font-size:13px;text-decoration:none;"><?php echo ($city == 'new-york-ny') ? '<b>New York</b>' : 'New York' ?></a><br />
</div><br />
