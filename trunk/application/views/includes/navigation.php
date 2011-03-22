<?php
$tab = $this->uri->segment(1);
?>

<div id="navigation">
	<?php
	 	$restclass=NULL;
		if($tab == "chain" || $tab == "restaurant" || $tab == "sustainable") { 
			$restclass = 'class="tabon"'; 
		} 
		echo anchor('restaurant', 'Restaurants', $restclass);
	?>
	<?php
	 	$manuclass=NULL;
		if($tab == "manufacture" || $tab == "product") { 
			$manuclass = 'class="tabon"';
		}
		echo anchor('manufacture', 'Products', $manuclass);
	?>
	<?php
		$farmclass=NULL;
		if($tab == "farm") { 
			$farmclass = 'class="tabon"';
		}
		echo anchor('farm', 'Farms', $farmclass);
	?>
	<?php
		$marketclass=NULL;
		if($tab == "farmersmarket" || $tab == "city") { 
			$marketclass = 'class="tabon"';
		}
		echo anchor('farmersmarket', 'Farmers Market', $marketclass);
	?>
	<?php
		$discussclass=NULL;
		if($tab == "topics") { 
			$discussclass = 'class="tabon"';
		}
		echo anchor('/topics', 'Discuss', $discussclass);
	?>
</div>