<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class SeoLib {
	
	var $seoPageId;
	var $page;
	var $titleTag;
	var $metaDescription;
	var $metaKeywords;
	var $h1;
	var $url;
		
	function SeoLib() {
		$this->seoPageId = "";
		$this->page = "";
		$this->titleTag = "";
		$this->metaDescription = "";
		$this->metaKeywords = "";
		$this->h1 = "";
		$this->url = "";
	}
}
?>
