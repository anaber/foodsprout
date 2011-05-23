<?php 
	if (isset($SEO) ) {
		$this->load->view('business/includes/header', array('SEO' => $SEO));
	} else {
		$this->load->view('business/includes/header');
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
	} else {
		if (!isset($NAME) ) {
			echo "<br />";
		}
	}
?>
<table width = "980" border = "0" cellpadding = "0" cellspacing = "0">
	<tr>
		<td width="180" valign="top" id="column-left">
		<?php
			foreach($NAV as $key => $view) {
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
		</td>
			
		<td width ="795" valign="top" style="padding-left:5px;">
		<?php
			foreach($MAIN as $key => $view) {
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
<?php $this->load->view('includes/footer'); ?>