<script src="<?php echo base_url()?>js/jquery.colorize.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/restaurant_search.js" type="text/javascript"></script>

<div style="overflow:auto; padding:5px;">
	<div style="float:left; width:200px;" id = 'numRecords'></div>
	<div style="float:left; width:190px;" id = 'recordsPerPage' align = "center"></div>
	<div style="float:right; width:350px;" id = 'pagingLinks' align = "right"></div>
	<div class="clear"></div>
</div>

<h2 class="blue_text first" id="messageContainer" align = "center">Your search results are loading, please wait.</h2>

<div id="resultsContainer" style="display:none" class="pd_tp1">
	<div id="resultTableContainer"></div>
</div>
