<script>
	
	$(document).ready(function() {
		$("#exploreFastFood").click(function(e) {
			e.preventDefault();
			document.frmExploreFood.submit();
		});	
	});
	
</script>
<script src="<?php echo base_url()?>js/jquery-ui-1.8.4.custom.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {
		$("#tabs").tabs({
			event: 'mouseover'
		});
	});
	</script>

<h1>Explore Your Food Impact By:</h1><br/>
<div id="tabs">
<div id="homevtabs">
	<br/><ul>
		<li><a href="#tabs-1">Restaurants</a></li>
		<li><a href="#tabs-2">Products</a></li>
		<li><a href="#tabs-3">Farms</a></li>
		<li><a href="#tabs-4">Recommendations</a></li>
		<li><a href="#tabs-5">Resources</a></li>
	</ul>
</div>

<div style="float:left; width:490px;">
	
		<div id="tabs-1">
			<a href = "/chain/fastfood" style="text-decoration:none;">Explore Restaurant Chains</a><br><br>
			<a href="#">Our Recommendations</a><br><br>
			<div style="-moz-border-radius: 4px; -webkit-border-radius: 4px; background: #D2E4C9; color: #000; -moz-box-shadow: 0 1px 0 #CCCCCC;-webkit-box-shadow: 0 1px 0 #CCCCCC; padding:10px;overflow:auto;">
							<img src="/images/home-menu.jpg" border="0" align="right" style="margin-right: 0px; margin-left:10px;">
								<span class="redtxt"><b>Restaurants in Your Area</b></span>
								<br>

									<span style="font-size:12px;">Learn what Restaurants in your area have joined us in telling <b>YOU</b> where its food comes from!</span>
										<br><br>

										<div align="center" style="font-size:24px;">
											<form action="/restaurant" method="post">
												Zip Code: <input type="text" name="q" value="" id="q" maxlength="5" size="10" syle="font-size: 24px;" />

											<input type="submit" name="submit" value="Find" syle="font-size: 24px;" />
											</form>
										</div>

						</div>
						<br><br>
				Recently Added:<br>
				<a href="#">Restaurant 1</a>, <a href="#">Restaurant 2</a>, <a href="#">Restaurant 3</a><br><br>
				Worst Offenders:<br>
				<a href="#">McDonalds</a>, <a href="#">Burger King</a>, <a href="#">Subway</a><br><br>
				
			<form name = "frmExploreFood" action = "/restaurant" method = "post">
				<input type = "hidden" name = "f" id = "f" value = "r_10">
			</form>
		</div>
		<div id="tabs-2">
			Product info<br><br>
			Recently Added:<br>
			<a href="#">Product 1</a>, <a href="#">Product 2</a>, <a href="#">Product 3</a><br><br>
		</div>
		<div id="tabs-3">
			farm info
		</div>
		<div id="tabs-4">
			recommendation
		</div>
		<div id="tabs-5">
		    resources
		</div>
	
</div>
</div>
<div style="float:right; width:300px;">
	<?php $this->load->view('includes/banners/medrec'); ?>
	<br/><div id="homeleftbox">
		<a href="/map"><img src="/img/map-home.jpg" border="0" width="300"></a><span class="redtxt"><br/><b>Food Sources in Your Area</b></span><br><br><span style="font-size:14px;">Start using <a href="/map">our interactive map</a> to learn where your food comes from AND what's in it...</span><br><br>		
	</div>
</div>