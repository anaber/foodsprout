<script src="<?php echo base_url()?>js/product_search.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/popup.js" type="text/javascript"></script>

<script>
var dataProducts;
var hasFructose = <?php echo ( isset($FRUCTOSE) && $FRUCTOSE) ? '1' : '0'; ?>;

$(document).ready(function() {
	
	$.post("/product/ajaxSearchProducts", { f:hasFructose },
	function(data){
		dataProducts = data;
		redrawContent(dataProducts);
		
		reinitializeAutoSuggestEvent(dataProducts);
		
	},
	"json");
});

function reinitializeAutoSuggestEvent(dataProducts) {
	$("#suggestion_box").change(function () {
		if ($("#suggestion_box").val() == "") {
			//loadPopupFadeIn();
			postAndRedrawContent(dataProducts.param.firstPage, dataProducts.param.perPage, dataProducts.param.sort, dataProducts.param.order, '', dataProducts.param.filter);
		}
	});
}

</script>

<div style="float:right; width:160px;">
	<?php
		$this->load->view('includes/banners/sky');
	?>
</div>


<div id="resultsContainer" style="display:block" class="pd_tp1">
	<div style="float:left;width:300px;"><h1><?php echo ( isset($FRUCTOSE) && $FRUCTOSE) ? 'Products With Fructose' : 'Products'; ?></h1></div>
	<div id="resultTableContainer"></div>
	<div class="clear"></div>
</div>

<div style="overflow:auto; padding:5px;width:600px;">
	<div style="float:left; width:150px; font-size:10px;" id = 'numRecords'>Records 0-0 of 0</div>
	
	<div style="float:left; width:250px; font-size:10px;" id = 'pagingLinks' align = "center">
		<a href="#" id = "imgFirst">First</a> &nbsp;&nbsp;
		<a href="#" id = "imgPrevious">Previous</a>
		&nbsp;&nbsp;&nbsp; Page 1 of 1 &nbsp;&nbsp;&nbsp;
		<a href="#" id = "imgNext">Next</a> &nbsp;&nbsp;
		<a href="#" id = "imgLast">Last</a>
	</div>
	
	<div style="float:left; width:195px; font-size:10px;" id = 'recordsPerPage' align = "right">
		Items per page:
		<div id = "50PerPage" style="float:right; width:20px;">50</div>
		<div id = "40PerPage" style="float:right; width:30px;">40 | </div>  
		<div id = "20PerPage" style="float:right; width:30px;">20 | </div>
		<div id = "10PerPage" style="float:right; width:30px;">10 | </div>
	</div>
	<div class="clear"></div>
</div>
