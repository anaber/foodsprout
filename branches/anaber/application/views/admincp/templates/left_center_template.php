<?php $this->load->view('admincp/includes/header'); ?>

<?php
/* END RESULT - We can remove table if we get divs in place
for($i = 0; $i < count($CENTER); $i++ ) {
 	$this->load->view($CENTER[$i]);
 	echo "<br /><br />";
}

for($i = 0; $i < count($RIGHT); $i++ ) {
 	$this->load->view($RIGHT[$i]);
 	echo "<br /><br />";
}
*/
?>
<br />
<div id="main-content">
<table width = "980" border = "0" cellpadding = "5" cellspacing = "0">
	<tr>
		<td width = "150" valign = "top">
		<?php
			foreach($LEFT as $key => $view) {
				if (isset($data['left'][$key]['VIEW_HEADER']) ) {
					$this->load->view('admincp/includes/block_header', array('VIEW_HEADER' => $data['left'][$key]['VIEW_HEADER'] ) );
				}
				
				if (isset($data['left'][$key]) ) {
					$this->load->view($view, $data['left'][$key]);
				} else {
					$this->load->view($view);
				}

			}
		?>
		<td>
			
		<td width = "830" valign = "top">
		
		<?php
			if (isset($BREADCRUMB) ) {
				
				$this->load->view('/admincp/includes/breadcrumb', array('BREADCRUMB' => $BREADCRUMB ) );
			}
		?>
		
		<?php
			foreach($CENTER as $key => $view) {
				if (isset($data['center'][$key]['VIEW_HEADER']) ) {
					$this->load->view('admincp/includes/block_header', array('VIEW_HEADER' => $data['center'][$key]['VIEW_HEADER'] ) );
				}
				
				if (isset($data['center'][$key]) ) {
					$this->load->view($view, $data['center'][$key]);
				} else {
					$this->load->view($view);
				}

			}
		?>
		<td>
		
	</tr>
</table>
</div>
<?php $this->load->view('admincp/includes/footer'); ?>