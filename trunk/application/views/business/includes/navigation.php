<?php
$tab = $this->uri->segment(2);
?>

<div id="navigation">
	<?php
	 	$class=NULL;
		if($tab == "home" || $tab == "") { 
			$class = 'class="tabon"'; 
		} 
		echo anchor('business/home', 'Home', $class);
	?>
	<?php
	 	$class=NULL;
		if($tab == "success-stories") {
			$class = 'class="tabon"';
		}
		echo anchor('business/success-stories', 'Success Stories', $class);
	?>
	<?php
		$class=NULL;
		if($tab == "why") { 
			$class = 'class="tabon"';
		}
		echo anchor('business/why', 'Why FoodSprout?', $class);
	?>
	<?php
		$class=NULL;
		if($tab == "services") { 
			$class = 'class="tabon"';
		}
		echo anchor('business/services', 'Services', $class);
	?>
</div>