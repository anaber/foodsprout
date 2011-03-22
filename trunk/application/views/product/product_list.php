<?php
	$brand = $this->input->post('f');
	
//print_r($PRODUCTS);
?>
<div style = "float:left;padding:0px;">
	
	<div>
	<div style="float:left; width:400px;"><h1><?php echo ( isset($FRUCTOSE) && $FRUCTOSE) ? 'Products With High-Fructose Corn Syrup' : 'Products'; ?></h1></div>
		<div class="clear"></div>
	</div>
	<div class = "clear"></div>
	
	<div id="resultsContainer" class="pd_tp1">
		<div id="resultTableContainer" style = "width:630px; padding:0px;">
	<?php
		$i = 1;
		foreach($PRODUCTS['results'] as $r) :
			$i++;
			
			echo '<div style="overflow:auto; padding-bottom:10px;">';
			echo '	<div class = "listing-header">';
			echo $r->productName;
			echo '	</div>';
			echo '	<div class = "clear"></div>';
	
			echo '	<div style="float:left; width:300px; clear:left;padding-left:3px; padding-right:10px;font-size:13px;">'; 
			echo '		<b>Type:</b> '.$r->productType;
			echo '		<br/><b>Brand:</b> '.$r->brand;
			echo '	</div>';
			echo '	<div style="float:left; width:75px;font-size:13px;">';
			echo '		<b>Manufacture:</b>';
			echo '	</div><br>';
			echo '	<div style="float:left; width:215px;font-size:13px;">';
			echo '	<a href="/manufacture/'.$r->customUrl.'" style="font-size:13px;text-decoration:none;">'.$r->producerName.'</a>';
			echo '	</div>';
			echo '	<div class = "clear"></div>';
			echo '</div>' ;
			echo '<div class = "clear"></div>';
			;
 		endforeach;

	?>
		
		</div>
		<div class = "clear"></div>
	</div>
	<div class = "clear"></div>
	
	<hr size="1" style = "width:628px;">
	<div style="overflow:auto; padding:5px; font-size:10px;">
		<?php 
			$currentpage = substr($this->uri->segment(3),4,5);
			
			if (empty($currentpage) ) {
				$currentpage = 1;
			}
			if($currentpage == 1)
			{
				$prevpage = $currentpage;
				$nextpage = $currentpage+1;
			}
			elseif($currentpage == $PRODUCTS['param']['totalPages'])
			{
				$prevpage = $currentpage-1;
				$nextpage = $currentpage;
			}
			else
			{
				$prevpage = $currentpage-1;
				$nextpage = $currentpage+1;
			}
		?>
		<div style="float:left; width:172px;" id = 'numRecords'>Records <?php echo $PRODUCTS['param']['start']; ?>-<?php echo $PRODUCTS['param']['end']; ?> of <?php echo $PRODUCTS['param']['numResults']; ?></div>
		
		<div style="float:left; width:250px;" id = 'pagingLinks' align = "center">
			<a href="/product/fructose?pp=<?php echo $PRODUCTS['param']['perPage']; ?>" id = "imgFirst">First</a> &nbsp;&nbsp;
			<a href="/product/fructose/page<?php echo $prevpage; ?>?pp=<?php echo $PRODUCTS['param']['perPage']; ?>">Previous</a>
			&nbsp;&nbsp;&nbsp; Page <?php echo $currentpage; ?> of <?php echo $PRODUCTS['param']['totalPages']; ?> &nbsp;&nbsp;&nbsp;
			<a href="/product/fructose/page<?php echo $nextpage; ?>?pp=<?php echo $PRODUCTS['param']['perPage']; ?>">Next</a> &nbsp;&nbsp;
			<a href="/product/fructose/page<?php echo $PRODUCTS['param']['totalPages']; ?>?pp=<?php echo $PRODUCTS['param']['perPage']; ?>" id = "imgLast">Last</a>
		</div>
		
		<div style="float:left; width:195px;" id = 'recordsPerPage' align = "right">
			Items per page:
			<?php echo ($PRODUCTS['param']['perPage'] == '10') ? '<strong>10</strong>' : '<a href="'.current_url().'?pp=10" id = "10PerPage">10</a>'; ?> |
			<?php echo ($PRODUCTS['param']['perPage'] == '20') ? '<strong>20</strong>' : '<a href="'.current_url().'?pp=20" id = "20PerPage">20</a>'; ?> | 
			<?php echo ($PRODUCTS['param']['perPage'] == '40') ? '<strong>40</strong>' : '<a href="'.current_url().'?pp=40" id = "40PerPage">40</a>'; ?>
		</div>
		
		<div class="clear"></div>
	</div>
	<div class = "clear"></div>
</div>
<div style="float:right; width:160px;">
	<?php
			$this->load->view('includes/banners/sky');
	?>
	<div class = "clear"></div>
</div>
<div class = "clear"></div>