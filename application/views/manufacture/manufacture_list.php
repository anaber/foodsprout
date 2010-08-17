<script src="<?php echo base_url()?>js/manufacture_search.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/popup.js" type="text/javascript"></script>

<script src="<?php echo base_url()?>js/jquery.autocomplete.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url()?>css/jquery.autocomplete.css" type="text/css" />

<script>
var dataManufactures;
	$(document).ready(function() {
		
		
		//loadPopupFadeIn();
		
		var formAction = '/state/ajaxSearchStates';
		postArray = {  };
		
		$.post(formAction, postArray,function(data) {
			
			$.post("/manufacture/ajaxSearchManufactures", { },
			function(data2){
				dataManufactures = data2;
				
				redrawFilterBox(data2, data);
				
				redrawContent(data2, data);
				
				reinitializeFilterEvent(dataManufactures);
				reinitializeAutoSuggestEvent(dataManufactures);
				reinitializeRemoveFilterEvent(dataManufactures);
				
			},
			"json");
		},
		"json");
		
		
	});
	

function reinitializeAutoSuggestEvent(dataManufactures) {
	
	$("#suggestion_box").autocomplete(
		"/manufacture/searchManufactures",
		{
			delay:10,
			minChars:3,
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:selectItem,
			onFindValue:findValue,
			formatItem:formatItem,
			autoFill:false
			/*
			extraParams: {
		       //extra: $("#selectedStateId").val()
		       extra: $("#stateId").val()
		    }
		    */
		}
	);
	
	$("#suggestion_box").change(function () {
		if ($("#suggestion_box").val() == "") {
			//loadPopupFadeIn();
			postAndRedrawContent(dataManufactures.param.firstPage, dataManufactures.param.perPage, dataManufactures.param.sort, dataManufactures.param.order, '', dataManufactures.param.filter);
		}
	});
}

function reinitializeRemoveFilterEvent(dataManufactures) {	
	$("#imgRemoveFilters").click(function () {
		postAndRedrawContent(dataManufactures.param.firstPage, dataManufactures.param.perPage, dataManufactures.param.sort, dataManufactures.param.order, '', '');
	});
}
	
function findValue(li) {
	if( li == null ) return alert("No match!");
 
	// if coming from an AJAX call, let's use the CityId as the value
	if( !!li.extra ) var sValue = li.extra[0];
 
	// otherwise, let's just display the value in the text box
	else var sValue = li.selectValue;
 
	//alert("The value you selected was: " + sValue);
	//alert(sValue);
	//alert(dataManufactures);
	//strFilter = 'm__' + sValue;
	
	//loadPopupFadeIn();
	postAndRedrawContent(dataManufactures.param.firstPage, dataManufactures.param.perPage, dataManufactures.param.sort, dataManufactures.param.order, sValue, '');
}
 
function selectItem(li) {
	findValue(li);
}

function formatItem(row) {
	//return row[0] + " (id: " + row[1] + ")";
	return row[0];
}

</script>

<div style = "float:left; width:600px; -moz-border-radius:7px;-webkit-border-radius:7px;background: #F05A25; color:#fff; padding:5px;">
	Search &nbsp;<input type="text" size="35" id = "suggestion_box">
</div>

<div style="float:right; width:160px;">
	<?php
		$this->load->view('includes/banners/sky');
	?>
</div>

<div id="resultsContainer" style="display:none" class="pd_tp1">
	<div style="float:left;width:300px;"><br /><h1>Products &amp; Companies</h1></div>
	<div id="resultTableContainer"></div>
</div>

<div style="overflow:auto; padding:5px;">

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

<!--
<input type = "hidden" id = "selectedStateId" value = "">

<div id="popupProcessing"> 
	<img src = "/img/icon_processing.gif">
</div> 

<div id="backgroundPopup"></div>
-->  