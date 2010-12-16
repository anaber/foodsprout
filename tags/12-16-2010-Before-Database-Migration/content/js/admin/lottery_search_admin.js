
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/lottery/ajaxSearchLotteries", { },
		function(data){
			$('#suggestion_box').val('');
			
			redrawContent(data);
		},
		"json");
		
	$("#suggestion_box").keyup(function() {
		var query = $("#suggestion_box").val();
		
		if ( query.length >= 3 || query.length == 0 ) {
			$('#resultsContainer').hide();
			$('#messageContainer').show();
			$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
			
			$.post("/admincp/lottery/ajaxSearchLotteries", { q:query },
			function(data){
				redrawContent(data);
	      	},
	      	"json");
      	}
      	
	});

});

function postAndRedrawContent(page, perPage, s, o, query) {
	
	$('#resultsContainer').hide();
	$('#messageContainer').show();
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	var formAction = '/admincp/lottery/ajaxSearchLotteries';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
}


function reinitializeTableHeadingEvent(data) {
	$("#heading_id").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'lottery_id');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'lottery_id', order, data.param.q);
	});
	
	$("#heading_lottery").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'lottery_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'lottery_name', order, data.param.q);
	});
	
	$("#heading_restaurant").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'restaurant_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'restaurant_name', order, data.param.q);
	});
	
	$("#heading_city").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'city');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'city', order, data.param.q);
	});
	
	$("#heading_start_date").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'start_date');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'start_date', order, data.param.q);
	});
	
	$("#heading_end_date").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'end_date');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'end_date', order, data.param.q);
	});
}

function addResult(lottery, i) {
	var html =
	'<tr>' +
	'	<td valign="top"><a href="/admincp/lottery/update/'+ lottery.lotteryId +'">'+ lottery.lotteryId +'</a></td>' +
	'	<td valign="top"><a href="/admincp/lottery/update/'+ lottery.lotteryId +'">'+ lottery.lotteryName +'</a></td>' +
	'	<td valign="top">'+ lottery.restaurantName +'</td>' +
	'	<td valign="top">'+ lottery.city + ', ' + lottery.stateCode +'</td>' +
	'	<td valign="top">'+ lottery.startDate +'</td>' +
	'	<td valign="top">'+ lottery.endDate +'</td>' +
	'	<td valign="top">';
	
	$.each(lottery.prizes, function(j, prize) {
		html += '<a href = "/admincp/lottery/update_prize/'+prize.lotteryPrizeId+'">' + prize.prize + " ($" + prize.dollarAmount + ")" +"</a><br /><br />";
	});
	
	html += '<a href = "/admincp/lottery/add_prize/'+lottery.lotteryId+'">+Prize</a>' +
			'</td>';
	
	html +=
	'	<td valign="top">';
	/*
	$.each(manufacture.addresses, function(j, address) {
		html += '<a href = "/admincp/manufacture/update_address/'+address.addressId+'">' + address.displayAddress + '</a><br /><br />';
	});
	*/
	html += '</td>';
	html +=
	'</tr>'
	;
	
	return html;
}

function getResultTableHeader() {
	var html =
	' <table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "99%">' +
	'	<thead>' +
	'	<tr>' +
	'		<th id = "heading_id"><a href = "#" style = "color:#FFFFFF">Id</a></th>' +
	'		<th id = "heading_lottery"><a href = "#" style = "color:#FFFFFF">Lottery Name</a></th>' +
	'		<th id = "heading_restaurant"><a href = "#" style = "color:#FFFFFF">Restaurant</a></th>' +
	'		<th id = "heading_city"><a href = "#" style = "color:#FFFFFF">City</a></th>' +
	'		<th id = "heading_start_date"><a href = "#" style = "color:#FFFFFF">Start Date</a></th>' +
	'		<th id = "heading_end_date"><a href = "#" style = "color:#FFFFFF">End Date</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Prize</a></th>' +
	'		<th id = ""><a href = "#" style = "color:#FFFFFF">Winners</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

