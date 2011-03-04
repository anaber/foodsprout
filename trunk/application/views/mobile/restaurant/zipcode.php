<div id="mainarea">
	<ul id="menu">
		<li>
			<form method="post" name="find_restaurant_by_zip_code" action="<?php echo base_url()?>mobile/restaurants/findzipcode">
			<label for="zip_code">Zip Code: </label>
			<input type="text" name="zip_code" id="zip_code" value="" size="6" />
			<br /><label for="distance">Distance: </label>
			<select name="distance" id="distance">
				<option>2</option>
				<option>7</option>
				<option>10</option>
				<option>20</option>
				<option>50</option>
			</select> (miles) <br/>
			
			<input type="submit" name="zip_code_btn" value="Go" />
			</form>	
			<span></span>
		</li>
	</ul>
</div>	