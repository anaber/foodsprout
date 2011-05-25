<script src="<?php echo base_url()?>js/dashboard/common.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/dashboard/menu.js" type="text/javascript"></script>

<script>
	
	var userId = <?php echo $this->session->userdata('userId'); ?>;
	
	var jsonData;
	var currentContent;
	
	var toggleDuration = 1000;
	var isSupplierFormVisible = false;
	var isMenuFormVisible = false;
	var isCommentFormVisible = false;
	
	$(document).ready(function() {
		
		$.post("/user/ajaxMenuByUser", { q: userId },
		function(data){
			currentContent = 'menu';
			jsonData = data;
			redrawContent(data, 'menu');
		},
		"json");
	});
	
</script>

<div id="alert"></div>
<!-- center tabs -->

	<div>
		<div style="float:left;width:530px;"><h1>My Menu Items</h1></div>
		<div class="clear"></div>
		<hr size="1">
		<div class="clear"></div>
	</div>
	<div class = "clear"></div>
	
	<div id="resultsContainer" style = "border-style:solid;border-width:0px;border-color:#FF0000;">
		
		<div id="resultTableContainer" class="menus" style = "width:790px; padding:0px;"></div>
		<div class = "clear"></div>
		
		<div style="overflow:auto; padding:5px;">
			<div style="float:left; width:110px; font-size:10px;border-style:solid;border-width:0px;border-color:#FF0000;" id = 'numRecords'>Records 0-0 of 0</div>
			
			<div style="float:left; width:500px; font-size:10px;border-style:solid;border-width:0px;border-color:#FF0000;" id = 'pagingLinks' align = "center">
				<a href="#" id = "imgFirst">First</a> &nbsp;&nbsp;
				<a href="#" id = "imgPrevious">Previous</a>
				&nbsp;&nbsp;&nbsp; Page 1 of 1 &nbsp;&nbsp;&nbsp;
				<a href="#" id = "imgNext">Next</a> &nbsp;&nbsp;
				<a href="#" id = "imgLast">Last</a>
			</div>
			
			<div style="float:right; width:165px; font-size:10px;border-style:solid;border-width:0px;border-color:#FF0000;" id = 'recordsPerPage' align = "right">
				Items per page:&nbsp;
				<a href="#" id = "10PerPage">10</a> | 
				<a href="#" id = "20PerPage">20</a> |  
				<a href="#" id = "40PerPage">40</a> |  
				<a href="#" id = "50PerPage">50</a> 
			</div>
			
			<div class="clear"></div>
		</div>
		
	</div>
<!-- end center tabs -->