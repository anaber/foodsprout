<script>
	$(document).ready(function() {
		loadMapOnStartUp(38.41055825094609, -98, 3);
	});
</script>
<?php
		echo '<h1>'.$MANUFACTURE->manufactureName.'</h1>';
?>
		Website: <? if(isset($MANUFACTURE->manufactureURL)) 
				{
			?>
			<a href="http://<?php echo $MANUFACTURE->manufactureURL; ?>"><?php echo $MANUFACTURE->manufactureURL; ?></a>
			<?php 
			}
			else
			{	
				// for now do not disply missing text
			}
			?>
<br><br>