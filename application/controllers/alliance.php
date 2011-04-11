<?php

class Alliance extends Controller{
	
	function customUrl($customUrl){
		
		$this->load->model('CustomUrlModel');
		$alliance = $this->CustomUrlModel->getAllianceIdFromCustomUrl($customUrl, 'alliance');
		
		if ($alliance) {
			$this->listAlliance($alliance->allianceId);
		} else {
			show_404('page');
		}
	}
	
	function listAlliance($allianceId) {
			
			$data = array();
            
            // SEO
            $this->load->model('SeoModel');
            $seo = $this->SeoModel->getSeoDetailsFromPage('alliance_list');
            $data['SEO'] = $seo;

            $q = $this->input->post('q');
            $f = $this->input->post('f');

            if ( !empty($f) ) {
                    $data['CENTER'] = array(
                    	'list' => '/alliance/alliance_list',
                    );
            } else {
                    // List of views to be included
                    $data['CENTER'] = array(
                    	'map' => 'includes/map',
                    	'list' => '/restaurant/restaurant_list',
                    );
            }

            if ( !empty($f) ) {
                    // do nothing
            } else {
                    $data['LEFT'] = array(
                    	'filter' => 'includes/left/restaurant_filter',
                    );
            }

            // Data to be passed to the views
            if ( empty($f) ) {
                    // load nothing
            }

            if ( empty($f) ) {
                    $data['data']['center']['map']['width'] = '795';
                    $data['data']['center']['map']['height'] = '250';
            }

            $data['data']['center']['list']['q'] = $q;
            $data['data']['center']['list']['f'] = $f;
            if ( !empty($f) ) {
                    $data['data']['center']['list']['hide_map'] = 'yes';
                    $data['data']['center']['list']['hide_filters'] = 'yes';
            } else {
                    $data['data']['center']['list']['hide_map'] = 'no';
                    $data['data']['center']['list']['hide_filters'] = 'no';
            }

            $this->load->model('AllianceModel', '', TRUE);
            $alliance = $this->AllianceModel->getAlliancesJson();

            $this->load->model('ListModel', '', TRUE);
            $allianceListHtml = $this->ListModel->buildAllianceList($alliance);
            $data['data']['center']['list']['LIST_DATA'] = $allianceListHtml;

            $pagingHtml = $this->ListModel->buildPagingLinks($alliance['param']);
            $data['data']['center']['list']['PAGING_HTML'] = $pagingHtml;

            if (! $alliance['param']['filter']) {
                    $alliance['param']['filter'] = '';
            }
            $params = json_encode($alliance['param']);

            $data['data']['center']['list']['PARAMS'] = $params;

            $geocode = json_encode($alliance['geocode']);
            $data['data']['center']['list']['GEOCODE'] = $geocode;

            $data['data']['left']['filter']['PARAMS'] = $alliance['param'];

            $this->load->view('templates/left_center_template', $data);
	}
	
	
	
}

?>