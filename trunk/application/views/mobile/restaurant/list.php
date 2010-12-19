<div id="mainarea">
	<ul id="menu">
		<li>
			
			<p><?php echo $results['totalrecords']; ?> results found</p>
			<p>you are now on page <?php echo $searched_page; ?> viewing results form <?php echo $start; ?> to <?php echo $stop; ?></p>
		</li>
		<li>	
			<form method="post" name="getNextPage" action="<?php echo base_url()?>mobile/restaurants/cityrestaurantlist/<?php echo $city_id; ?>">
			<label for="page">jump to page: </label>
			<select name="page" id="page">
				<?php 
					foreach($pages as $page){						
						echo '<option '; 						
						if($page == $searched_page){							
							echo 'selected="selected"';							
						}					
						echo '>'.$page.'</option>';
					}
				?>
			</select>			
			<input type="submit" name="jump_to" value="Go" />
			</form>	
			<span></span>
		</li>
	</ul>
</div>	



<div id="mainarea">
	<div id="search_by_zip_code_results" >
		<?php 
			if(sizeof($results['data']) >0){
				echo '<ul  id="menu">';
					foreach ($results['data'] as $result ){
						
						echo '<li>';
							echo 	'<a href="'.base_url().'/mobile/restaurants/viewrestaurant/'.$result['address_id'].'/'.$result['producer_id'].'">
									'.$result['producer'].'<span>City: <strong>'.$result['city'].'</strong>, address: <strong>
									'.$result['address'].', </strong>
									cuisine: '.$result['cuisine'].'</span></a>';	
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