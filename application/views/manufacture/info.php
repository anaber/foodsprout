<script>
	$(document).ready(function() {
		loadMapOnStartUp(38.41055825094609, -98, 3);
	});
</script>
<?php
		echo '<h1>'.$MANUFACTURE->manufactureName.'</h1>';
?>
		Website: <? if(isset($MANUFACTURE->url))
				{
			?>
			<a target = '_blank' href="http://<?php echo $this->functionlib->removeProtocolFromUrl($MANUFACTURE->url); ?>"><?php echo $MANUFACTURE->url; ?></a>
			<?php 
			}
			else
			{	
				// for now do not disply missing text
			}
			?>
<br><br>