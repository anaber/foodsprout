<?php

class Manufacture extends Controller {
	
	function __construct() {
		parent::Controller();
		checkUserLogin();
		checkUserAgent();
	}
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function index() {
		$data = array();
		
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('manufacture_list');
		
		// validate the data in the URL to make sure we don't have SQL injection
		$urlpage = substr($this->uri->segment(2),4,5);

		if(is_numeric($urlpage))
		{
			$page = $urlpage-1;
		} else {
			$page = 0;
		}
		
		if($this->input->get('pp'))
		{
			$number_perpage = $this->input->get('pp');
			if($number_perpage > 40)
			{
				$perpage = 20;
			}
			else{
				$perpage = $number_perpage;
			}
		}
		else{
			$perpage = 10;
		}
		
		$this->load->model('ManufactureModel');
		$manufactures = $this->ManufactureModel->getManufactures($page, $perpage);

		// If entered page is greater than retrieved totalPages, redirect to last page
		if( $urlpage > $manufactures['param']['totalPages'] )
			redirect("/manufacture/page".$manufactures['param']['totalPages']."?pp=".$manufactures['param']['perPage']);

		// SET TITLE TAG

		if( !empty($manufactures) ) {
			//convert std class to array
			$t_tag = $manufactures['results'][0]->manufactureName;
			$mcnt = count($manufactures['results'])-1;
			$t_tag .= " - ".$manufactures['results'][$mcnt]->manufactureName;

			$seo->titleTag = $t_tag." | ".$seo->titleTag;
		}
		
		// SET SEO
		$data['SEO'] = $seo;

		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/manufacture/manufacture_listb',
			);		
		
		$data['LEFT'] = array(
				'filter' => 'includes/left/manufacture_filter',
			);
			
		// Data to be passed to the views
		$data['data']['center']['list']['MANUFACTURES'] = $manufactures;
		
		$this->load->view('templates/left_center_template', $data);
	}
	
	function ajaxSearchManufactures() {
		$this->load->model('ManufactureModel', '', TRUE);
		$restaurants = $this->ManufactureModel->getManufactureJson();
		echo json_encode($restaurants);
	}
	
	function searchManufactures($q) {
		$this->load->model('ManufactureModel', '', TRUE);
		$manufactures = $this->ManufactureModel->searchManufactures($q);
		echo $manufactures;
	}
	
	
	/**
	 * Migration: 		Done
	 * Migrated by: 	Deepak
	 * 
	 * Verified: 		Yes
	 * Verified By: 	Deepak
	 */
	function get_manufactutes_for_auto_suggest() {
		$q = strtolower($_REQUEST['q']);
		$this->load->model('ManufactureModel', '', TRUE);
		$manufactures = $this->ManufactureModel->searchManufacturesForAutoSuggest($q);
		echo $manufactures;
	}
	
		
	function ajaxSearchManufactureInfo() {
		$manufactureId = $this->input->post('manufactureId');
		$addressId = $this->input->post('addressId');
		$this->load->model('ManufactureModel', '', TRUE);
		$manufacture = $this->ManufactureModel->getManufactureFromId($manufactureId, $addressId);
		echo json_encode($manufacture);
	}
	
	//manufacture custom url
	function customUrl($customUrl){
		$this->load->model('CustomUrlModel');
		$producer = $this->CustomUrlModel->getProducerIdFromCustomUrl($customUrl, 'manufacture');
		if ($producer) {
			$this->view($producer->producerId, $producer->addressId);
		} else {
			show_404('page');
		}
	}
	
	
	// View all the information about a single manufacture
	function view($manufactureId = '', $addressId = '') {
		global $SUPPLIER_TYPES_2;
					
		$this->load->plugin('Visits');
		$visits = new Visits();
		$visits->addProducer($manufactureId);
		
		$data = array();
		
		if($manufactureId == ''){
			$manufactureId = $this->uri->segment(3);
		}

		$this->load->model('PhotoModel');
		$thumbPhotos = $this->PhotoModel->getThumbPhotos('producer', $manufactureId);
		
		// Getting information from models
		$this->load->model('ManufactureModel');
		$manufacture = $this->ManufactureModel->getManufactureFromId($manufactureId);

		$this->load->model('ProductTypeModel');
		$productTypes = $this->ProductTypeModel->listProductType();

		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('manufacture_detail');

		$seo_data_array = array(
			'manufacture_name' => $manufacture->manufactureName,
			'manufacture_type' => 'Fast Food',
			'cuisines' => 'Fast Food, American, Pizza',
		);

		$seo = $this->SeoModel->parseSeoData($seo, $seo_data_array);
		$data['SEO'] = $seo;
		// SEO ENDS here

		// List of views to be included, these are files that are pulled from different views in the view folders

		// Load all the views for the center column
		$data['LEFT'] = array(
				'img' => '/includes/left/images',
				'info' => 'includes/left/info',
				'map' => 'includes/right/map',
			);

		// Load all the views for the center column
		$data['CENTER'] = array(
				'info' => '/manufacture/info',
			);

		// Load all the views for the right column
		$data['RIGHT'] = array(
				//'ad' => 'includes/banners/sky',
			); 

		// Data to be passed to the views
		// Center -> Info
		$data['data']['center']['info']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['info']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['info']['MANUFACTURE_ID'] = $manufacture->manufactureId;
		$data['data']['center']['info']['ADDRESS_ID'] = $addressId;
		$data['data']['center']['info']['TABLE'] = 'manufacture_supplier';
		
		// Left -> Map
		$data['data']['left']['map']['width'] = '220';
		$data['data']['left']['map']['height'] = '225';
		$data['data']['left']['map']['hide_map'] = 'no';
		
		// Left -> Images
		$data['data']['left']['img']['PHOTOS'] = $thumbPhotos;
		
		// Left -> Info
		$INFO = array (
					'url' => $manufacture->url,
					'facebook' => $manufacture->facebook,
					'twitter' => $manufacture->twitter,
				);
		
		$data['data']['left']['info']['INFO'] = $INFO;
		$data['data']['left']['info']['MANUFACTURE'] = $manufacture;
		
		$data['MANUFACTURE'] = $manufacture;
		
		$data['NAME'] = array(
							$manufacture->manufactureName => '',
							);
		
		// Custom CSS
		$data['CSS'] = array(
				'restaurant',
				'supplier',
				'floating_messages'
		);
		
		/** ------------------------------
		 *  AJAX stuff starts from here
		 *  ------------------------------ 
		 */
		$q = $manufactureId;
		$producerName = $manufacture->manufactureName;
		
		$this->load->model('ListModel', '', TRUE);
		
		$tab = $this->input->get('tab'); 
		if (!$tab || $tab == 'supplier') {
			$this->load->model('SupplierModel');
			$suppliers = $this->SupplierModel->getSupplierForProducerJson($q, $addressId);
			$params = $suppliers['param'];
		} else if ($tab == 'menu') {
			$this->load->model('RestaurantModel', '', TRUE);
			$menus = $this->ManufactureModel->getManufactureMenusJson($q);
			$params = $menus['param'];
		} else if ($tab == 'comment') {
			$this->load->model('CommentModel', '', TRUE);
			$comments = $this->CommentModel->getCommentsJson('restaurant', $q);
			$params = $comments['param'];
		} else if ($tab == 'photo') {
			$this->load->model('PhotoModel', '', TRUE);
			$photos = $this->PhotoModel->getPhotosJson('restaurant', $q);
			$params = $photos['param'];
		}
		
		/**
		 * Set tab on INFO pages only
		 */
		$this->ListModel->tab = 'supplier';
		$supplierTabLink = $this->ListModel->buildUrl($params);
		
		$this->ListModel->tab = 'menu';
		$menuTabLink = $this->ListModel->buildUrl($params);
		
		$this->ListModel->tab = 'comment';
		$commentTabLink = $this->ListModel->buildUrl($params);
		
		$this->ListModel->tab = 'photo';
		$photoTabLink = $this->ListModel->buildUrl($params);
		
		if (!$tab || $tab == 'supplier') {
			$this->ListModel->tab = 'supplier';
			$listHtml = $this->ListModel->buildSupplierList($suppliers, $producerName, 'manufacture');
		} else if ($tab == 'menu') {
			$this->ListModel->tab = 'menu';
			$listHtml = $this->ListModel->buildMenuList($menus, $producerName, 'manufacture');
		} else if ($tab == 'comment') {
			$this->ListModel->tab = 'comment';
			$listHtml = $this->ListModel->buildCommentList($comments, $producerName, 'manufacture');
		} else if ($tab == 'photo') {
			$this->ListModel->tab = 'photo';
			$listHtml = $this->ListModel->buildPhotoList($photos, $producerName, 'manufacture');
		}
		$data['data']['center']['info']['LIST_DATA'] = $listHtml;
		
		$pagingHtml = $this->ListModel->buildInfoPagingLinks($params);
		$data['data']['center']['info']['PAGING_HTML'] = $pagingHtml;
		
		if ($params['numResults'] > 0) {
			$pagingHtml2 = $this->ListModel->buildInfoPagingLinks($params, '2');
			$data['data']['center']['info']['PAGING_HTML_2'] = $pagingHtml2;
		}
		
		if (! $params['filter']) {
			$params['filter'] = '';
		}
		$jsonParams = json_encode($params);
		
		$data['data']['center']['info']['PARAMS'] = $jsonParams;
		
		if ( isset($suppliers) ) {
			$geocode = json_encode($suppliers['geocode']);
			$data['data']['center']['info']['GEOCODE'] = $geocode;
		}
		
		$data['data']['left']['filter']['PARAMS'] = $params;
		
		$data['data']['left']['img']['PHOTO_TAB_LINK'] = $photoTabLink;
		$data['data']['center']['info']['SUPPLIER_TAB_LINK'] = $supplierTabLink;
		$data['data']['center']['info']['MENU_TAB_LINK'] = $menuTabLink;
		$data['data']['center']['info']['COMMENT_TAB_LINK'] = $commentTabLink;
		$data['data']['center']['info']['PHOTO_TAB_LINK'] = $photoTabLink;
		$data['data']['center']['info']['CURRENT_TAB'] = $this->ListModel->tab;
		
		$this->load->view('templates/left_center_right_template', $data);
		
	}
	
	function ajaxSearchManufactureSuppliers() {
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		$addressId = $this->input->post('addressId');
		$this->load->model('SupplierModel');
		$suppliers = $this->SupplierModel->getSupplierForProducerJson($q, $addressId);

		$this->load->model('ManufactureModel');
		$manufacture = $this->ManufactureModel->getManufactureFromId($q);
		$producerName = $manufacture->manufactureName;
		
		$this->load->model('ListModel', '', TRUE);
		$supplierListHtml = $this->ListModel->buildSupplierList($suppliers, $producerName, 'manufacture');
		$this->ListModel->tab = 'supplier';
		
		$pagingHtml = $this->ListModel->buildInfoPagingLinks($suppliers['param']);
		
		$array = array(
			'listHtml' => $supplierListHtml,
			'pagingHtml' => $pagingHtml,
			'param' => $suppliers['param'],
			'geocode' => $suppliers['geocode'],
		);
		
		if ($suppliers['param']['numResults'] > 0) {
			$pagingHtml2 = $this->ListModel->buildInfoPagingLinks($suppliers['param'], '2');
			$array['pagingHtml2'] = $pagingHtml2;
		}
		
		echo json_encode($array);
	}
	
	function ajaxSearchManufactureMenus() {
		
		$this->load->model('ManufactureModel', '', TRUE);
		$menus = $this->ManufactureModel->getManufactureMenusJson();
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('ManufactureModel');
		$manufacture = $this->ManufactureModel->getManufactureFromId($q);
		$producerName = $manufacture->manufactureName;
		
		$this->load->model('ListModel', '', TRUE);
		$menuListHtml = $this->ListModel->buildMenuList($menus, $producerName, 'manufacture');
		$this->ListModel->tab = 'menu';
		
		$pagingHtml = $this->ListModel->buildInfoPagingLinks($menus['param']);
		
		$array = array(
			'listHtml' => $menuListHtml,
			'pagingHtml' => $pagingHtml,
			'param' => $menus['param'],
			//'geocode' => $menus['geocode'],
		);
		
		if ($menus['param']['numResults'] > 0) {
			$pagingHtml2 = $this->ListModel->buildInfoPagingLinks($menus['param'], '2');
			$array['pagingHtml2'] = $pagingHtml2;
		}
		
		echo json_encode($array);
	}
	
	function ajaxSearchManufactureComments() {
		$this->load->model('CommentModel', '', TRUE);
		$comments = $this->CommentModel->getCommentsJson('manufacture');
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('ManufactureModel');
		$manufacture = $this->ManufactureModel->getManufactureFromId($q);
		$producerName = $manufacture->manufactureName;
		
		$this->load->model('ListModel', '', TRUE);
		$menuListHtml = $this->ListModel->buildCommentList($comments, $producerName, 'manufacture');
		$this->ListModel->tab = 'comment';
		
		$pagingHtml = $this->ListModel->buildInfoPagingLinks($comments['param']);
		//$pagingHtml2 = $this->ListModel->buildInfoPagingLinks($comments['param'], '2');
		
		$array = array(
			'listHtml' => $menuListHtml,
			'pagingHtml' => $pagingHtml,
			//'pagingHtml2' => $pagingHtml2,
			'param' => $comments['param'],
			//'geocode' => $suppliers['geocode'],
		);
		
		echo json_encode($array);
	}
	
	function ajaxSearchManufacturePhotos() {
		$this->load->model('PhotoModel', '', TRUE);
		$photos = $this->PhotoModel->getPhotosJson('manufacture');
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('ManufactureModel');
		$manufacture = $this->ManufactureModel->getManufactureFromId($q);
		$producerName = $manufacture->manufactureName;
		
		$this->load->model('ListModel', '', TRUE);
		$photoListHtml = $this->ListModel->buildPhotoList($photos, $producerName, 'manufacture');
		$this->ListModel->tab = 'photo';
		
		$pagingHtml = $this->ListModel->buildInfoPagingLinks($photos['param']);
		//$pagingHtml2 = $this->ListModel->buildInfoPagingLinks($photos['param'], '2');
		
		$array = array(
			'listHtml' => $photoListHtml,
			'pagingHtml' => $pagingHtml,
			//'pagingHtml2' => $pagingHtml2,
			'param' => $photos['param'],
			//'geocode' => $suppliers['geocode'],
		);
		
		echo json_encode($array);
	}
}

/* End of file manufacture.php */

?>