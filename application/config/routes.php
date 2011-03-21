<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| 	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved 
| routes must come before any wildcard or regular expression routes.
|
*/


$route['default_controller'] = "home";

// RESTAURANT
$route['^restaurant/ajaxGetAllCuisine'] 				= "restaurant/ajaxGetAllCuisine";
$route['^restaurant/ajaxGetAllRestaurantType'] 			= "restaurant/ajaxGetAllRestaurantType";
$route['^restaurant/ajaxGetDistinctUsedCuisine'] 		= "restaurant/ajaxGetDistinctUsedCuisine";
$route['^restaurant/ajaxGetDistinctUsedRestaurantType'] = "restaurant/ajaxGetDistinctUsedRestaurantType";
$route['^restaurant/ajaxSearchRestaurantComments'] 		= "restaurant/ajaxSearchRestaurantComments";
$route['^restaurant/ajaxSearchRestaurantInfo'] 			= "restaurant/ajaxSearchRestaurantInfo";
$route['^restaurant/ajaxSearchRestaurantMenus'] 		= "restaurant/ajaxSearchRestaurantMenus";
$route['^restaurant/ajaxSearchRestaurantPhotos'] 		= "restaurant/ajaxSearchRestaurantPhotos";
$route['^restaurant/ajaxSearchRestaurants'] 			= "restaurant/ajaxSearchRestaurants";
$route['^restaurant/ajaxSearchRestaurantSuppliers'] 	= "restaurant/ajaxSearchRestaurantSuppliers";
$route['^restaurant/map'] 								= "restaurant/map";
$route['^restaurant/save_add'] 							= "restaurant/save_add";
$route['^restaurant/save_update'] 						= "restaurant/save_update";
$route['^restaurant/view/(:num)'] 						= "restaurant/view/$1";
$route['^restaurant'] 									= "restaurant/index";
$route['^sustainable/(:any)'] 							= "restaurant/city/$1";
$route['^restaurant/(:any)']							= "restaurant/customUrl/$1";
$route['^mobile/restaurants/findnearme']				= "mobile/restaurants/findnearme";
$route['^mobile/restaurants/nearme']					= "mobile/restaurants/nearme";
$route['^mobile/restaurants/browsebycity']				= "mobile/restaurants/browsebycity";
$route['^mobile/restaurants/findzipcode']				= "mobile/restaurants/findzipcode";
$route['^mobile/restaurants/cityrestaurantlist/(:any)']	= "mobile/restaurants/cityrestaurantlist/$1";
$route['^mobile/restaurants/(:any)']					= "mobile/restaurants/customUrl/$1";
        
// Farm
$route['^farm/ajaxGetAllFarmType'] 						= "farm/ajaxGetAllFarmType";
$route['^farm/ajaxGetDistinctUsedFarmType'] 			= "farm/ajaxGetDistinctUsedFarmType";
$route['^farm/ajaxSearchFarmComments'] 					= "farm/ajaxSearchFarmComments";
$route['^farm/ajaxSearchFarmCompanies'] 				= "farm/ajaxSearchFarmCompanies";
$route['^farm/ajaxSearchFarmInfo'] 						= "farm/ajaxSearchFarmInfo";
$route['^farm/ajaxSearchFarmPhotos'] 					= "farm/ajaxSearchFarmPhotos";
$route['^farm/ajaxSearchFarms'] 						= "farm/ajaxSearchFarms";
$route['^farm/ajaxSearchFarmSuppliee'] 					= "farm/ajaxSearchFarmSuppliee";
$route['^farm/view/(:num)'] 							= "farm/view/$1";
$route['^mobile/farms/findnearme']						= "mobile/farms/findnearme";
$route['^mobile/farms/nearme']							= "mobile/farms/nearme";
$route['^mobile/farms/zipcode']							= "mobile/farms/zipcode";
$route['^mobile/farms/bycity']							= "mobile/farms/bycity";
$route['^mobile/farms/by_city/(:any)']					= "mobile/farms/by_city/$1";
$route['^mobile/farms/(:any)'] 							= "mobile/farms/customUrl/$1";
$route['^farm/(:any)']									= "farm/customUrl/$1";

// Farmers Market
$route['^farmersmarket/ajaxSearchFarmersMarket'] 				= "farmersmarket/ajaxSearchFarmersMarket";
$route['^farmersmarket/ajaxSearchFarmersMarketComments'] 		= "farmersmarket/ajaxSearchFarmersMarketComments";
$route['^farmersmarket/ajaxSearchFarmersMarketInfo'] 			= "farmersmarket/ajaxSearchFarmersMarketInfo";
$route['^farmersmarket/ajaxSearchFarmersMarketPhotos'] 			= "farmersmarket/ajaxSearchFarmersMarketPhotos";
$route['^farmersmarket/ajaxSearchFarmersMarketSuppliers'] 		= "farmersmarket/ajaxSearchFarmersMarketSuppliers";
$route['^farmersmarket/view/(:num)'] 							= "farmersmarket/view/$1";
$route['^farmersmarket/city/(:any)'] 							= "farmersmarket/city/$1";
$route['^farmersmarket/(:any)']									= "farmersmarket/customUrl/$1";
$route['^mobile/farmersmarkets/findnearme']						= "mobile/farmersmarkets/findnearme";
$route['^mobile/farmersmarkets/nearme']							= "mobile/farmersmarkets/nearme";
$route['^mobile/farmersmarkets/zipcode']						= "mobile/farmersmarkets/zipcode";
$route['^mobile/farmersmarkets/bycity']							= "mobile/farmersmarkets/bycity";
$route['^mobile/farmersmarkets/by_city/(:any)']					= "mobile/farmersmarkets/by_city/$1";
$route['^mobile/farmersmarkets/(:any)']							= "mobile/farmersmarkets/customUrl/$1";


// Manufacture
$route['^manufacture/page(:num)']							= "manufacture/index/$1";
$route['^manufacture/ajaxSearchManufactureComments'] 		= "manufacture/ajaxSearchManufactureComments";
$route['^manufacture/ajaxSearchManufactureInfo'] 			= "manufacture/ajaxSearchManufactureInfo";
$route['^manufacture/ajaxSearchManufactureMenus'] 			= "manufacture/ajaxSearchManufactureMenus";
$route['^manufacture/ajaxSearchManufacturePhotos'] 			= "manufacture/ajaxSearchManufacturePhotos";
$route['^manufacture/ajaxSearchManufactures'] 				= "manufacture/ajaxSearchManufactures";
$route['^manufacture/ajaxSearchManufactureSuppliers'] 		= "manufacture/ajaxSearchManufactureSuppliers";
$route['^manufacture/get_manufactutes_for_auto_suggest'] 	= "manufacture/get_manufactutes_for_auto_suggest";
$route['^manufacture/searchManufactures'] 					= "manufacture/searchManufactures";
$route['^manufacture/view/(:num)'] 							= "manufacture/view/$1";
$route['^manufacture/(:any)']								= "manufacture/customUrl/$1";

// Chain
$route['^chain/ajaxSearchRestaurantChainComments'] 		= "chain/ajaxSearchRestaurantChainComments";
$route['^chain/ajaxSearchRestaurantChainMenus'] 		= "chain/ajaxSearchRestaurantChainMenus";
$route['^chain/ajaxSearchRestaurantChainPhotos'] 		= "chain/ajaxSearchRestaurantChainPhotos";
$route['^chain/ajaxSearchRestaurantChains'] 			= "chain/ajaxSearchRestaurantChains";
$route['^chain/ajaxSearchRestaurantChainSuppliers'] 	= "chain/ajaxSearchRestaurantChainSuppliers";
$route['^chain/fastfood'] 								= "chain/fastfood";
$route['^chain/view/(:num)'] 							= "chain/view/$1";
$route['^chain/page(:num)']								= "chain/index/$1";
$route['^chain/(:any)']									= "chain/customUrl/$1";

// Product
$route['^product/']										= "product/index";
$route['^product/search']								= "product/search";
$route['^product/fructose']								= "product/fructose";
$route['^product/ajaxSearchProducts']					= "product/ajaxSearchProducts";
$route['^product/addeaten']								= "product/addeaten";
$route['^product/eaten/(:any)']							= "product/eaten/$1";
$route['^product/search/(:any)']						= "product/search/$1";
$route['^product/(:any)']								= "product/customUrl/$1";
 
// ADMINCP
$route['^admincp'] 										= "admincp/dashboard";

$route['scaffolding_trigger'] = "";

/* End of file routes.php */
/* Location: ./system/application/config/routes.php */