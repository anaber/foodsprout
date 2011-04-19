<?php
class Import extends Controller {

    function __construct()
    {
        global $ADMIN_LANDING_PAGE;
        parent::Controller();
        if ($this->session->userdata('isAuthenticated') != 1 ||
                $this->session->userdata('userGroup') != 'admin' )
        {
            redirect($ADMIN_LANDING_PAGE);
        }
        
        $this->load->model('AddressModel');
        $this->load->model('GoogleMapModel');
        $this->load->model('ProducerModel');
        $this->load->model('CityModel');
        $this->load->model('StateModel');
    }
    
    function index()
    {
        show_404();
    }
    
    function producer()
    {
        $data = $errors = array();
        $this->load->helper(array('url', 'form'));
        global $UPLOAD_FOLDER;
        
        $config = array(
            'upload_path' => $UPLOAD_FOLDER.'/import',
            'allowed_types' => 'xl|xlsx|csv',
            'max_size' => '1000'
        );
        # $this->output->enable_profiler(TRUE);
        
        if ($_POST)
        {
            $input = array_merge($_POST, $_FILES);
            $this->load->plugin('phpexcel');

            $tmpext = explode('.', $input['file']['name']);
            $ext = '.'.end($tmpext);
            $config['file_name'] = 'import_producer_'.date('YmdHis').$ext;
            
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('file'))
            {
                $errors[] = $this->upload->display_errors();
            }
            else
            {
                $this->processFileAndImport($this->upload->data());
                redirect('admincp/import/producer');
            }
        }

        $data['errors'] = $errors;

        $data['LEFT'] = array(
            'menu' => 'admincp/menus/import',
        );

        $data['CENTER'] = array(
            'list' => 'admincp/forms/import'
        );

        $data['VIEW_HEADER'] = 'Import Producer';

        $this->load->view('admincp/templates/left_center_template', $data);
    }

    /**
     * 
     * @param <type> $producer_name a string name to make a slug out of
     * @return <type> the constructed slug
     */
    private function buildSlug($string)
    {
        $unwanted = array(':','<', '>', "'", '"',"\\", '/', '&');
        
        $string = str_replace($unwanted, '', $string);

        $string = (strlen($string) > 75) ?
                substr($string, 0, 75) : $string;

        $tmp_slug = explode(' ', trim(strtolower($string)));

        for ($i=0; $i<count($tmp_slug);$i++)
        {
            if ($tmp_slug[$i] == '')
            {
                unset($tmp_slug[$i]);
            }
        }

        return implode('-', $tmp_slug);
    }

    /**
     * determine if manufacturer, distributor, market, etc.
     *
     * @param string $type
     * @return database flag
     */
    private function determineType($type)
    {
        $type_data = array();
        
        switch($type)
        {
            case strcasecmp($type, 'manufacturer') == 0:
                $type_data['is_manufacture'] = 1;
                break;

            case strcasecmp($type, 'restaurant chain') == 0:
                $type_data['is_restaurant_chain'] = 1;
                break;

            case strcasecmp($type, 'farm') == 0:
                $type_data['is_farm'] = 1;
                break;

            case strcasecmp($type, 'farmers market') == 0:
                $type_data['is_farmers_market'] = 1;
                break;

            case strcasecmp($type, 'restaurant') == 0:
                $type_data['is_restaurant'] = 1;
                break;

            case strcasecmp($type, 'distributor') == 0:
                $type_data['is_distributor'] = 1;
                break;

            default:
                return $type_data;
        }

        return $type_data;
    }

    /**
     * process the file and do table updates, geocoding, etc.
     *
     * @param array $data  the upload data from CI upload lib
     */
    private function processFileAndImport(array $data)
    {
        $this->load->model('ProducerCategoryModel');
        
        $file_type = PHPExcel_IOFactory::identify($data['full_path']);
        $reader = PHPExcel_IOFactory::createReader($file_type);
        $reader->setReadDataOnly(true);
        $px = $reader->load($data['full_path']);
        $worksheet = $px->getActiveSheet();
        $headers = array();
        
        foreach($worksheet->getRowIterator() as $row)
        {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            $values = array();

            // get headers
            if ($row->getRowIndex() == 1)
            {
                foreach($cellIterator as $cell)
                {
                    if ( ! is_null($cell))$this->load->model('AddressModel');
                    {
                        $colIndex = PHPExcel_Cell::columnIndexFromString($cell->getColumn());
                        $headers[$colIndex] = $cell->getValue();
                    }
                }
            }

            $header_keys = array_keys($headers);

            // if it's not the headers row, iterate through the cells
            if ($row->getRowIndex() > 1)
            {
                foreach($cellIterator as $cell)
                {   
                    $colIndex = PHPExcel_Cell::columnIndexFromString($cell->getColumn());

                    if (in_array($colIndex, $header_keys))
                    {
                        $values[$headers[$colIndex]] = $cell->getValue();
                    }
                }
                /*
                 * assign headers to their respective variable names,
                 * e.g. $producer = $headers['producer']
                 */
                foreach(array_keys($values) as $key)
                {
                    if ($key != '')
                    {
                        $$key = trim($values[$key]);
                    }
                }
                
                // build slug for address; combine city and state
                $slug = $this->buildSlug($producer.' '.$city);
                $slug = $this->appendSlugSuffix($slug);

                // build slug to accurately locate city
                $citySlug = $this->buildSlug("$city $state");

                //details
                $state_id = ($state) ? $this->StateModel->getIDFromCode($state): 0;
                $city_id = ($city) ? $this->CityModel->getIDFromSlug($citySlug) : 0;
                $country_id = 1;

                // get producer type flag (is_manufacture, is_distributor, etc)
                $what_type = $this->determineType($producer_type);

                // update producer table
                $producer_data = array(
                    'producer' => $producer,
                    'custom_url' => $slug,
                    'url' => $website,
                    'twitter' => $twitter,
                    'facebook' => $facebook,
                    'phone' => $phone,
                    'creation_date' => date('Y-m-d')
                );

                // combine the retrieved flag with insert data
                if (is_array($what_type) && ! empty($what_type))
                    $producer_data = $producer_data + $what_type;

                // if producer exists, don't proceed with insert
                if ( ! $this->ProducerModel->checkIfProducerExists($producer, $city_id, $state_id, $address))
                {
                    // update producer table
                    $producer_id = $this->ProducerModel
                        ->insertProducerFromFile($producer_data);

                    if ($address != '')
                    {
                        // geocode if address is complete
                        if ($city!='' && $state!='')
                        {
                            $geoaddress = $this->AddressModel->prepareAddress(
                                $address, $city, $city_id, $state_id, $country_id, $zip_code);

                            @$geo = $this->GoogleMapModel->geoCodeAddressV3($geoaddress);
                        }
                        
                        // update address table
                        $address_data = array(
                            'producer_id' => $producer_id,
                            'city' => $city,
                            'address' => $address,
                            'zipcode' => $zip_code,
                            'country_id' => $country_id,
                            'latitude' => (empty($geo['latitude'])) ? '': $geo['latitude'] ,
                            'longitude' => (empty($geo['longitude'])) ? '': $geo['longitude']
                        );

                        if ($city_id && is_numeric($city_id))
                        {
                            $address_data['city_id'] = $city_id;
                        }

                        if ($state_id && is_numeric($state_id))
                        {
                            $address_data['state_id'] = $state_id;
                        }

                        $address_id = $this->AddressModel->insertAddressFromFile($address_data);
                    }

                    if ($category != '')
                    {
                        $categories = explode(',', $category);

                        // update producer_category_member table
                        $categoryList = $this->ProducerCategoryModel
                                ->getProducerCategoryIDFromName($categories);

                        if ( ! is_null($categoryList))
                        {
                            foreach($categoryList as $categories)
                            {
                                $member_data = array(
                                    'producer_category_id' => $categories->producer_category_id,
                                    'producer_id' => $producer_id,
                                );

                                if ( ! empty($address_id))
                                {
                                    $member_data['address_id'] = $address_id;
                                }

                                $this->ProducerCategoryModel
                                    ->insertProducerCategoryMemberFromFile($member_data);
                            }
                        }
                    }
                }
            }

            # if ($row->getRowIndex() > 4) break;
        }
    }

    /**
     * check to see if a producer exists in the database and append a dash
     * and an integer which is 1 + the number of existing producers with
     * the same name
     * 
     * @param String $producerSlug
     * @return String
     */
    private function appendSlugSuffix($producerSlug)
    {
        $duplicateSlug = $this->ProducerModel->checkIfOtherBranchesExist($producerSlug);

        if ($duplicateSlug > 0)
        {
            $suffix = (string)($duplicateSlug + 1);
            return $producerSlug.'-'.$suffix;
        }
        
        return $producerSlug;
    }
}