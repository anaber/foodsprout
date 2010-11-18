<script src="<?php echo base_url()?>js/search/manufacture_search.js" type="text/javascript"></script>
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
			echo anchor('/manufacture/view/'.$r->manufactureId, $r->manufactureName).'</div>';
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
		<?php $currentpage = substr($this->uri->segment(2),4,5);
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
			<div style="float:left; width:320px;" class="paging">
				<a href="/manufacture/page<?php echo $prevpage; ?>?pp=<?php echo $MANUFACTURES['param']['perPage']; ?>">Prev</a> <a href="/manufacture/page1?pp=<?php echo $MANUFACTURES['param']['perPage']; ?>">1</a> <a href="/manufacture/page2?pp=<?php echo $MANUFACTURES['param']['perPage']; ?>">2</a> <a href="/manufacture/page3?pp=<?php echo $MANUFACTURES['param']['perPage']; ?>">3</a> <a href="/manufacture/page4?pp=<?php echo $MANUFACTURES['param']['perPage']; ?>">4</a> <a href="/manufacture/page<?php echo $nextpage; ?>?pp=<?php echo $MANUFACTURES['param']['perPage']; ?>">Next</a>
			</div>
			<div style="float:right; width:280px; font-size:14px; text-align:right;"><?php echo $MANUFACTURES['param']['start']; ?> - <?php echo $MANUFACTURES['param']['end']; ?> of <?php echo $MANUFACTURES['param']['numResults']; ?> | Items Per Page <?php echo '<a href="'.current_url().'?pp=10">10</a>'; ?> | <?php echo '<a href="'.current_url().'?pp=20">20</a>'; ?> | <?php echo '<a href="'.current_url().'?pp=30">30</a>'; ?></div>
	</div>
</div>

<div style="float:right; width:160px;">
	<?php
		$this->load->view('includes/banners/sky');
	?>
</div>