<div id="tabs-2">
	At Food Sprout we are striving to reach deep into the your food supply chain.  Here you can start to learn more about the products you buy at the grocery.<br><br>
	<a href="/product/fructose">Products with High-Fructose</a><br/><br/>
	
	<div style="-moz-border-radius: 4px; -webkit-border-radius: 4px; background: #e5e5e5; color: #000; -moz-box-shadow: 0 1px 0 #CCCCCC;-webkit-box-shadow: 0 1px 0 #CCCCCC; padding:10px;overflow:auto;">
		<span class="redtxt"><b>Quick Search by Brand</b></span>
			<br>
			<span style="font-size:14px;">Quickly find info about a specific product.<br><span style="font-size:11px;" class="redtxt">(e.g. Odwalla, Kelloggs).</span>
						<br>
						<div align="center" style="font-size:18px;">
							<form action="/search" method="post">
								Search: <input type="text" name="q" value="" id="q" maxlength="5" size="30" syle="font-size: 20px;" />
								<input type="submit" name="submit" value="Find" syle="font-size: 24px;" />
							</form>
						</div>
				</div>
	<br/><br/>Recently Added Products<br>
	<?php
		foreach ($NEWPRODUCTS as $key1) {
			echo '<a href="/product/view/'.$key1->productId.'" style="text-decoration:none;">'.$key1->productName.'</span></a>, ';
		}
	?><br><br>
</div>