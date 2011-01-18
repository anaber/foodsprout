<div id="tabs-1" class="ui-tabs-hide">
	
	<div>
	<h2>View Sustainable Restaurants in Your City</h2>
	<div class="city">
	<a href="/sustainable/san-francisco">San Francisco</a><br/>
	<a href="/sustainable/berkeley">Berkeley</a><br/>
	<a href="/sustainable/oakland">Oakland</a><br/>
	</div>
	<div class="city">
	<a href="/sustainable/san-jose">San Jose</a><br/>
	<a href="/sustainable/new-york">New York</a><br/>
	<a href="/sustainable/los-angeles">Los Angeles</a><br/>
	
	</div>
	<a href="/cities">More cities</a>
	</div>
	
	<br/><br/><br/><br><br><br>
	
		<h3>Recently Added Restaurants</h3>
		<div style="float:left;width:230px;">
		<?php
			$x=1;
			foreach ($NEWREST as $key1) {
				$x++;
				echo '<a href="/restaurant/'.$key1->restaurantId.'" style="text-decoration:none;font-size:13px;">'.$key1->restaurantName.'</span></a><br/> ';
				if($x=6)
				{
					echo '</div><div style="float:left;width:230px;">';
				}
			}
		?>
		</div>
		<br><br><br><br><br><br>
		
		<h4>Explore Restaurant Chains</h4><img src="/img/homech.jpg" align="left" style="padding:4px;"><span style="font-size:14px;">Use this feature to learn more about the larger chains from McDonald's to TGI Friday's.  If they have multiple locations, odds are they are here.  <a href="/chain" style="font-size:13px;text-decoration:none;">Start exploring chains now...</a></span><br/>
		<br><br>
		<h4>About Food Sprout</h4><span style="font-size:14px;">
		We are striving to make your food supply chain transparent.  Ever wonder where the food you are about to eat really came from?  With charts like these we hope to show you visually and provide you the data to make choices.<br></span><img src="/img/home-map.jpg" alt="Food Supply Map" width="460" height="161">
					<br><br>
		
		
	<form name = "frmExploreFood" action = "/restaurant" method = "post">
		<input type = "hidden" name = "f" id = "f" value = "r_10">
	</form>
</div>