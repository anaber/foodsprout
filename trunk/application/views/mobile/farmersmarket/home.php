<div id="mainarea">
	<ul id="menu">
		<li><a href="/mobile/farmersmarkets/findnearme">Sustainable Farmers Market Near Me<span>Find sustainable farmers market near you</span></a></li>
		<li>
			<a href="#">Enter Zip Code</a>
			<span>
				<form method="post" name="find_farmersmarket_by_zip_code" action="<?php echo base_url()?>mobile/farmersmarkets/zipcode">
					<label for="zip_code">Zip Code: </label>
					<input type="text" name="zipcode" id="zipcode" value="" size="6" />
					<label for="distance">Distance: </label>
					<select name="distance" id="distance">
						<option>2</option>
						<option>7</option>
						<option>10</option>
						<option>20</option>
						<option>50</option>
					</select>(miles)
					<input type="submit" name="search_zipcode" value="Go" />	
				</form>
				
			</span>
		</li>
		
		
		<li><a href="/mobile/farmersmarkets/bycity">Browse by City<span>Browse Farmers Market by City</span></a></li>
	</ul>
</div>