<div id="mainarea">
	<ul id="menu">
		<li>
			<form method="post" name="find_by_zip_code" action="<?php echo base_url()?>mobile/farmersmarkets/zipcode">
			<label for="zip_code">Zip Code: </label>
			<input type="text" name="zipcode" id="zipcode" value="" size="6" />
			<br /><label for="distance">Distance: </label>
			<select name="distance" id="distance">
				<option>2</option>
				<option>6</option>
				<option>10</option>
				<option>20</option>
				<option>50</option>
			</select> (miles)<br/>
			
			<input type="submit" name="search_zipcode" value="Go" />
			</form>	
			<span></span>
		</li>
	</ul>
</div>	
	
<div id="mainarea">
	<div id="search_by_zip_code_results" >
		<?php 
			if(isset($search_results) && sizeof($search_results) > 0){
				echo '<ul  id="menu">';
					foreach ($search_results as $result ){
								
						echo '<li>';
							echo 	'<a href="'.base_url().'mobile/farmersmarkets/'.$result['custom_url'].'">
									'.$result['producer'].'<span>City: <strong>'.$result['city'].'</strong>, address: <strong>
									'.$result['address'].'</strong>';	
						echo '</li>'; 	              
					}
				echo '</ul>';
			}else{
				
				echo '
					<ul  id="menu">
						<li>no results found</li>
					</ul>';
 
			}
			?>
	</div>
</div>