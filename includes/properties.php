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

$ENV_PROPERTY_FILE = "env_properties/staging_server.php"; 

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
$FARMERS_MARKET_ZOOM_LEVEL = 13;
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
					'max' => 12,
					'step' => 2,
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

$LANDING_PAGE = '/login';
$ADMIN_LANDING_PAGE = '/admincp/login';
//$BUSINESS_LANDING_PAGE = '/business/login';
$BUSINESS_LANDING_PAGE = '/business/register/step1';

$RECOMMENDED_CITIES = array (
					'San Francisco',
					'Berkeley',
					'Oakland',
					'San Jose',
					'New York',
					'Los Angeles',					
				);

$PRODUCER_CATEGORY_GROUP = array(
					'CUISINE' 		=> 1,
					'RESTAURANT' 	=> 2,
					'FARM' 			=> 3,
					'MANUFACTURE' 	=> 4,
					'FARM_CROP' 	=> 5,
					'CERTIFICATION' => 7,
					
				);


$USER_GROUP = array(
					'ADMIN' 			=> 1,
					'CONTRIBUTOR' 		=> 2,
					'BUSINESS_OWNER' 	=> 7,
				);

$PORTLET = array(
					'dashboard' => array(
						'column_1' => array(
							'recent_restaurants',
							'my_favorites',
							'recent_comments',
						),
						'column_2' => array(
							'place_i_ate',
							'carbon_chart',
							'topics_following',
						)
					)
				);

?>
