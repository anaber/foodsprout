<div style="float:left;width:600px; padding-left:10px;">
	<h1>Restaurant Chains</h1>
	
	<?php
	if (count($CHAINS['param']['numResults']) > 0 ) {
		
		$i = 1;
		echo '<div class="chainlist">';
		foreach($CHAINS['results'] as $r) :
			
			echo anchor('/chain/view/'.$r->restaurantChainId, $r->restaurantChain).'<br />';
			if($i == 30)
			{
				echo '</div>';
				echo '<div class="chainlist">';
				$i = 0;
			}
			$i++;
	 	endforeach;
	
	} else {
		echo "<div>No restaurant chains available.";
	}
	
	?>
	</div>
	
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
		
		<div style="float:left; width:150px; font-size:10px;" id = 'numRecords'>Records <?php echo $CHAINS['param']['start']; ?>-<?php echo $CHAINS['param']['end']; ?> of <?php echo $CHAINS['param']['numResults']; ?></div>

		<div style="float:left; width:250px; font-size:10px;" id = 'pagingLinks' align = "center">
			<a href="/chain?pp=<?php echo $CHAINS['param']['perPage']; ?>" id = "imgFirst">First</a> &nbsp;&nbsp;
			<a href="/chain/page<?php echo $prevpage; ?>?pp=<?php echo $CHAINS['param']['perPage']; ?>">Previous</a>
			&nbsp;&nbsp;&nbsp; Page <?php echo $currentpage; ?> of <?php echo $CHAINS['param']['totalPages']; ?> &nbsp;&nbsp;&nbsp;
			<a href="/chain/page<?php echo $nextpage; ?>?pp=<?php echo $CHAINS['param']['perPage']; ?>">Next</a> &nbsp;&nbsp;
			<a href="/chain/page<?php echo $CHAINS['param']['totalPages']; ?>?pp=<?php echo $CHAINS['param']['perPage']; ?>" id = "imgLast">Last</a>
		</div>
		
		<div style="float:left; width:195px; font-size:10px;" id = 'recordsPerPage' align = "right">
			Items per page:
			<div id = "40PerPage" style="float:right; width:30px;"><?php echo '<a href="'.current_url().'?pp=60">60</a>'; ?></div>  
			<div id = "20PerPage" style="float:right; width:30px;"><?php echo '<a href="'.current_url().'?pp=40">40</a>'; ?> | </div>
			<div id = "10PerPage" style="float:right; width:30px;"><?php echo '<a href="'.current_url().'?pp=20">20</a>'; ?> | </div>
		</div>
	</div>
	
	<?php
	/*
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
	?><div style="float:left; width:350px;" class="paging">
	<a href="/chain/page<?php echo $prevpage; ?>">Prev</a> <a href="/chain/page1">1</a> <a href="/chain/page2">2</a> <a href="/chain/page3">3</a> <a href="/chain/page4">4</a> <a href="/chain/page<?php echo $nextpage; ?>">Next</a></div><div style="float:right; width:250px; font-size:14px; text-align:right;">1 - 10 of 200 | Items Per Page 10 20 40</div>
	</div>
	<?php
	*/
	?>
	
</div>

<div style="float:right; width:160px;">
	<?php
		$this->load->view('includes/banners/sky');
	?>
</div>