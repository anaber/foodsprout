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

$ENV_PROPERTY_FILE = "env_properties/live_server.php";

include($ENV_PROPERTY_FILE);

/*
 * ======================================================
 * Applicaton Details
 * ======================================================
 */
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

/*
 * ======================================================
 * ZOOM Level
 * ======================================================
 */

$DEFAULT_ZOOM_LEVEL = 3;
$FARM_ZOOM_LEVEL = 7;
$CITY_ZOOM_LEVEL = 11;
$ZIPCODE_ZOOM_LEVEL = 13;

/*
 * ======================================================
 * Radius Search
 * ======================================================
 */
$FARM_DEFAULT_RADIUS = 20;
$FARM_RADIUS = array(
					'min' => 0,
					'max' => 120,
					'step' => 20,
				);

$FARMERS_MARKET_DEFAULT_RADIUS = 5;
$FARMERS_MARKET_RADIUS = array(
					'min' => 0,
					'max' => 20,
					'step' => 5,
				);



/*
 * ======================================================
 * Activilty Level
 * ======================================================
 */
$ACTIVITY_LEVEL = array(
					0 => "Inactive",
					1 => "Active", 
				);

$ACTIVITY_LEVEL_DB = array(
					'active' => 1,
					'inactive' => 0, 
				);

$STATUS = array(
					'live' => "Live",
					'queue' => "Queue", 
					'hide' => "Hide",
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
					'farmers_market_supplier' => 	array(
									'farm' 			=> 'Farm',
							),
					
				);


$FARMER_TYPES = array(
					'natural' 			=> 'Natural',
					'organic' 			=> 'Organic',
				);

$LANDING_PAGE = '/about/privatebeta';
$ADMIN_LANDING_PAGE = '/admincp/login';

$RECOMMENDED_CITIES = array (
					'San Francisco',
					'Berkeley',
					'Oakland',
					'San Jose',
					'New York',
					'Los Angeles',					
				);
			
?>
