<div style = "float:left;padding:0px;">
	
	<div>
		<div style="float:left;width:530px;"><h1>Products &amp; Companies</h1></div>
		<div class="clear"></div>
	</div>
	<div class = "clear"></div>
	
	<div id="resultsContainer" class="pd_tp1">
		<div id="resultTableContainer" style = "width:630px; padding:0px;">
	<?php
		if (count($CHAINS['param']['numResults']) > 0 ) {
			
			$i = 1;
			$j = 1;
			echo '<div class="chainlist" style = "padding-left:10px;">';
			foreach($CHAINS['results'] as $r) {
				if ($r->customUrl) {
					echo anchor('/chain/'.$r->customUrl, $r->restaurantChain).'<br />';
				} else {
					echo anchor('/chain/view/'.$r->restaurantChainId, $r->restaurantChain).'<br />';
				}
				
				if($i == ceil($CHAINS['param']['perPage']/2) && ( $j != count($CHAINS['results']) )  )
				{
					echo '</div>';
					echo '<div class="chainlist">';
					$i = 0;
				}
				
				$i++;
				$j++;
			}
			echo '</div>';
		} else {
			echo "<div>No restaurant chains available.</div>";
		}
		
	?>
		</div>
		<div class = "clear"></div>
	</div>
	<div class = "clear"></div>
	
	<hr size="1" style = "width:628px;"/>
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
			elseif($currentpage == $CHAINS['param']['totalPages'])
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
		<div style="float:left; width:172px;" id = 'numRecords'>Records <?php echo $CHAINS['param']['start']; ?>-<?php echo $CHAINS['param']['end']; ?> of <?php echo $CHAINS['param']['numResults']; ?></div>
		
		<div style="float:left; width:250px;" id = 'pagingLinks' align = "center">
			<a href="/chain?pp=<?php echo $CHAINS['param']['perPage']; ?>" id = "imgFirst">First</a> &nbsp;&nbsp;
			<a href="/chain/page<?php echo $prevpage; ?>?pp=<?php echo $CHAINS['param']['perPage']; ?>">Previous</a>
			&nbsp;&nbsp;&nbsp; Page <?php echo $currentpage; ?> of <?php echo $CHAINS['param']['totalPages']; ?> &nbsp;&nbsp;&nbsp;
			<a href="/chain/page<?php echo $nextpage; ?>?pp=<?php echo $CHAINS['param']['perPage']; ?>">Next</a> &nbsp;&nbsp;
			<a href="/chain/page<?php echo $CHAINS['param']['totalPages']; ?>?pp=<?php echo $CHAINS['param']['perPage']; ?>" id = "imgLast">Last</a>
		</div>
		
		<div style="float:left; width:195px;" id = 'recordsPerPage' align = "right">
			Items per page:
			<?php echo ($CHAINS['param']['perPage'] == '10') ? '<strong>10</strong>' : '<a href="'.current_url().'?pp=10" id = "10PerPage">10</a>'; ?> |
			<?php echo ($CHAINS['param']['perPage'] == '20') ? '<strong>20</strong>' : '<a href="'.current_url().'?pp=20" id = "20PerPage">20</a>'; ?> | 
			<?php echo ($CHAINS['param']['perPage'] == '40') ? '<strong>40</strong>' : '<a href="'.current_url().'?pp=40" id = "40PerPage">40</a>'; ?>
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