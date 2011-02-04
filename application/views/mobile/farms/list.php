		
<div id="mainarea">
	<div id="search_by_zip_code_results" >
		<?php 
			
		
			if(isset($search_results) && sizeof($search_results) > 0){
				
				echo '<ul  id="menu">';
					foreach ($search_results as $result ){
						
						echo '<li>';
							echo 	'<a href="'.base_url().'mobile/farms/view-'.$result['custom_url'].'">
									'.$result['producer'].'<span>City: <strong>'.$result['city'].'</strong>, address: <strong>
									'.$result['address'].' </strong>';	
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