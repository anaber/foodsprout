<?php
set_time_limit(0);

error_reporting(E_ALL ^ E_WARNING);
	
$defines_file = '../includes/properties.php';

if (file_exists($defines_file))
	require_once($defines_file);


$sitemap = new Sitemap("http://www.sproutchain.com");
$sitemap->create();



class Sitemap {

    var $items = array();
	var $db;
	var $site_url;
	var $filename;
	
	function __construct($url) {
		global $DB_HOST, $DB_USER, $DB_PASSWORD, $DATABSE;
		
		$this->db = mysql_connect($DB_HOST, $DB_USER, $DB_PASSWORD) or die ("Could not connect to database error : ". mysql_error());
		mysql_select_db($DATABSE, $this->db) or die ("Could not select to database error : ". mysql_error());
		$this->site_url = $url;

	}

    function add_item($new_item){
        $this->items[] = $new_item;
    }

	function get_header() {
		$header = "<\x3Fxml version=\"1.0\" encoding=\"UTF-8\"\x3F>\n" .
			"<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n\t" .
			"xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n\t" .
			"xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\n\t\t\t    " .
			"http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n\n";
		return $header;
	}
	
	function get_footer() {
		$footer = "</urlset>\n";
		return $footer;
	}
	
	function create() {
	
		$query = mysql_query('SELECT count(*) AS num_row FROM custom_url');
		$rs = mysql_fetch_assoc($query);
		$url_count = $rs['num_row'];
		
		$limit_per_file = 5000;
		$files = ceil($url_count / $limit_per_file);
		$i = 1;
		$j = 1;
		$file_count = 0;
		
		while($i <= $files){
			
			if($i == 1)
				$start = 0;
			else
				$start = (($i-1)*($limit_per_file))+1;
			
			$query = mysql_query('SELECT * FROM custom_url LIMIT '.$start.','.$limit_per_file);

			while($url = mysql_fetch_assoc($query)) {

				$query2 = mysql_query('SELECT creation_date,is_farm,is_restaurant,is_restaurant_chain,is_manufacture,is_distributor,is_farmers_market FROM producer WHERE producer_id='.$url['producer_id']);
				$producer = mysql_fetch_assoc($query2);

            	$prod_type = "restaurant";

				if($producer['is_farm'] == 1) {
	            	$prod_type = "farm";
				} elseif($producer['is_restaurant'] == 1) {
	            	$prod_type = "restaurant";
				} elseif($producer['is_restaurant_chain'] == 1) {
	            	$prod_type = "chain";
				} elseif($producer['is_manufacture'] == 1) {
	            	$prod_type = "manufacture";
				} elseif($producer['is_distributor'] == 1) {
	            	$prod_type = "distributor";
				} elseif($producer['is_farmers_market'] == 1) {
	            	$prod_type = "farmersmarket";
				}
				
            	$item = array(
	                "loc" => $this->site_url."/".$prod_type."/" . $url['custom_url'],
	                "lastmod" => date("c", strtotime($producer['creation_date'])), // ISO 8601 format - date("c") requires PHP5
	                "changefreq" => "monthly",
    	            "priority" => "0.4"
            	);
				
            	$this->add_item($item);

				unset($item);
				unset($producer);
				mysql_free_result($query2);
			}
			
			unset($urls);

			if($j == 10 || $i == $files) {
				$file_count++;
				// file name may change due to compression
				$file_name = $this->build("../content/sitemaps/producer_$file_count.xml");
				unset($file_name);
				$j=0;
				echo "Created $file_name.<br/>";
			}
			$j++;
			$i++;
		}
		echo "SUCCESS!";

	}

	function build($file_name, $gzip = TRUE) {
		
		$map = $this->get_header();

        foreach($this->items as $item)
        {
            $item['loc'] = htmlentities($item['loc'], ENT_QUOTES);
            $map .= "\t<url>\n\t\t<loc>" . $item['loc'] . "</loc>\n";

            $attributes = array("lastmod", "changefreq", "priority");

            foreach($attributes AS $attr)
            {
                if(isset($item[$attr]))
                {
                    $map .= "\t\t<$attr>" . $item[$attr] . "</$attr>\n";
                }
            }

            $map .= "\t</url>\n\n";
        }
		$map .= $this->items;
        unset($this->items);

        $map .= $this->get_footer();

        if( ! is_null($file_name))
        {
            $fh = fopen($file_name, 'w');
            fwrite($fh, $map);
            fclose($fh);

            if( filesize($file_name) > 1024 * 1024 * 10 ) {
                echo 'Your sitemap is bigger than 10MB, most search engines will not accept it.';
            }

            if($gzip OR (is_null($gzip)) )
            {
                $gzdata = gzencode($map, 9);
                $file_gzip = str_replace("{file_name}", $file_name, "{file_name}.gz");
                $fp = fopen($file_gzip, "w");
                fwrite($fp, $gzdata);
                fclose($fp);

                // Delete the uncompressed sitemap
                unlink($file_name);

                return $file_gzip;
            }

            return $file_name;
        }
        else
        {
            return $map;
        }
	}

}
?>