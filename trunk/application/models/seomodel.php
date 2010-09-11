<?php

class SeoModel extends Model{
	
	function getSeoDetailsFromPage($page) {
		
		$query = 'SELECT * FROM seo_page WHERE page = \''. $page . '\'';
		log_message('debug', "SeoPageModel.getSeoPageFromPage : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('SeoLib');
		
		$row = $result->row();
		
		if ($row) {
			$this->seoLib->seoPageId = $row->seo_page_id;
			$this->seoLib->page = $row->page;
			$this->seoLib->titleTag = $row->title_tag;
			$this->seoLib->metaDescription = $row->meta_description;
			$this->seoLib->metaKeywords = $row->meta_keywords;
			$this->seoLib->h1 = $row->h1;
			$this->seoLib->url = $row->url;
			
			return $this->seoLib;
		} else {
			return;
		}
	}
	
	function parseSeoData($seo, $seo_data_array) {
		
		if (count($seo) > 0 ) {
		
			foreach ($seo as $key => $value) {
				
				$string = $seo->$key;
				
				foreach ($seo_data_array as $data_key => $data_value) {
					$pattern = '/\$' . $data_key . '/';
					$replacement = $data_value;
					
					preg_match_all($pattern, $string, $out, PREG_OFFSET_CAPTURE);
					if ( count($out[0]) > 0 ) {
						preg_replace($pattern, $replacement, $string);
						$string = preg_replace($pattern, $replacement, $string);
					}
				}
				
				$seo->$key = $string;
			}
		}
		
		return $seo;
	}
	
	function getSeoJsonAdmin() {
		global $PER_PAGE, $FARMER_TYPES;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q');
		
		if ($q == '0') {
			$q = '';
		}
		
		$start = 0;
		$page = 0;
		
		
		$base_query = 'SELECT seo_page.*' .
				' FROM seo_page';
		
		$base_query_count = 'SELECT count(*) AS num_records' .
				' FROM seo_page';
		
		$where = '';
		
		if (!empty ($q) ) {
		$where .= ' WHERE ' 
				. ' (' 
				. '	seo_page.page like "%' .$q . '%"'
				. ' OR seo_page.title_tag like "%' . $q . '%"'
				. ' OR seo_page.meta_description like "%' . $q . '%"'
				. ' OR seo_page.meta_keywords like "%' . $q . '%"'
				. ' OR seo_page.h1 like "%' . $q . '%"'
				. ' OR seo_page.url like "%' . $q . '%"'
				. ' )';
		}
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY page';
			$sort = 'page';
		} else {
			$sort_query = ' ORDER BY ' . $sort;
		}
		
		if ( empty($order) ) {
			$order = 'ASC';
		}
		
		$query = $query . ' ' . $sort_query . ' ' . $order;
		
		if (!empty($pp) && $pp != 'all' ) {
			$PER_PAGE = $pp;
		}
		
		if (!empty($pp) && $pp == 'all') {
			// NO NEED TO LIMIT THE CONTENT
		} else {
			
			if (!empty($p) || $p != 0) {
				$page = $p;
				$p = $p * $PER_PAGE;
				$query .= " LIMIT $p, " . $PER_PAGE;
				$start = $p;
				
			} else {
				$query .= " LIMIT 0, " . $PER_PAGE;
			}
		}
		
		log_message('debug', "SeoModel.getSeoJsonAdmin : " . $query);
		$result = $this->db->query($query);
		
		$seo = array();
		
		$CI =& get_instance();
		
		$geocodeArray = array();
		foreach ($result->result() as $row) {
			
			$this->load->library('SeoLib');
			unset($this->seoLib);
			
			$this->seoLib->seoPageId = $row->seo_page_id;
			$this->seoLib->page = $row->page;
			$this->seoLib->titleTag = $row->title_tag;
			$this->seoLib->metaDescription = $row->meta_description;
			$this->seoLib->metaKeywords = $row->meta_keywords;
			$this->seoLib->h1 = $row->h1;
			$this->seoLib->url = $row->url;
			
			$seo[] = $this->seoLib;
			unset($this->seoLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		$last = $totalPages - 1;
		
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $seo,
			'param'      => $params,
			'geocode'	 => $geocodeArray,
	    );
	    
	    return $arr;
	}
	
	function getSeoPageFromId($seoPageId) {
		
		$query = "SELECT seo_page.* " .
				" FROM seo_page " .
				" WHERE seo_page.seo_page_id = " . $seoPageId;
		log_message('debug', "SeoModel.getSeoPageFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('SeoLib');
		
		$row = $result->row();
		
		if ($row) {
			$geocodeArray = array();
		
			$this->seoLib->seoPageId = $row->seo_page_id;
			$this->seoLib->page = $row->page;
			$this->seoLib->titleTag = $row->title_tag;
			$this->seoLib->metaDescription = $row->meta_description;
			$this->seoLib->metaKeywords = $row->meta_keywords;
			$this->seoLib->h1 = $row->h1;
			$this->seoLib->url = $row->url;
			
			return $this->seoLib;
		} else {
			return;
		}
	}
	
	function updateSeoPage() {
		$return = true;
		
		$query = "SELECT * FROM seo_page WHERE page = \"" . $this->input->post('page') . "\" AND seo_page_id <> " . $this->input->post('seoPageId');
		log_message('debug', 'SeoModel.updateSeoPage : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'page' => $this->input->post('page'), 
						'title_tag' => $this->input->post('titleTag'),
						'meta_description' => $this->input->post('metaDescription'),
						'meta_keywords' => $this->input->post('metaKeywords'),
						'h1' => $this->input->post('h1'),
						'url' => $this->input->post('url'),
					);
			$where = "seo_page_id = " . $this->input->post('seoPageId');
			$query = $this->db->update_string('seo_page', $data, $where);
			
			log_message('debug', 'SeoModel.updateSeoPage : ' . $query);
			if ( $this->db->query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
			
		} else {
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}
		
		return $return;
	}
	
	function addSeoPage() {
		$return = true;
		
		$query = "SELECT * FROM seo_page WHERE page = \"" . $this->input->post('page') . "\"";
		log_message('debug', 'SeoModel.addSeoPage : Try to get duplicate Seo record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			$query = 'INSERT INTO seo_page (seo_page_id, page, title_tag, meta_description, meta_keywords, h1, url)' .
					' values (NULL, "' . $this->input->post('page') . '", "' . $this->input->post('titleTag') . '", "' . $this->input->post('metaDescription') . '", "' . $this->input->post('metaKeywords') . '", "' . $this->input->post('h1') . '", "' . $this->input->post('url') . '")';
			
			log_message('debug', 'SeoModel.addSeoPage : Insert Seo Page : ' . $query);
			$return = true;
			
			if ( $this->db->query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
			
		} else {
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}
		return $return;
	}
}
?>