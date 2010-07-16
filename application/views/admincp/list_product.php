<?php $this->load->view('admincp/includes/paging'); ?>



<?php
if (count($PRODUCTS) > 0) {
?>
    <table cellpadding="3" cellspacing="0" border="0" id="tbllist">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Type</th>
            <th>Company</th>
            <th>Rest/Chain/Manf</th>
            <th>Ingredient</th>
            <th>Brand</th>
            <th>UPC</th>
            <!--th>Status</th-->
            <th>Fructose</th>

        </tr>


    <?php
    $i = 0;
    foreach ($PRODUCTS as $r) :
        $i++;
        echo '<tr class="d' . ($i & 1) . '">';
        echo '<td>' . $r->productId . '</td>';
        echo '<td>' . $r->productName . '</td>';
        echo '<td>' . $r->productType . '</td>';
        echo '<td>' . $r->companyName . '</td>';
        if ($r->restaurantId > 0) {
            echo '<td>' . $r->restaurantName . '</td>';
        }
        if ($r->restaurantChainId > 0) {
            echo '<td>' . $r->restaurantChainName . '</td>';
        }
        if ($r->manufactureId > 0) {
            echo '<td>' . $r->manufactureName . '</td>';
        }
        echo '<td>' . $r->ingredient . '</td>';
        echo '<td>' . $r->brand . '</td>';
        echo '<td>' . $r->upc . '</td>';
        //echo '<td>' . $r->status . '</td>';
        echo '<td>' . $r->hasFructose . '</td>';
        echo '</tr>';
    endforeach;
    ?>

    <?php
} else {
    echo "No product available";
}
    ?>
</table>