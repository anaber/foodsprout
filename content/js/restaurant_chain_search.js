var divClosed = false;
var recordCount;
var halfRecordCount;

function postAndRedrawContent(page, perPage, s, o, query, filter) {
	
	var formAction = '/chain/ajaxSearchRestaurantChains';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query, f:filter };
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data, filter);
	},
	"json");
}

function redrawContent(data) {
	
	$('#resultTableContainer').empty();
	var resultTableHtml = getResultTableHeader();
	var resultTableHtml = resultTableHtml;
	
	if (data.param.numResults == 0) {
		resultTableHtml += addZeroResult();
	} else {
		recordCount = data.param.end - data.param.start + 1;
		halfRecordCount = Math.ceil(recordCount / 2);
	
		$.each(data.results, function(i, a) {
			resultTableHtml += addResult(a, i);
		});
		
		if (divClosed == false) {
			resultTableHtml += '</div>';
		}
	}
	
	
	resultTableHtml += getResultTableFooter();
	$('#resultTableContainer').append(resultTableHtml);
	
	//$('#messageContainer').hide();
	$('#resultsContainer').show();
	
	// Move scroll to top of window.
	$('html, body').animate({scrollTop:0}, 'slow');
	
	$('#pagingLinks').empty();
	pagingLinksContent = drawPagingLinks(data.param);
	$('#pagingLinks').append(pagingLinksContent);
	
	reinitializePagingEvent(data);
	
	//disablePopupFadeIn();
}



function getResultTableHeader() {
	html =
		'<div align = "left">' + 
		'<div style="overflow:auto; padding:5px; width:690px;" align = "left">';
	return html;
}

function getResultTableFooter() {
	var html =
	'</div>' +  
	'</div>';
	return html;
}

function addResult(restaurantChain, count) {
	var html = '';
	if (count == 0 ) {
		html =
		'<div style="float:left; width:340px;">';
	}
	
	html +=
		'	<div style="padding:5px;"><a href="/chain/view/' + restaurantChain.restaurantChainId + '" id = "'+ restaurantChain.restaurantChainId +'">'+ restaurantChain.restaurantChain + '</a></div>';
	
	if (count == (halfRecordCount-1) ) {
		html += 
		'   </div>' + 
		'	<div style="float:right; width:340px;">';
	}
	
	if (count == (recordCount - 1) ) {
		html +=
		'</div>'
		;
	}
	
	if (count == (halfRecordCount-1) || count == (recordCount - 1) ) {
		divClosed = true;
	} else {
		divClosed = false;
	}
	return html;
}

function drawPagingLinks(params) {
	str = '';
	str += '<b>Page</b>&nbsp;&nbsp;';
	
	for( i = 0; i < params.totalPages; i++) {
		if (i != 0) {
			str += '&nbsp;&nbsp;|&nbsp;&nbsp;';
		}
		
		if (params.page == i) {
			str += '<b>' + ( i + 1 )+ '</b>';
		} else {
			str += '<a href="#" id = "' + i + '">' + ( i + 1 )+ '</a>';
		}
	}
	
	return str;
}

function reinitializePagingEvent(data) {
	$("#pagingLinks a").click(function(e) {
		selectedPage = this.id;
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(selectedPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
}
