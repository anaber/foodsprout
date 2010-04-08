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

$ENV_PROPERTY_FILE = "env_properties/deepak.php";

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


$SUPPLIER_TYPE = array(
					'farm' 			=> 'Farm',
					'restaurant' 	=> 'Restaurant', 
					'distributor' 	=> 'Distributor',
					'manufacture' 	=> 'Manufacture',
				);
				
?>
