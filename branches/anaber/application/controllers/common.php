<?php

class Common extends Controller {
	
	function __construct() {
		parent::Controller();
		checkUserLogin();
	}
	
	function supplier_save_add() {
		if ($this->session->userdata('isAuthenticated') == 1 ) {
			$this->load->model('SupplierModel', '', TRUE);
			
			$GLOBALS = array();
			if ( $this->SupplierModel->addSupplierIntermediate() ) {
				echo 'yes';
			} else {
				if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
					echo $GLOBALS['error'];
				} else {
					echo 'no';
				}
			}
		} else {
			echo 'no';
		}
	}
	
	function supplier_save_update() {
		if ($this->session->userdata('isAuthenticated') == 1 ) {
			$this->load->model('SupplierModel', '', TRUE);
			
			$GLOBALS = array();
			if ( $this->SupplierModel->updateSupplierIntermediate() ) {
				echo 'yes';
			} else {
				if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
					echo $GLOBALS['error'];
				} else {
					echo 'no';
				}
			}
		} else {
			echo 'no';
		}
	}
	
	function menu_item_save_add() {
		if ($this->session->userdata('isAuthenticated') == 1 ) {
			$this->load->model('ProductModel', '', TRUE);
			
			$GLOBALS = array();
			if ( $this->ProductModel->addProductIntermediate() ) {
				echo 'yes';
			} else {
				if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
					echo $GLOBALS['error'];
				} else {
					echo 'no';
				}
			}
		} else {
			echo 'no';
		}
	}
	
	function menu_item_save_update() {
		if ($this->session->userdata('isAuthenticated') == 1 ) {
			$this->load->model('ProductModel', '', TRUE);
			
			$GLOBALS = array();
			if ( $this->ProductModel->updateProduct() ) {
				echo "yes";
			} else {
				if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
					echo $GLOBALS['error'];
				} else {
					echo 'no';
				}
			}
		} else {
			echo 'no';
		}
	}
	
	function comment_save_add() {
		if ($this->session->userdata('isAuthenticated') == 1 ) {
			$this->load->model('CommentModel', '', TRUE);
			
			$GLOBALS = array();
			$return = $this->CommentModel->addComment();
			if ( $return ) {
				echo $return;
			} else {
				if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
					echo $GLOBALS['error'];
				} else {
					echo 'no';
				}
			}
		} else {
			echo 'no';
		}
	}
	
	/*
	function comment_save_update() {
		if ($this->session->userdata('isAuthenticated') == 1 ) {
			$this->load->model('CommentModel', '', TRUE);
			
			$GLOBALS = array();
			if ( $this->CommentModel->updateSupplierIntermediate() ) {
				echo 'yes';
			} else {
				if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
					echo $GLOBALS['error'];
				} else {
					echo 'no';
				}
			}
		} else {
			echo 'no';
		}
	}
	*/
	
	function photo_save_add() {
		$this->load->model('PhotoModel', '', TRUE);
		$GLOBALS = array();
		
		$return = $this->PhotoModel->addPhoto();
		if ( $return ) {
			echo json_encode($return);
			//echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}	
	}
	
	function photo_title_save_update() {
		if ($this->session->userdata('isAuthenticated') == 1 ) {
			$this->load->model('PhotoModel', '', TRUE);
			
			$GLOBALS = array();
			if ( $this->PhotoModel->updatePhotoTitle() ) {
				echo 'yes';
			} else {
				if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
					echo $GLOBALS['error'];
				} else {
					echo 'no';
				}
			}
		} else {
			echo 'no';
		}
	}
	
	function ajaxGetCommentFromId() {
		$commentId = $this->input->post('q');
		$this->load->model('CommentModel', '', TRUE);
		$comment = $this->CommentModel->getCommentFromId($commentId);
		echo json_encode($comment);
	}
	
}

/* End of file common.php */

?>