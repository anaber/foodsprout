<?php $this->load->view('includes/paging'); ?>



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

    <?php
} else {
    echo "No product available";
}
    ?>
</table>