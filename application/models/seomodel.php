<?php

class SeoModel extends Model{
	
	function getSeoDetailsFromPage($page) {
		
		$query = 'SELECT * FROM seo_page WHERE page = \''. $page . '\'';
		log_message('debug', "SeoPageModel.getSeoPageFromPage : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('SeoLib');
		
		$row = $result->row();
		
		$this->seoLib->seoPageId = $row->seo_page_id;
		$this->seoLib->page = $row->page;
		$this->seoLib->titleTag = $row->title_tag;
		$this->seoLib->metaDescription = $row->meta_description;
		$this->seoLib->metaKeywords = $row->meta_keywords;
		$this->seoLib->h1 = $row->h1;
		$this->seoLib->url = $row->url;
				
		return $this->seoLib;
	}
	
	function parseSeoData($seo, $seo_data_array) {
		
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
		
		return $seo;
	}
}
?>