<?php
	if (isset($SEO) ) {
		$this->load->view('dashboard/includes/header', array('SEO' => $SEO));
	} else {
		$this->load->view('dashboard/includes/header');
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
<br />
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

	<!-- right ads -->
	<div style="float:right;width:160px;">

    <?php
		foreach($RIGHT as $key => $view) {
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

	</div>
	<!-- end right ads -->

<?php $this->load->view('includes/footer'); ?>