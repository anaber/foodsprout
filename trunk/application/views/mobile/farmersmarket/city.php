<div id="mainarea">
	<ul id="menu">
		<li>
			<div id="foundStatus"></div>
			<br />
		</li>
		<li>	
			<form method="post" name="findCity" action="<?php echo base_url()?>mobile/farmersmarket/bycity/">
				<label>City </label>
				 <input name="city" id="city" value="" />
				<br />
				<input type="submit" name="search_city" value="Search" />
			</form>	
			<span></span>
		</li>
	</ul>
</div> 			
			
		
<?php if( isset($cities) && sizeof($cities) > 0){	 ?>
		
<div id="mainarea">
	<ul id="menu">
		<li>
			<p>More that one city has been found for your search. Please select the city from where you want to see results</p>
			
			<?php
				foreach($cities as $city){
					
					echo '<span><a href="'.base_url().'mobile/farmersmarket/by_city/'.$city['city_id'].'" >'.$city['city'].'</a></span><br />';
				
				}
			?>
		</li>
	</ul>
</div>
<?php } ?>


			
<?php $this->load->view('mobile/farmersmarket/list');?>
			
		