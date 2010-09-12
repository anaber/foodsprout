<script src="<?php echo base_url()?>js/search/manufacture_search.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/popup.js" type="text/javascript"></script>

<script>
var dataManufactures;
	$(document).ready(function() {
		$.post("/manufacture/ajaxSearchManufactures", { },
		function(data){
			dataManufactures = data;
			
			redrawContent(dataManufactures);
			
			reinitializeAutoSuggestEvent(dataManufactures);
		},
		"json");
	});

function reinitializeAutoSuggestEvent(dataManufactures) {
	$("#suggestion_box").change(function () {
		if ($("#suggestion_box").val() == "") {
			postAndRedrawContent(dataManufactures.param.firstPage, dataManufactures.param.perPage, dataManufactures.param.sort, dataManufactures.param.order, '', dataManufactures.param.filter);
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
	<div style="float:left;"><h1>Products &amp; Companies</h1></div>
	<div style="float:right;"><hr style = "border:1px solid #F05A25; width:418px; margin-right:22px;margin-top:10px;" /></div>
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
