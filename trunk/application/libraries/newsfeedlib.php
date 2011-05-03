<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class NewsfeedLib {
	
	var $newsFeedId;
	var $newsFeedTitle;
	var $newsFeedText;
	var $newsFeedDate;
	var $newsFeedProducer;
	var $newsFeedProduct;
	var $newsFeedAuthor;
		
	function NewsfeedLib() 
	{
		$this->newsFeedId = '';
		$this->newsFeedTitle = '';
		$this->newsFeedText = '';
		$this->newsFeedDate = '';
		$this->newsFeedProducer = '';
		$this->newsFeedProduct = '';
		$this->newsFeedAuthor = '';
	}
}
?>