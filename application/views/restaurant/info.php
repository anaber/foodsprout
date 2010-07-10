<script>
	$(document).ready(function() {
		loadMapOnStartUp(38.41055825094609, -98, 3);
	});
</script>
<?php
		echo '<h1>'.$RESTAURANT->restaurantName.'</h1>';
?>
		Website: <? if(isset($RESTAURANT->restaurantURL)) 
				{
			?>
			<a href="http://<?php echo $RESTAURANT->restaurantURL; ?>"><?php echo $RESTAURANT->restaurantURL; ?></a>
			<?php 
			}
			else
			{	
				// for now do not disply missing text
			}
			?>
<br><br>