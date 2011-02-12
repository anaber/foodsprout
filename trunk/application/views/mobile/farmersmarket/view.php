<div id="mainarea">
	<div id="producer_view">
		<h1><?php echo isset($producer[0]['producer']) ? $producer[0]['producer']: ''; ?></h1>
		<?php $this->load->view('mobile/includes/map'); ?>
		<div id="website">
			<?php 
				$url = isset($producer[0]['url']) ? $producer[0]['url']: ''; 
				echo '<a href="'.$url.'" >'.$url.'</a>';
			?>
		</div>
		
		<?php 
			if(sizeof($supliers) > 0 ){ 
				echo '<div id="supliers" >';
				foreach($supliers as $suplier){
					
					echo '<div id ="suplier>'; 
							
						print_r($suplier);
					
					echo '</div>"'; 
					
				}	
				echo '</div>';
			}
		?>
			
			
		
	</div>
</div>	