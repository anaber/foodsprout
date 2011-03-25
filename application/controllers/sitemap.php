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
		
		$limit_per_file = 30000;
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
				unset($item);
        	}

			// file name may change due to compression
	        $file_name = $this->sitemaps->build("restaurants_$i.xml");
			unset($file_name);
			$i++;
		}

		redirect('home');
    }

	function farms()
    {
        $this->load->model('FarmModel');
        $this->load->library('sitemaps');

		// Get the number of farms and the times to loop
		$farm_count = $this->FarmModel->getFarmCount();
		
		$limit_per_file = 30000;
		$files = ceil($farm_count / $limit_per_file);
        
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
        	$farm = $this->FarmModel->getFarmSitemap($start,$limit);
        
        	foreach($farm AS $r)
        	{
            	$item = array(
                "loc" => site_url("farm/" . $r->customURL),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("c", strtotime($r->creationDate)),
                "changefreq" => "monthly",
                "priority" => "0.4"
            	);
            
            	$this->sitemaps->add_item($item);
				unset($item);
        	}

			// file name may change due to compression
	        $file_name = $this->sitemaps->build("farms_$i.xml");
			unset($file_name);
			$i++;
		}

		redirect('home');
    }

	function farmersMarket()
    {
        $this->load->model('FarmersMarketModel');
        $this->load->library('sitemaps');

		// Get the number of farmers_market and the times to loop
		$farmers_market_count = $this->FarmersMarketModel->getFarmersMarketCount();
		
		$limit_per_file = 30000;
		$files = ceil($farmers_market_count / $limit_per_file);
        
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
        	$farmers_market = $this->FarmersMarketModel->getFarmersMarketSitemap($start,$limit);
        
        	foreach($farmers_market AS $r)
        	{
            	$item = array(
                "loc" => site_url("farmersmarket/" . $r->customURL),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("c", strtotime($r->creationDate)),
                "changefreq" => "monthly",
                "priority" => "0.4"
            	);
            
            	$this->sitemaps->add_item($item);
				unset($item);
        	}

			// file name may change due to compression
	        $file_name = $this->sitemaps->build("farmersmarket_$i.xml");
			unset($file_name);
			$i++;
		}

		redirect('home');
    }

	function manufactures()
    {
		$this->load->model('ManufactureModel');
        $this->load->library('sitemaps');

		// Get the number of manufactures and the times to loop
		$manufacture_count = $this->ManufactureModel->getManufactureCount();
		
		$limit_per_file = 30000;
		$files = ceil($manufacture_count / $limit_per_file);
        
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
        	$manufacture = $this->ManufactureModel->getManufactureSitemap($start,$limit);
        
        	foreach($manufacture AS $r)
        	{
            	$item = array(
                "loc" => site_url("manufacture/" . $r->customURL),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("c", strtotime($r->creationDate)),
                "changefreq" => "monthly",
                "priority" => "0.4"
            	);
            
            	$this->sitemaps->add_item($item);
				unset($item);
        	}

			// file name may change due to compression
	        $file_name = $this->sitemaps->build("manufacture_$i.xml");
			unset($file_name);
			$i++;
		}

		redirect('home');
    }
	
	function distributors()
	{
		$this->load->model('DistributorModel');
        $this->load->library('sitemaps');

		// Get the number of distributors and the times to loop
		$distributor_count = $this->DistributorModel->getDistributorCount();
		
		$limit_per_file = 30000;
		$files = ceil($distributor_count / $limit_per_file);
        
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
        	$distributor = $this->DistributorModel->getDistributorSitemap($start,$limit);
        
        	foreach($distributor AS $r)
        	{
            	$item = array(
                "loc" => site_url("distributor/" . $r->customURL),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("c", strtotime($r->creationDate)),
                "changefreq" => "monthly",
                "priority" => "0.4"
            	);
            
            	$this->sitemaps->add_item($item);
				unset($item);
        	}

			// file name may change due to compression
	        $file_name = $this->sitemaps->build("distributor_$i.xml");
			unset($file_name);
			$i++;
		}

		redirect('home');
	}
	
	function restaurantChains()
	{
		$this->load->model('RestaurantChainModel');
        $this->load->library('sitemaps');

		// Get the number of restaurant chains and the times to loop
		$restaurant_chain_count = $this->RestaurantChainModel->getRestaurantChainCount();
		
		$limit_per_file = 30000;
		$files = ceil($restaurant_chain_count / $limit_per_file);
        
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
        	$restaurant_chain = $this->RestaurantChainModel->getRestaurantChainSitemap($start,$limit);
        
        	foreach($restaurant_chain AS $r)
        	{
            	$item = array(
                "loc" => site_url("chain/" . $r->customURL),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("c", strtotime($r->creationDate)),
                "changefreq" => "monthly",
                "priority" => "0.4"
            	);
            
            	$this->sitemaps->add_item($item);
				unset($item);
        	}

			// file name may change due to compression
	        $file_name = $this->sitemaps->build("restaurantchain_$i.xml");
			unset($file_name);
			$i++;
		}

		redirect('home');
	}
}

?>