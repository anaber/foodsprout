<div id="mainarea">
	<ul id="menu">
		<li>
			<form method="post" name="find_restaurant_by_zip_code" action="<?php echo base_url()?>mobile/restaurants/findzipcode">
			<label for="zip_code">Zip Code: </label>
			<input type="text" name="zip_code" id="zip_code" value="" />
			<br /><label for="distance">Distance: </label>
			<select name="distance" id="distance">
				<option>2</option>
				<option>7</option>
				<option>10</option>
				<option>20</option>
				<option>50</option>
			</select>(miles)
			
			<input type="submit" name="zip_code_btn" value="Go" />
			</form>	
			<span></span>
		</li>
	</ul>
</div>	



<div id="mainarea">
	<div id="search_by_zip_code_results" >
		<?php 
			if(sizeof($search_results) >0){
				echo '<ul  id="menu">';
					foreach ($search_results as $result ){
						echo '<li>';
							echo 	'<a href="'.base_url().'mobile/restaurants/'.$result['custom_url'].'">
									'.$result['producer'].'<span>City: <strong>'.$result['city'].'</strong>, address: <strong>
									'.$result['address'].', </strong>
									cuisine: '.$result['cuisine'].'</span></a>';	
						echo '</li>'; 
						/* original code */
						/* 
						echo '<li>';
							echo 	'<a href="'.base_url().'mobile/restaurants/view-'.$result['custom_url'].'">
									'.$result['producer'].'<span>City: <strong>'.$result['city'].'</strong>, address: <strong>
									'.$result['address'].', </strong>
									cuisine: '.$result['cuisine'].'</span></a>';	
						echo '</li>'; 	
						*/              
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