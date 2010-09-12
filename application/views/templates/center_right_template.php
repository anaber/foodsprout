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
	<div id="add-designs">

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
<?php
/*
?>
<div id="main-content">
<table width = "100%" border = "0" cellpadding = "0" cellspacing = "0">
	<tr>
		<td width = "70%" valign = "top">
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
		</td>
		<td width = "30%" valign = "top">
		<?php
			foreach($RIGHT as $key => $view) {
				if (isset($data['right'][$key]['VIEW_HEADER']) ) {
					$this->load->view('includes/block_header', array('VIEW_HEADER' => $data['right'][$key]['VIEW_HEADER'] ) );
				}
				
				if (isset($data['right'][$key]) ) {
					$this->load->view($view, $data['right'][$key]);
				} else {
					$this->load->view($view);
				}

			}
		?>
		</td>
	</tr>
</table>
</div>
<?php $this->load->view('includes/footer'); ?>
<?php
*/
?>