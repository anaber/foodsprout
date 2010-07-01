<?php
/*
 * Author - Deepak Kumar
 * Created on Feb 19, 210
 *
 * Some configuration parameters are also defined here.
 */
/*
 * ======================================================
 * Environment Settings
 * ======================================================
 */

$ENV_PROPERTY_FILE = "env_properties/test_server.php";

include($ENV_PROPERTY_FILE);

/*
 * ======================================================
 * Applicaton Details
 * ======================================================
 */
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

$ACTIVITY_LEVEL = array(
					0 => "Inactive",
					1 => "Active", 
				);

$ACTIVITY_LEVEL_DB = array(
					'active' => 1,
					'inactive' => 0, 
				);


$SUPPLIER_TYPES = array(
					'farm' 			=> 'Farm',
					'restaurant' 	=> 'Restaurant', 
					'distributor' 	=> 'Distributor',
					'manufacture' 	=> 'Manufacture',
				);

$SUPPLIER_TYPES_2 = array (
					'farm_supplier' => 	array(
									'farm' 			=> 'Farm',
									'restaurant' 	=> 'Restaurant', 
									'distributor' 	=> 'Distributor',
									'manufacture' 	=> 'Manufacture',
							),
					'restaurant_supplier' => 	array(
									'farm' 			=> 'Farm',
									'restaurant' 	=> 'Restaurant', 
									'distributor' 	=> 'Distributor',
									'manufacture' 	=> 'Manufacture',
							),
					'distributor_supplier' => 	array(
									'farm' 			=> 'Farm',
									'restaurant' 	=> 'Restaurant', 
									'distributor' 	=> 'Distributor',
									'manufacture' 	=> 'Manufacture',
							),
					'manufacture_supplier' => 	array(
									'farm' 			=> 'Farm',
									'restaurant' 	=> 'Restaurant', 
									'distributor' 	=> 'Distributor',
									'manufacture' 	=> 'Manufacture',
							),
					'restaurant_chain_supplier' => 	array(
									'farm' 			=> 'Farm',
									'distributor' 	=> 'Distributor',
									'manufacture' 	=> 'Manufacture',
							),
					
				);


$FARMER_TYPES = array(
					'natural' 			=> 'Natural',
					'organic' 			=> 'Organic',
				);
				
?>
