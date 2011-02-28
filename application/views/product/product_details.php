<div id="product_details_header" >
	<div id="productPhoto"></div>
	<div id="productName"><h1><?php echo $productDetails->product_name; ?></h1></div>
	<div id="iAteThisBtn"><a href="<?php echo base_url(); ?>product/eaten/<?php echo $productDetails->product_id; ?>" style="float: right;">I ate this</a></div>
	<div id="productBrand"><strong>Brand: </strong><?php echo $productDetails->brand; ?></div>
	<div id="productType"><strong>Type: </strong><?php echo $productDetails->product_type; ?></div>
	<div id="productManufacture"><strong>Manufacture: </strong><?php echo $productDetails->producer; ?></div>
	<div id="productIngredients"><strong>Ingredients: </strong><?php echo $productDetails->ingredient_text; ?></div>
	
	
	
</div>
<div id="product_ingredient_source"></div>
<div id="product_risk_factors"></div>