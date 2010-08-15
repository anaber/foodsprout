<script>
	
	$(document).ready(function() {
		$("#exploreFastFood").click(function(e) {
			e.preventDefault();
			document.frmExploreFood.submit();
		});	
	});
	
</script>
<div >
		<strong class="redtxt">Mapping the world's food chain, and what's really in your food, start exploring it with us</strong><br><br>
			
			<div style="-moz-border-radius: 4px; -webkit-border-radius: 4px; background: #D2E4C9; color: #000; -moz-box-shadow: 0 1px 0 #CCCCCC;-webkit-box-shadow: 0 1px 0 #CCCCCC; padding:30px;overflow:auto;min-height:250px;">
				<img src="/img/home-menu.jpg" border="0" align="right" height = "250" style="margin-right: 0px; margin-left:10px;">
					<span class="redtxt"><br><br><br><br><br><b>Restaurants in Your Area</b></span>
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
	
</div>
		
<br>

<div id="homerightbox">
	<div style="padding-left:5px;">
		<span class="greentxt">Food Resources &amp; FAQs</span><br><br>
		<div style="float:left; width:260px; font-size:18px; line-height:150%;">
			<a href = "/chain/fastfood">Explore Restaurant Chains</a><br>
			<!-- Resources for Moms<br>
			Where Food Comes From<br -->
			<a href="/about">Our Mission</a><br>
			<!-- FAQs<br-->
			
		</div>

		<div style="float:right; width:205px; font-size:12px;">
			
		</div>			
	</div>
</div>

<form name = "frmExploreFood" action = "/restaurant" method = "post">
	<input type = "hidden" name = "f" id = "f" value = "r_10">
</form>

<div id="homeleftbox">
	<a href="/map"><img src="/img/map-home.jpg" border="0" align="left" style="margin-right: 5px;" width="200"></a><span class="redtxt"><b>Food Sources in Your Area</b></span><br><br><span style="font-size:14px;">Start using <a href="/map">our interactive map</a> to learn where your food comes from AND what's in it...</span><br><br>		
</div>

