<?php $this->load->view('includes/header'); ?>

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
?>
<table width = "100%" border = "1" cellpadding = "0" cellspacing = "0">
	<tr>
		<td width = "100%" valign = "top">
		<?php
			foreach($CENTER as $key => $view) {
				if (isset($data['center'][$key]) ) {
					$this->load->view($view, $data['center'][$key]);
				} else {
					$this->load->view($view);
				}
				echo "<hr style = 'color:#0000FF' />";
			}
		?>
		<td>
	</tr>
</table>

<?php $this->load->view('includes/list_footer'); ?>