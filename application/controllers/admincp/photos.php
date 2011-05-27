<?php

class Photos extends Controller {
	
        private $uploadPath;
        
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('access') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
                
                $this->load->helper(array('utf8', 'debug'));
                
                // $this->output->enable_profiler();
	}
        
        private function processImage($source, $mainPath, $thumbPath, 
                $mainWidth=75, 
                $mainHeight=100,
                $thumbWidth=50,
                $thumbHeight=50)
        {
            global $IMAGEMAGICK_PATH, $UPLOAD_FOLDER;
            
            $lib_path = substr($IMAGEMAGICK_PATH, 0, strpos($IMAGEMAGICK_PATH, '/convert'));
            $config['image_library'] = 'imagemagick';
            $config['library_path'] = $IMAGEMAGICK_PATH;
            $config['source_image'] = $source;           
            $config['maintain_ratio'] = FALSE;

            // create main image
            $targetPath = dirname($mainPath);
            if ( ! is_dir($targetPath))
            {
                mkdir($targetPath, 0777, TRUE);
            }
            
            $main_config = array(
                'height' => $mainHeight,
                'width' => $mainWidth,
                'new_image' => $mainPath
            );
            
            $this->load->library('image_lib', $config+$main_config);
            
            if ( ! $this->image_lib->resize())
            {
                return FALSE;
            }
            
            // create thumbnail
            $targetPath = dirname($thumbPath);
            if ( ! is_dir($targetPath))
            {
                mkdir($targetPath, 0777, TRUE);
            }
            
            $thumb_config = array(
                'height' => $thumbHeight,
                'width' => $thumbHeight,
                'new_image' => $thumbPath
            );
            
            $this->image_lib->initialize($config+$thumb_config);
            
            if ( ! $this->image_lib->resize())
            {
                return FALSE;
            }
            
            return TRUE;
        }
        
        function add()
        {
            global $UPLOAD_FOLDER;
            
            $this->load->helper(array('form','url'));
            
            $this->load->library(array('form_validation'));
            
            $data = $uploadErrors = array();
            
            if ($_POST)
            {
                $this->load->model('PhotoModel');
                
                $input = array_merge($_POST, $_FILES);
                
                #die(Debug::vars($input));
                
                // set rules
                if ($this->form_validation->run('photo'))
                {
                    $insert = array();
                    
                    // determine type of photo
                    switch($input['type'])
                    {
                        case 'producer':
                            $var = 'producer_id';
                            break;
                        case 'product':
                            $var = 'product_id';
                            break;
                    }
                    
                    // insert determined type
                    if ( ! is_null($var))
                    {
                        $insert[$var] = $input['item_id'];
                    }
                    
                    if ($_FILES['image']['error'] != 4)
                    {
                        $uploadPath = $UPLOAD_FOLDER . '/' .
                            $input['type'] . '/' .
                            $input['item_id'] . '/';

                        $uploadInfo = pathinfo($input['image']['name']);

                        // check if file already exists
                        if ( ! $this->PhotoModel->existsPhoto($input['type'],
                            $input['item_id'],
                            $uploadInfo['filename'].'_main.'.$uploadInfo['extension']))
                        {
                            // perform upload and thumbnail creation
                            $doUpload = $this->processUpload($input['image'], $uploadPath,
                                    $_POST['thumb_size'], $_POST['main_size']);

                            if ($doUpload['status'] === TRUE)
                            {
                                $uploadData = $doUpload['data'];
                                $insert['extension']    = $uploadData['file_ext'];
                                $insert['mime_type']    = $uploadData['file_type'];
                                $insert['path']         = '/'.$input['type'].'/'.$input['item_id'].'/';
                                $insert['title']        = $input['title'];
                                $insert['description']  = $input['description'];

                                $typeIdPath = $uploadInfo['filename'].'_%s'.$uploadData['file_ext'];
                                $insert['thumb_photo_name']     = sprintf($typeIdPath, 'thumb');
                                $insert['original_photo_name']  = sprintf($typeIdPath, 'original');
                                $insert['photo_name']           = sprintf($typeIdPath, 'main');
                                $insert['thumb_width']          = $uploadData['thumbWidth'];
                                $insert['thumb_height']         = $uploadData['thumbHeight'];
                                $insert['height']               = $uploadData['mainHeight'];
                                $insert['width']                = $uploadData['mainWidth'];

                                // add additional data
                                $insert['track_ip']     = $this->input->ip_address();
                                $insert['added_on']     = date('Y-m-d');
                                $insert['user_id']      = $this->session->userdata['userId'];

                                // insert photo details to database
                                $status = $this->PhotoModel->insertPhoto($insert);

                                if (isset($_POST['save_list']))
                                {
                                    redirect('admincp/photos');
                                }
                                elseif(isset($_POST['save_edit']))
                                {
                                    redirect($_SERVER['HTTP_REFERER']);
                                }
                            }
                            else
                            {
                                $uploadErrors[] = $doUpload['data'];
                            }
                        }
                        else
                        {
                            $uploadErrors[] = 'This file already exists for this '.$input['type'];
                        }
                    }
                    else
                    {
                        $uploadErrors[] = 'No file was uploaded';
                    }
                }
            }
            
            $data['CENTER'] = array(
                'list'=> 'admincp/forms/photo_form',               
            );  
            
            $data['UPLOAD_ERRORS'] = $uploadErrors;
            
            $this->load->view('admincp/templates/center_template', $data);
        }
        
        function edit($id)
        {
            $this->load->model('PhotoModel');
            $this->load->helper('html');
            $this->load->library('form_validation');
            global $UPLOAD_FOLDER;
            
            $uploadErrors = $insert = array();
            
            if (FALSE != ($photo = $this->PhotoModel->getPhotoByPhotoId($id)))
            {
                if ($_POST)
                {
                    $input = array_merge($_POST, $_FILES);
                    
                    if ($this->form_validation->run('photo'))
                    {
                        // determine type of photo
                        switch($input['type'])
                        {
                            case 'producer':
                                $var = 'producer_id';
                                break;
                            case 'product':
                                $var = 'product_id';
                                break;
                        }

                        // insert determined type
                        if ( ! is_null($var))
                        {
                            $insert[$var] = $input['item_id'];
                        }

                        if ($_FILES['image']['error'] != 4)
                        {
                            $uploadInfo = pathinfo($input['image']['name']);
                            $pathParts = array(
                                $UPLOAD_FOLDER, $input['type'],$input['item_id']
                            );
                            $uploadPath = implode(DIRECTORY_SEPARATOR, $pathParts).DIRECTORY_SEPARATOR;

                            if ( ! $this->PhotoModel->existsPhoto($input['type'],
                                $input['item_id'], $uploadInfo['filename']))
                            {
                                // proceed with image deletion and uploading
                                $oldMain = $UPLOAD_FOLDER.$photo->path.'main/'.$photo->photo_name;
                                $oldThumb = $UPLOAD_FOLDER.$photo->path.'thumb/'.$photo->thumb_photo_name;
                                $oldOrig = $UPLOAD_FOLDER.$photo->path.'original/'.$photo->original_photo_name;
                                
                                if (file_exists($oldMain)) unlink($oldMain);
                                if (file_exists($oldThumb)) unlink($oldThumb);
                                if (file_exists($oldOrig)) unlink($oldOrig);
                                
                                #echo Debug::vars(array($oldMain, $oldThumb, $oldOrig));die();

                                $doUpload = $this->processUpload($input['image'], $uploadPath, 
                                        $_POST['thumb_size'], $_POST['main_size']);

                                if ($doUpload['status'] === TRUE)
                                {
                                    $uploadData = $doUpload['data'];
                                    $insert['extension']    = $uploadData['file_ext'];
                                    $insert['mime_type']    = $uploadData['file_type'];
                                    $insert['path']         = '/'.$input['type'].'/'.$input['item_id'].'/';

                                    $typeIdPath = $uploadInfo['filename'].'_%s'.$uploadData['file_ext'];
                                    $insert['thumb_photo_name']     = sprintf($typeIdPath, 'thumb');
                                    $insert['original_photo_name']  = sprintf($typeIdPath, 'original');
                                    $insert['photo_name']           = sprintf($typeIdPath, 'main');
                                    $insert['thumb_width']          = $uploadData['thumbWidth'];
                                    $insert['thumb_height']         = $uploadData['thumbHeight'];
                                    $insert['height']               = $uploadData['mainHeight'];
                                    $insert['width']                = $uploadData['mainWidth'];
                                }
                            }
                        }

                        $insert['track_ip']     = $this->input->ip_address();
                        $insert['title']        = $input['title'];
                        $insert['description']  = $input['description'];
                        $insert['status']       = $input['status'];
                        
                        $this->PhotoModel->updatePhoto($photo->photo_id, $insert);
                        
                        if (isset($_POST['save_list']))
                        {
                            redirect('admincp/photos');
                        }
                        elseif(isset($_POST['save_edit']))
                        {
                            redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                }
                
                $data['CENTER'] = array(
                    'list'=>'admincp/forms/photo_form'
                );
                
                $data['EDIT'] = TRUE;
                $data['UPLOAD_ERRORS'] = $uploadErrors;
                $data['PHOTO'] = $photo;
                list($itemType, $itemID) = $this->PhotoModel->checkAssociatedData($photo->photo_id);
                $data['ASSOCIATED_DATA'] = $this->PhotoModel->getAssociatedData($itemType, $itemID);
                
                $this->load->view('admincp/templates/center_template', $data);
            }
            else
                show_404();
        }
	
	function index() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/photos',
			);

        $data['LEFT'] = array(
            'menu' => 'admincp/menus/photo'
        );
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Photos";
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function ajaxSearchPhotos()
	{
		$this->load->model('PhotoModel', '', TRUE);
		$photos = $this->PhotoModel->getPhotosAdminJson('restaurant');		

		echo json_encode($photos);

	}	
	
	function photoAction()
	{
		if ($this->input->post('action'))
		{
			$this->load->model('PhotoModel');
			
			if ($this->input->post('action') == 'delete')
			{				
				if ($this->PhotoModel->deletePhoto($this->input->post('photo')))
				{
					echo "Photo Deleted";					
				}
				else 
				{
					echo "Something went wrong.";
				}	
				
			}
			else if ($this->input->post('action') == 'approve')
			{
				if ($this->PhotoModel->approvePhoto($this->input->post('photo')))
				{
					echo "Photo Approved";
				} 
				else 
				{
					echo "Something went wrong.";
				}
			}
			
			exit;
		}
	}
        
        function getItemForPhoto()
        {
           
           $this->load->model('PhotoModel');
           
           $q = $this->input->get('q');
           $type = $this->input->get('type');
           
           $data = $this->PhotoModel->getDataForAutoComplete($type,$q);
           
           echo $data;
        }
        
        function processUpload(array $file, $uploadPath, $thumbSize, $mainSize)
        {
            
            $uploadInfo = pathinfo($file['name']);

            $origPath = $uploadPath.'original';

            if ( ! is_dir($origPath))
            {
                mkdir($origPath, 0777, true);
            }

            $photoConfig = array(
                'file_name' =>   $uploadInfo['filename'].'_original.'.$uploadInfo['extension'],
                'upload_path' => $origPath,
                'allowed_types'=>'png|gif|bmp|jpg|jpeg',
                'max_size' => '2048'
            );
            
            $this->load->library('upload', $photoConfig);
            
            if ($this->upload->do_upload('image'))
            {
                $uploadData = $this->upload->data();
                
                // get thumbnail size
                $tmpSize = explode('_', $thumbSize);
                $thumbWidth = $tmpSize[0];
                $thumbHeight = $tmpSize[1];

                // get main size
                $tmpSize = explode('_', $mainSize);
                $mainWidth = $tmpSize[0];
                $mainHeight = $tmpSize[1];

                $this->processImage($uploadData['full_path'], 
                        $uploadPath.'main/'.$uploadInfo['filename'].'_main'.$uploadData['file_ext'], 
                        $uploadPath.'thumb/'.$uploadInfo['filename'].'_thumb'.$uploadData['file_ext'],
                        $mainWidth,$mainHeight,
                        $thumbWidth,$thumbHeight
                );
                
                $data = array_merge($uploadData, array(
                    'thumbWidth'=>$thumbWidth,
                    'thumbHeight'=>$thumbHeight,
                    'mainWidth' => $mainWidth,
                    'mainHeight'=>$mainHeight
                ));
                    
                return array(
                    'status' => TRUE,
                    'data' => $data
                );
            }
            
            else
            {
                return array(
                    'status' => FALSE,
                    'data' => $this->upload->display_errors()
                );
            }
        }
        
        function check()
        {
            $this->load->model('PhotoModel');
            
            $this->PhotoModel->checkAssociatedData(1);
        }
}

/* End of file photos.php */