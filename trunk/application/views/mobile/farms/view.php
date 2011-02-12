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
	</div>
</div>	

<?php 
		
if(sizeof($supliers) > 0 ){ ?>		
	<div id="mainarea">
		<div id="" >
			<?php 
					echo '<ul  id="menu">';
						foreach ($supliers as $result ){
							
							echo '<li>';
								echo 	'<a href="'.base_url().'mobile/farms/view-'.$result['custom_url'].'">
										'.$result['producer'].'<span>City: <strong>'.$result['city'].'</strong>, address: <strong>
										'.$result['address'].' </strong>';	
							echo '</li>'; 	              
						}
					echo '</ul>';
				
				?>
		</div>
	</div>	

<?php } ?>