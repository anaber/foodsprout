<?php

class Distributor extends Controller {
	
	function __construct() {
		parent::Controller();
		checkUserLogin();
		checkUserAgent();
	}
	
	function index() {
		$data = array();
		
		// Views to include in the data array
		$data['CENTER'] = array(
				'list' => '/distributor/distributor_list',
			);
		
		$data['RIGHT'] = array(
				'ad' => 'includes/banners/sky',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "List of Distributor";
		
		$this->load->view('templates/center_right_narrow_template', $data);
	}
	
	function ajaxSearchDistributors() {
		$this->load->model('DistributorModel', '', TRUE);
		$distributors = $this->DistributorModel->getDistributorsJson();
		echo json_encode($distributors);
	}
	
	function ajaxSearchDistributorInfo() {
		$distributorId = $this->input->post('distributorId');
		$addressId = $this->input->post('addressId');
		$this->load->model('DistributorModel', '', TRUE);
		$distributor = $this->DistributorModel->getDistributorFromId($distributorId, $addressId);
		echo json_encode($distributor);
	}
	
	//distributor custom url
	function customUrl($customUrl){
		
		$this->load->model('CustomUrlModel');
		$producer = $this->CustomUrlModel->getProducerIdFromCustomUrl($customUrl, 'distributor');
		
		if ($producer) {
			$this->view($producer->producerId, $producer->addressId);
		} else {
			show_404('page');
		}
	}
	
	// View the information on a single distributorId
	function view($distributorId = "", $addressId = "") {
		global $SUPPLIER_TYPES_2;
		
		$this->load->plugin('Visits');
		$visits = new Visits();
		$visits->addProducer($distributorId);
		$data = array();

		if($distributorId == ""){
			$distributorId = $this->uri->segment(3);
		}
		
		$this->load->model('PhotoModel');
		$thumbPhotos = $this->PhotoModel->getThumbPhotos('producer', $distributorId);

		// Getting information from models
		$this->load->model('DistributorModel');
		$distributor = $this->DistributorModel->getDistributorFromId($distributorId, $addressId);
		
		$this->load->model('ProductTypeModel');
		$productTypes = $this->ProductTypeModel->listProductType();

		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('distributor_detail');

		$seo_data_array = array(
			'distributor_name' => $distributor->distributorName,
		// need to add more info about the distributor here
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
				'info' => '/distributor/info',
		);

		// Load all the views for the right column
		$data['RIGHT'] = array(
				//'ad' => '/includes/banners/sky',
		);

		// Data to be passed to the views
		// Center -> Info
		$data['data']['center']['info']['SUPPLIER_TYPES_2'] = $SUPPLIER_TYPES_2;
		$data['data']['center']['info']['PRODUCT_TYPES'] = $productTypes;
		$data['data']['center']['info']['DISTRIBUTOR_ID'] = $distributor->distributorId;
		$data['data']['center']['info']['DISTRIBUTOR_ID'] = $distributor->distributorId;
		$data['data']['center']['info']['ADDRESS_ID'] = $addressId;
		$data['data']['center']['info']['TABLE'] = 'distributor_supplier';
		
		// Left -> Map
		$data['data']['left']['map']['width'] = '220';
		$data['data']['left']['map']['height'] = '225';
		$data['data']['left']['map']['hide_map'] = 'no';

		// Left -> Images
		$data['data']['left']['img']['PHOTOS'] = $thumbPhotos;

		// Left -> Info
		$INFO = array (
					'url' => $distributor->url,
					'facebook' => $distributor->facebook,
					'twitter' => $distributor->twitter,
		);
		$data['data']['left']['info']['INFO'] = $INFO;

		$data['data']['left']['info']['INFO'] = $INFO;
		$data['data']['left']['info']['DISTRIBUTOR'] = $distributor;

		$data['DISTRIBUTOR'] = $distributor;

		$data['NAME'] = array(
		$distributor->distributorName => '',
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
		$q = $distributorId;
		$producerName = $distributor->distributorName;
		
		$this->load->model('ListModel', '', TRUE);
		
		$tab = $this->input->get('tab'); 
		if (!$tab || $tab == 'supplier') {
			$this->load->model('SupplierModel');
			$suppliers = $this->SupplierModel->getSupplierForProducerJson($q, $addressId);
			$params = $suppliers['param'];
		} else if ($tab == 'menu') {
			$this->load->model('DistributorModel', '', TRUE);
			$menus = $this->DistributorModel->getDistributorMenusJson($q);
			$params = $menus['param'];
		} else if ($tab == 'comment') {
			$this->load->model('CommentModel', '', TRUE);
			$comments = $this->CommentModel->getCommentsJson('distributor', $q);
			$params = $comments['param'];
		} else if ($tab == 'photo') {
			$this->load->model('PhotoModel', '', TRUE);
			$photos = $this->PhotoModel->getPhotosJson('distributor', $q);
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
			$listHtml = $this->ListModel->buildSupplierList($suppliers, $producerName, 'distributor');
		} else if ($tab == 'menu') {
			$this->ListModel->tab = 'menu';
			$listHtml = $this->ListModel->buildMenuList($menus, $producerName, 'distributor');
		} else if ($tab == 'comment') {
			$this->ListModel->tab = 'comment';
			$listHtml = $this->ListModel->buildCommentList($comments, $producerName, 'distributor');
		} else if ($tab == 'photo') {
			$this->ListModel->tab = 'photo';
			$listHtml = $this->ListModel->buildPhotoList($photos, $producerName, 'distributor');
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
		
		$this->load->view('templates/left_center_detail_template', $data);
	}
	
	function ajaxSearchDistributorMenus() {
		$this->load->model('DistributorModel', '', TRUE);
		$menus = $this->DistributorModel->getDistributorMenusJson();
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('DistributorModel');
		$distributor = $this->DistributorModel->getDistributorFromId($q);
		$producerName = $distributor->distributorName;
		
		$this->load->model('ListModel', '', TRUE);
		$menuListHtml = $this->ListModel->buildMenuList($menus, $producerName, 'distributor');
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
	
	function ajaxSearchDistributorSuppliers() {
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		$addressId = $this->input->post('addressId');
		$this->load->model('SupplierModel');
		$suppliers = $this->SupplierModel->getSupplierForProducerJson($q, $addressId);

		$this->load->model('DistributorModel');
		$distributor = $this->DistributorModel->getDistributorFromId($q, $addressId);
		$producerName = $distributor->distributorName;
		
		$this->load->model('ListModel', '', TRUE);
		$supplierListHtml = $this->ListModel->buildSupplierList($suppliers, $producerName, 'distributor');
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
	
	function ajaxSearchDistributorComments() {
		$this->load->model('CommentModel', '', TRUE);
		$comments = $this->CommentModel->getCommentsJson('distributor');
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('DistributorModel');
		$distributor = $this->DistributorModel->getDistributorFromId($q);
		$producerName = $distributor->distributorName;
		
		$this->load->model('ListModel', '', TRUE);
		$menuListHtml = $this->ListModel->buildCommentList($comments, $producerName, 'distributor');
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
	
	function ajaxSearchDistributorPhotos() {
		$this->load->model('PhotoModel', '', TRUE);
		$photos = $this->PhotoModel->getPhotosJson('distributor');
		
		$q = $this->input->post('q'); 
		if (!$q) {
			$q = $this->input->get('q');
		}
		
		$this->load->model('DistributorModel');
		$distributor = $this->DistributorModel->getDistributorFromId($q);
		$producerName = $distributor->distributorName;
		
		$this->load->model('ListModel', '', TRUE);
		$photoListHtml = $this->ListModel->buildPhotoList($photos, $producerName, 'distributor');
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

/* End of file distributor.php */

?>