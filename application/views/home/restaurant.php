<div id="tabs-1">
	<a href = "/chain/fastfood" style="text-decoration:none;">Explore Restaurant Chains</a><br><img src="/img/homech.jpg" align="left" style="padding:4px;"><span style="font-size:14px;">Use this feature to learn more about the larger chains from McDonald's to TGI Friday's.  If they have multiple locations, odds are they are here.</span><br/><br/><br/>
	<!-- a href="#">Our Recommendations</a><br><br-->
	<div style="-moz-border-radius: 4px; -webkit-border-radius: 4px; background: #e5e5e5; color: #000; -moz-box-shadow: 0 1px 0 #CCCCCC;-webkit-box-shadow: 0 1px 0 #CCCCCC; padding:10px;overflow:auto;">
						<span class="redtxt"><b>Find Restaurants in Your Area</b></span>
						<br>
						<span style="font-size:14px;">See where your local restaurant is getting its food from or share what you know.</span>
						<br>
						<div align="center" style="font-size:18px;">
							<form action="/restaurant" method="post">
								Zip Code: <input type="text" name="q" value="" id="q" maxlength="5" size="10" syle="font-size: 20px;" />
								<input type="submit" name="submit" value="Find" syle="font-size: 24px;" />
							</form>
						</div>
				</div>
				<br><br>
		Recently Added<br>
		<?php
			foreach ($NEWREST as $key1) {
				echo '<a href="/restaurant/view/'.$key1->restaurantId.'" style="text-decoration:none;">'.$key1->restaurantName.'</span></a>, ';
			}
		?>
		<br><br>
		
		
	<form name = "frmExploreFood" action = "/restaurant" method = "post">
		<input type = "hidden" name = "f" id = "f" value = "r_10">
	</form>
</div>