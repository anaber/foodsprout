<div style="float:left;width:600px; padding-left:10px;">
	<h1>Restaurant Chains</h1>
	
	<?php
	if (count($CHAINS) > 0 ) 
	{
		print_r($CHAINS);
		$i = 1;
		echo '<div class="chainlist">';
		foreach($CHAINS as $r) :
			
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
</div>

<div style="float:right; width:160px;">
	<?php
		$this->load->view('includes/banners/sky');
	?>
</div>