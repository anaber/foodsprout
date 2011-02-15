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
			<?php 
					echo '<ul  id="menu">';
					
						
						echo '<li><div id="supliersLabelDiv">Suppliers</div></li>';
						
						foreach ($supliers as $suplier ){				
							echo '<li>';
								echo '<a href="'.base_url().'mobile/'.$suplier->supplierType.'s/'.$suplier->customUrl.'">'.$suplier->supplierName.'<span>';
								echo '<strong>Type:</strong>'.$suplier->supplierType.', <strong>Address:</strong> '.$suplier->addresses[0]->completeAddress. '</span></a>';
							echo '</li>'; 	              
						}
					echo '</ul>';
				?>
	</div>	

<?php } ?>