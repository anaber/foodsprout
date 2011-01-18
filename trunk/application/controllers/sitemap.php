<?php

class Sitemap extends Controller
{
    function Sitemap()
    {
        parent::Controller();
    }
    
    function restaurants()
    {
        $this->load->model('RestaurantModel');
        $this->load->library('sitemaps');

		// Get the number of restaurants and the times to loop
		$restaurant_count = $this->RestaurantModel->getRestaurantCount();
		
		$limit_per_file = 20000;
		$files = ceil($restaurant_count / $limit_per_file);
        
		$i = 1;
		while($i <= $files)
		{
			if($i == 1)
			{
				$start = 0;
			}
			else
			{
				$start = (($i-1)*($limit_per_file))+1;
			}
			$limit = $limit_per_file;
        	$restaurant = $this->RestaurantModel->getRestaurantsSitemap($start,$limit);
        
        	foreach($restaurant AS $r)
        	{
            	$item = array(
                "loc" => site_url("restaurant/" . $r->customURL),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("c", strtotime($r->creationDate)),
                "changefreq" => "monthly",
                "priority" => "0.4"
            	);
            
            	$this->sitemaps->add_item($item);
        	}

			// file name may change due to compression
	        $file_name = $this->sitemaps->build("sitemap_restaurants_$i.xml");
	
			$i++;
		}

		exit;
    }

	function farms()
    {
        $this->load->model('FarmModel');
        $this->load->library('sitemaps');
        
		$start = 0;
		$end = 10000;
        $restaurant = $this->RestaurantModel->getRestaurantsSitemap($start,$end);
        
        foreach($restaurant AS $r)
        {
            $item = array(
                "loc" => site_url("restaurant/" . $r->customURL),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("c", strtotime($r->creationDate)),
                "changefreq" => "monthly",
                "priority" => "0.4"
            );
            
            $this->sitemaps->add_item($item);
        }
        
        // file name may change due to compression
        $file_name = $this->sitemaps->build("sitemap_restaurants.xml");
		
		exit;
    }

	function farmersMarket()
    {
        $this->load->model('FarmersMarketModel');
        $this->load->library('sitemaps');
        
		$start = 0;
		$end = 10000;
        $restaurant = $this->RestaurantModel->getRestaurantsSitemap($start,$end);
        
        foreach($restaurant AS $r)
        {
            $item = array(
                "loc" => site_url("restaurant/" . $r->customURL),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("c", strtotime($r->creationDate)),
                "changefreq" => "monthly",
                "priority" => "0.4"
            );
            
            $this->sitemaps->add_item($item);
        }
        
        // file name may change due to compression
        $file_name = $this->sitemaps->build("sitemap_restaurants.xml");
		
		exit;
    }

	function manufactures()
    {
        $this->load->model('FarmersMarketModel');
        $this->load->library('sitemaps');
        
		$start = 0;
		$end = 10000;
        $restaurant = $this->RestaurantModel->getRestaurantsSitemap($start,$end);
        
        foreach($restaurant AS $r)
        {
            $item = array(
                "loc" => site_url("restaurant/" . $r->customURL),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("c", strtotime($r->creationDate)),
                "changefreq" => "monthly",
                "priority" => "0.4"
            );
            
            $this->sitemaps->add_item($item);
        }
        
        // file name may change due to compression
        $file_name = $this->sitemaps->build("sitemap_restaurants.xml");
		
		exit;
    }
}

?>