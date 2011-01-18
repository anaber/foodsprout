<div id="tabs-2" class="ui-tabs-hide">
	At Food Sprout we are striving to reach deep into the your food supply chain.  Here you can start to learn more about the products you buy at the grocery.<br><br>
	<a href="/product/fructose" style="text-decoration:none;font-size:13px;">Products with High-Fructose</a><br/><br/>
	
	<div class="graybox">
		<span class="redtxt"><b>Quick Search by Brand</b></span>
			<br>
			<span style="font-size:14px;">Quickly find info about a specific product.<br><span style="font-size:11px;" class="redtxt">(e.g. Odwalla, Kelloggs).</span>
						<br>
						<div align="center" style="font-size:18px;">
							<form action="/manufacture" method="post">
								Search: <input type="text" name="f" value="" id="f" size="30" syle="font-size: 20px;" />
								<input type="submit" name="submit" value="Find" syle="font-size: 24px;" />
							</form>
						</div>
				</div>
	<br/><br/>Recently Added Products<br>
	<?php
		foreach ($NEWPRODUCTS as $key1) {
			echo '<a href="/manufacture/'.$key1->customURL.'" style="text-decoration:none;font-size:13px;">'.$key1->productName.'</span></a><br> ';
		}
	?><br><br>
</div>