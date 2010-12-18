<?php
	if (isset($SEO) ) {
		$this->load->view('includes/header', array('SEO' => $SEO));
	} else {
		$this->load->view('includes/header');
	}

?>
<?php
	if (isset($NAME) ) {
		$this->load->view('includes/name', array('BREADCRUMB' => $NAME ) );
	}
	else{
	}
	
	if (isset($BREADCRUMB) ) {
		$this->load->view('includes/breadcrumb', array('BREADCRUMB' => $BREADCRUMB ) );
	}
	else{
	}

?>

	<!-- left column-->
	<div id="rest-main-details">

	<?php
		foreach($LEFT as $key => $view) {
			if (isset($data['left'][$key]['VIEW_HEADER']) ) {
				$this->load->view('includes/block_header', array('VIEW_HEADER' => $data['left'][$key]['VIEW_HEADER'] ) );
			}

			if (isset($data['left'][$key]) ) {
				$this->load->view($view, $data['left'][$key]);
			} else {
				$this->load->view($view);
			}

		}
    ?>


	</div>
	<!-- end left column -->

  	<?php

		foreach($CENTER as $key => $view) {
			if (isset($data['center'][$key]['VIEW_HEADER']) ) {
				$this->load->view('includes/block_header', array('VIEW_HEADER' => $data['center'][$key]['VIEW_HEADER'] ) );
			}

			if (isset($data['center'][$key]) ) {
				$this->load->view($view, $data['center'][$key]);
			} else {
				$this->load->view($view);
			}
		}

	?>

<?php $this->load->view('includes/footer'); ?>