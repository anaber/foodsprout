<script src="<?php echo base_url()?>js/search/manufacture_search.js" type="text/javascript"></script>
<?php
	$brand = $this->input->post('f');
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
			elseif($currentpage == 4)
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
			<div style="float:left; width:350px;" class="paging">
				<a href="/manufacture/page<?php echo $prevpage; ?>">Prev</a> <a href="/manufacture/page1">1</a> <a href="/manufacture/page2">2</a> <a href="/manufacture/page3">3</a> <a href="/manufacture/page4">4</a> <a href="/manufacture/page<?php echo $nextpage; ?>">Next</a>
			</div>
			<div style="float:right; width:250px; font-size:14px; text-align:right;">1 - 10 of <?php echo $MANUFACTURES['param']['numResults']; ?> | Items Per Page 10 20 40</div>
	</div>
</div>

<div style="float:right; width:160px;">
	<?php
		$this->load->view('includes/banners/sky');
	?>
</div>