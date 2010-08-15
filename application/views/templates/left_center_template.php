<?php 
	if (isset($SEO) ) {
		$this->load->view('includes/header', array('SEO' => $SEO));
	} else {
		$this->load->view('includes/header');
	}
	
	if (isset ($CSS) ) {
		foreach ($CSS as $key => $css_file) {
			echo '<link href="' . base_url() . 'css/'.$css_file.'.css" rel="stylesheet" type="text/css" />';
		}
	}
?>

<?php
	if (isset($BREADCRUMB) ) {
		$this->load->view('includes/breadcrumb', array('BREADCRUMB' => $BREADCRUMB ) );
	} else {
		
	}
?>
<div align="center">
<table width = "980" border = "0" cellpadding = "0" cellspacing = "0">
	<tr>
		<td width="180" valign="top">
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
			
		<td width ="795" valign="top" style="padding-left:5px;">
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