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
		<form id="frmFilters" method = "get" action = "/farmersmarket">
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
			<input type = "hidden" name = "city" value = "<?php echo $PARAMS['city'];?>">
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
<?php
	
?>
<div class="filterh">Markets by Cities:</div>
<div id="" class="filterb">
    <?php if ( isset($featureds) && ! is_null($featureds)): foreach($featureds->result() as $city):
        echo anchor("farmersmarket/city/{$city->custom_url}", $city->city) . '<br/>';
    endforeach; else:
        echo '<p>No cities listed.</p>';
    endif
    ?>
	<?php echo anchor('/cities/farmersmarket', 'More Cities'); ?>
</div><br />
