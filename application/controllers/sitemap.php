<?php

class Sitemap extends Controller
{
    function Sitemap()
    {
        parent::Controller();
    }
    
    function index()
    {
        $this->load->model('RestaurantModel');
        $this->load->library('sitemaps');
        
        $restaurant = $this->RestaurantModel->get_restaurants_sitemap();
        
        foreach($restaurant AS $r)
        {
            $item = array(
                "loc" => site_url("restaurant/v-" . $r->custom_url),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("c", strtotime($r->last_modified)),
                "changefreq" => "monthly",
                "priority" => "0.6"
            );
            
            $this->sitemaps->add_item($item);
        }
        
        // file name may change due to compression
        $file_name = $this->sitemaps->build("sitemap_restaurants.xml");

        //$reponses = $this->sitemaps->ping(site_url($file_name));
        
        // Debug by printing out the requests and status code responses
        // print_r($reponses);

        redirect(site_url($file_name));
    }
}

?>