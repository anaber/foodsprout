<h2 class="greentxt">Where food goes?</h2>
<?php
foreach ($COMPANIES as $companyType => $companies) {
?>
<div style="overflow:auto; padding:5px;">
	<div style="float:left; width:100px;">
	<?php
		if ($companyType == 'farm') {
			echo 'Farm: ';
		} else if ($companyType == 'distributor') {
			echo 'Distributor: ';
		} else if ($companyType == 'manufacture') {
			echo 'Manufacture: ';
		} else if ($companyType == 'restaurant') {
			echo 'Restaurant: ';
		} else if ($companyType == 'restaurant_chain') {
			echo 'Restaurant Chain: ';
		} else 
		 
	?>
	</div> 
	<div style="float:left; width:400px;">
		<?php
			foreach($companies as $key => $company) {
				echo '<a href = "/'. ( ($companyType == 'restaurant_chain') ? 'chain' : $companyType ) .'/view/'.$company->companyId.'">'.$company->companyName.'</a><br />';
			}
		?>
	</div>
</div>
<?php
}
?>
