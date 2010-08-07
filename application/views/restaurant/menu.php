<?php
if (count($MENU) > 0 ) {
?>			
	
<?php

	$i = 0;
	foreach($MENU as $r) :
		$i++;	
		echo '<div class="menuitem"> 
	      	<div class="menuitemimg"><img src="/img/img1.jpg" width="132" height="107" alt="receipe" /></div> 
	        <div class="menuitemname">'.$r->productName.'</div> 
	         <div class="menuitemdetails">
	         	'.$r->ingredient.'
	         </div>
	    </div>';
	    
 	endforeach;
?>

<?php
} else {
	echo "<div>No menu items provided at this time.</div>";
}
?>