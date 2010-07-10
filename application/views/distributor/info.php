<script>
	$(document).ready(function() {
		loadMapOnStartUp(38.41055825094609, -98, 3);
	});
</script>
<?php
		echo '<h1>'.$DISTRIBUTOR->distributorName.'</h1>';
?>
		Website: <? if(isset($DISTRIBUTOR->distributorURL)) 
				{
			?>
			<a href="http://<?php echo $DISTRIBUTOR->distributorURL; ?>"><?php echo $DISTRIBUTOR->distributorURL; ?></a>
			<?php 
			}
			else
			{	
				// for now do not disply missing text
			}
			?>
<br><br>