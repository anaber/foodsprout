<?php 
	if (isset($SEO) ) {
		$this->load->view('includes/header', array('SEO' => $SEO));
	} else {
		$this->load->view('includes/header');
	}
?>

<?php
/* END RESULT - We can remove table if we get divs in place
for($i = 0; $i < count($CENTER); $i++ ) {
 	$this->load->view($CENTER[$i]);
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
<div id="main-content-fluid">

	<table width = "100%" border = "0" cellpadding = "10" cellspacing = "0">
		<tr>
			<td style="width: 300px;" valign="top">
				<?
				foreach($LEFT as $key => $view) {

					if (isset($data['left'][$key]) ) {
						$this->load->view($view, $data['left'][$key]);
					} else {
						$this->load->view($view);
					}

				}
				?>
			</td>
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