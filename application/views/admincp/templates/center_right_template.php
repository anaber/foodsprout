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
<?php
	if (isset($BREADCRUMB) ) {
		
		$this->load->view('includes/breadcrumb', array('BREADCRUMB' => $BREADCRUMB ) );
	}
	else{
		echo '<br>';
	}
?>
<div id="main-content">
<table width = "980" border = "0" cellpadding = "5" cellspacing = "0">
	<tr>
		<td width = "780" valign = "top">
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
		<td width = "200" valign = "top">
		<?php
			foreach($RIGHT as $key => $view) {
				if (isset($data['right'][$key]['VIEW_HEADER']) ) {
					$this->load->view('admincp/includes/block_header', array('VIEW_HEADER' => $data['right'][$key]['VIEW_HEADER'] ) );
				}
				
				if (isset($data['right'][$key]) ) {
					$this->load->view($view, $data['right'][$key]);
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