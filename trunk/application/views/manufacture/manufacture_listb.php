<?php
	$brand = $this->input->post('f');
	
	//print_r($MANUFACTURES);
?>
<div style = "float:left;padding:0px;">
	
	<div>
		<div style="float:left;width:530px;"><h1>Products &amp; Companies</h1></div>
		<div class="clear"></div>
	</div>
	<div class = "clear"></div>
	
	<div id="resultsContainer" class="pd_tp1">
		<div id="resultTableContainer" style = "width:630px; padding:0px;">
	<?php
		$i = 1;
		foreach($MANUFACTURES['results'] as $r) :
			$i++;
			
			echo '<div style="overflow:auto; padding-bottom:10px;">';
			echo '	<div class = "listing-header">';
			
			if ($r->customUrl) {
				echo anchor('/manufacture/'.$r->customUrl, $r->manufactureName, 'style="text-decoration:none;"');
			} else {
				echo anchor('/manufacture/view/'.$r->manufactureId, $r->manufactureName, 'style="text-decoration:none;"');
			}
			echo '	</div>';
			echo '	<div class = "clear"></div>';
	
			echo '	<div class = "listing-information">'; 
			echo '		<strong>Categories:</strong> '.$r->manufactureType;
			echo '	</div>';
			echo '	<div class = "listing-address-title">';
			echo '		<b>Address:</b>';
			echo '	</div>';
			echo '	<div class = "listing-address">';
					$x = 1;
					foreach($r->addresses as $s) :
					$x++;
						echo $s->displayAddress;
					endforeach;
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
		<div style="float:left; width:172px;" id = 'numRecords'>Records <?php echo $MANUFACTURES['param']['start']; ?>-<?php echo $MANUFACTURES['param']['end']; ?> of <?php echo $MANUFACTURES['param']['numResults']; ?></div>
		
		<div style="float:left; width:250px;" id = 'pagingLinks' align = "center">
			<a href="/manufacture?pp=<?php echo $MANUFACTURES['param']['perPage']; ?>" id = "imgFirst">First</a> &nbsp;&nbsp;
			<a href="/manufacture/page<?php echo $prevpage; ?>?pp=<?php echo $MANUFACTURES['param']['perPage']; ?>">Previous</a>
			&nbsp;&nbsp;&nbsp; Page <?php echo $currentpage; ?> of <?php echo $MANUFACTURES['param']['totalPages']; ?> &nbsp;&nbsp;&nbsp;
			<a href="/manufacture/page<?php echo $nextpage; ?>?pp=<?php echo $MANUFACTURES['param']['perPage']; ?>">Next</a> &nbsp;&nbsp;
			<a href="/manufacture/page<?php echo $MANUFACTURES['param']['totalPages']; ?>?pp=<?php echo $MANUFACTURES['param']['perPage']; ?>" id = "imgLast">Last</a>
		</div>
		
		<div style="float:left; width:195px;" id = 'recordsPerPage' align = "right">
			Items per page:
			<?php echo ($MANUFACTURES['param']['perPage'] == '10') ? '<strong>10</strong>' : '<a href="'.current_url().'?pp=10" id = "10PerPage">10</a>'; ?> |
			<?php echo ($MANUFACTURES['param']['perPage'] == '20') ? '<strong>20</strong>' : '<a href="'.current_url().'?pp=20" id = "20PerPage">20</a>'; ?> | 
			<?php echo ($MANUFACTURES['param']['perPage'] == '40') ? '<strong>40</strong>' : '<a href="'.current_url().'?pp=40" id = "40PerPage">40</a>'; ?>
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