<div id="mainarea">
	<ul id="menu">
		<li><a href="/mobile/restaurants/nearme">Sustainable Restaurants Near Me<span>Find sustainable restaurants near you</span></a></li>
		<li>
		
		<a href="#">Enter Zip Code</a>
			<span>
				<form method="post" name="find_restaurant_by_zip_code" action="<?php echo base_url()?>mobile/restaurants/findzipcode">
					<label for="zip_code">Zip Code: </label>
					<input type="text" name="zip_code" id="zip_code" value="" size="6" />
					<label for="distance">Distance: </label>
					<select name="distance" id="distance">
						<option>2</option>
						<option>7</option>
						<option>10</option>
						<option>20</option>
						<option>50</option>
					</select>(miles)
					<input type="submit" name="zip_code_btn" value="Go" />
					
				</form>
				
			</span>
		</li>

		<li><a href="/mobile/restaurants/browsebycity">Browse by City<span>Browse Restaurants by City</span></a></li>
	</ul>
</div>