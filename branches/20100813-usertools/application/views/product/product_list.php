<?php
	$this->load->view('/includes/paging');
?>
<?php
if (count($PRODUCTS) > 0) {
?>
    <table cellpadding="3" cellspacing="0" border="0" id="tbllist" width="98%">
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Manufacturer</th>
            <th>Brand</th>
        </tr>
    <?php
    $i = 0;
    foreach ($PRODUCTS as $r) :
        $i++;
        echo '<tr class="d' . ($i & 1) . '">';
        echo '<td>' . $r->productName . '</td>';
        echo '<td>' . $r->productType . '</td>';
        echo '<td>' . $r->manufactureName . '</td>';
        echo '<td>' . $r->brand . '</td>';
        echo '</tr>';
    endforeach;
    ?>
	</table>
<?php
} else {
?>
	<table cellpadding="3" cellspacing="0" border="0" id="tbllist" width="98%">
        <tr>
    		<td>No product available</td>
    	</tr>
    </table>
<?php
}
/*
?>
<div style="overflow:auto; padding:5px;" align="left">
	
	<div style="width:690px; padding:10px; font-size:10px; border-color:#FF0000; border-width:1px; border-style:solid;" id = 'pagingLinks' align = "center">
		<b>Page</b> &nbsp;&nbsp;
		<a href="#" id = "1">1</a>
	</div>
	
	<div class="clear"></div>
</div>
<?php
*/
?>