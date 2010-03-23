<?php $this->load->view('admincp/includes/header'); ?>

<?php
/* END RESULT - We can remove table if we get divs in place
for($i = 0; $i < count($CENTER); $i++ ) {
 	$this->load->view($CENTER[$i]);
 	echo "<br /><br />";
}
*/

	if (isset($BREADCRUMB) ) {
		
		$this->load->view('includes/breadcrumb', array('BREADCRUMB' => $BREADCRUMB ) );
	}
	else{
		echo '<br>';
	}
?>
<div id="main-content">

	<table width = "980" border = "0" cellpadding = "0" cellspacing = "0">
		<tr>
			<td valign = "top">
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