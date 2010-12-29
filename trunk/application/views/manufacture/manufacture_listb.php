<?php
	$brand = $this->input->post('f');
	
	//print_r($MANUFACTURES);
?>

<div style="float:left;width:600px; padding-left:10px;">
	<h1>Products &amp; Companies</h1>
	
	<?php
	
		$i = 1;
		foreach($MANUFACTURES['results'] as $r) :
			$i++;
			
			echo '<div style="padding:0px; margin-right:10px; padding-bottom:10px;">';
			echo '<div class="productlisth">';
			echo anchor('/manufacture/view-'.$r->customURL, $r->manufactureName).'</div>';
			echo '<div class="productlist_type">';
			echo '<strong>Categories:</strong> '.$r->manufactureType;
			echo '</div>';
			echo '<div style="float:left;width:60px;font-size:13px;"><b>Address:</b></div>';
			echo '<div class="product_addr">';
					$x = 1;
					foreach($r->addresses as $s) :
					$x++;
						echo $s->displayAddress;
					endforeach;
			echo '</div>';
			echo '</div>';
 		endforeach;

	?>
	
	<div style="float:left; width:600px;">
		<hr size="1">
		
		<?php 
			
			$currentpage = substr($this->uri->segment(2),4,5);
			
			if (empty($currentpage) ) {
				$currentpage = 1;
			}
			if($currentpage == 1)
			{
				$prevpage = $currentpage;
				$nextpage = $currentpage+1;
			}
			elseif($currentpage == $MANUFACTURES['param']['totalPages'])
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
		
		<div style="float:left; width:150px; font-size:10px;" id = 'numRecords'>Records <?php echo $MANUFACTURES['param']['start']; ?>-<?php echo $MANUFACTURES['param']['end']; ?> of <?php echo $MANUFACTURES['param']['numResults']; ?></div>

		<div style="float:left; width:250px; font-size:10px;" id = 'pagingLinks' align = "center">
			<a href="/manufacture?pp=<?php echo $MANUFACTURES['param']['perPage']; ?>" id = "imgFirst">First</a> &nbsp;&nbsp;
			<a href="/manufacture/page<?php echo $prevpage; ?>?pp=<?php echo $MANUFACTURES['param']['perPage']; ?>">Previous</a>
			&nbsp;&nbsp;&nbsp; Page <?php echo $currentpage; ?> of <?php echo $MANUFACTURES['param']['totalPages']; ?> &nbsp;&nbsp;&nbsp;
			<a href="/manufacture/page<?php echo $nextpage; ?>?pp=<?php echo $MANUFACTURES['param']['perPage']; ?>">Next</a> &nbsp;&nbsp;
			<a href="/manufacture/page<?php echo $MANUFACTURES['param']['totalPages']; ?>?pp=<?php echo $MANUFACTURES['param']['perPage']; ?>" id = "imgLast">Last</a>
		</div>
		
		<div style="float:left; width:195px; font-size:10px;" id = 'recordsPerPage' align = "right">
			Items per page:
			<div id = "40PerPage" style="float:right; width:30px;"><?php echo '<a href="'.current_url().'?pp=40">40</a>'; ?></div>  
			<div id = "20PerPage" style="float:right; width:30px;"><?php echo '<a href="'.current_url().'?pp=20">20</a>'; ?> | </div>
			<div id = "10PerPage" style="float:right; width:30px;"><?php echo '<a href="'.current_url().'?pp=10">10</a>'; ?> | </div>
		</div>
	</div>
	
	
	
	
</div>

<div style="float:right; width:160px;">
	<?php
		$this->load->view('includes/banners/sky');
	?>
</div>