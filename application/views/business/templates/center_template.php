<?php 
	$arr = array();
	if (isset($SEO) ) {
		$arr['SEO'] = $SEO;
	}
	
	if (isset($ASSETS) ) {
		$arr['ASSETS'] = $ASSETS;
	}
	$this->load->view('business/includes/header', $arr);
?>

<?php
	if (isset($BREADCRUMB) ) {
		$this->load->view('includes/breadcrumb', array('BREADCRUMB' => $BREADCRUMB ) );
	} else {
		echo '<br>';
	}
?>

<div id="main-content">

	<table width = "100%" border = "0" cellpadding = "0" cellspacing = "0">
		<tr>
			<td width = "100%" valign = "top">
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
		</tr>
	</table>
</div>

<?php $this->load->view('includes/footer'); ?>