<?php $this->load->view('includes/header'); ?>

<?php
	if (isset($BREADCRUMB) ) {
		$this->load->view('includes/breadcrumb', array('BREADCRUMB' => $BREADCRUMB ) );
	} else{
		echo '<br>';
	}
?>
<div id="main-content">
<table width = "970" border = "0" cellpadding = "0" cellspacing = "0">
	<tr>
		<td width = "170" valign = "top">
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
		</td>
			
		<td width ="790" valign="top" style="padding-left:10px;">
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