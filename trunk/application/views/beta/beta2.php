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
			
			<div style="-moz-border-radius: 4px; -webkit-border-radius: 4px; background: #D2E4C9; color: #000; -moz-box-shadow: 0 1px 0 #CCCCCC;-webkit-box-shadow: 0 1px 0 #CCCCCC; padding:30px;overflow:auto;min-height:400px;">
				<img src="/images/home-menu.jpg" border="0" align="right" style="margin-right: 0px; margin-left:10px;">
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