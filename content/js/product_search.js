function postAndRedrawContent(page, perPage, s, o, query, filter) {
	
	var formAction = '/product/ajaxSearchProducts';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query, f:filter };
	
	$.post(formAction, postArray,function(data) {		
		dataProducts = data;
		redrawContent(dataProducts);
	},
	"json");
}

function redrawContent(data) {
	
	$('#resultTableContainer').empty();
	//var resultTableHtml = getResultTableHeader();
	var resultTableHtml = '';
	
	if (data.param.numResults == 0) {
		resultTableHtml += addZeroResult();
	} else {
		$.each(data.results, function(i, a) {
			resultTableHtml += addResult(a, i);
		});
	}
	
	//resultTableHtml += getResultTableFooter();
	$('#resultTableContainer').append(resultTableHtml);
	
	//$('#messageContainer').hide();
	$('#resultsContainer').show();
	
	// Move scroll to top of window.
	//$('html, body').animate({scrollTop:0}, 'slow');
	$('html, body').scrollTop(0);
	
	$('#numRecords').empty();
	numRecordsContent = drawNumRecords(data.param);			
	$('#numRecords').append(numRecordsContent);
	
	$('#recordsPerPage').empty();
	recordsPerPageContent = drawRecordsPerPage(data.param);
	$('#recordsPerPage').append(recordsPerPageContent);
	
	$('#pagingLinks').empty();
	pagingLinksContent = drawPagingLinks(data.param);
	$('#pagingLinks').append(pagingLinksContent);
	
	reinitializePagingEvent(data);
	
	reinitializePageCountEvent(data);
	
	if (data.param.q) {
		//$('#suggestion_box').val(data.param.q);
	} else  {
		$('#suggestion_box').val('');
	}
}

function addResult(product, count) {
	var html =
	'<div style="overflow:auto; padding:0px; clear:left; margin-right:10px; padding-bottom:10px;">' +
	'	<div style="float:left; clear:both; padding:3px; width:600px; background:#e5e5e5; font-weight:bold;"><a href="/product/view/' + product.productId + '" id = "'+ product.productId +'" style="text-decoration:none;">'+ product.productName +'</a></div><div style="float:left; width:300px; clear:left;padding-left:3px; padding-right:10px;">Type : '+ product.productType + '<br />Brand:' + product.brand + '</div>' +
	'	<div style="float:left; width:295px;">Manufacture:<br /><a href="/manufacture/view/' + product.manufactureId + '">' + product.manufactureName + '</a></div>' +
	'</div>';
	
	return html;
}

function addZeroResult() {
	var html =
	'<div style="overflow:auto; padding:0px; clear:left; margin-right:10px; padding-bottom:10px;" align = "center">' +
	'	<div style="float:left; width:600px; clear:left;padding-left:3px; padding-right:10px;">No results found. Please retry with some other filter options.</div>' + 
	'</div>'
	;	
	return html;
}

function drawPagingLinks(params) {
	str = '';
	str += '<a href="#" id = "imgFirst">First</a> &nbsp;&nbsp;';
	str += '<a href="#" id = "imgPrevious">Previous</a> ';
	str += '&nbsp;&nbsp;&nbsp; Page ' + (parseInt(params.page)+1) + ' of ' + params.totalPages + '&nbsp;&nbsp;&nbsp;';
	str += '<a href="#" id = "imgNext">Next</a> &nbsp;&nbsp;';
	str += '<a href="#" id = "imgLast">Last</a>';
	
	return str;
}

function drawNumRecords(params) {
	str = '';
	
	if (params.numResults == 0) {
		str = 'Records 0' + '-' + params.end + ' of ' + params.numResults;
	} else {
		str = 'Records ' + params.start + '-' + params.end + ' of ' + params.numResults;
	}
	
	return str;
}

function drawRecordsPerPage(params) {
	str = '';
	str +=  'Items per page: ';
	
	if (params.perPage == 10) {
		str += '<strong>10</strong> | ';
	} else {
		str += '<a href="#" id = "10PerPage">10</a> | ';
	}
	
	if (params.perPage == 20) {
		str += '<strong>20</strong> | ';
	} else {
		str += '<a href="#" id = "20PerPage">20</a> | ';
	}
	
	if (params.perPage == 40) {
		str += '<strong>40</strong> | ';
	} else {
		str += '<a href="#" id = "40PerPage">40</a> | ';
	}
	
	if (params.perPage == 50) {
		str += '<strong>50</strong>';
	} else {
		str += '<a href="#" id = "50PerPage">50</a>';
	}
	
	return str;
	
}

function reinitializePagingEvent(data) {
	
	$("#imgFirst").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	$("#imgPrevious").click(function(e) {
		e.preventDefault();
		previousPage = parseInt(data.param.page)-1;
		if (previousPage <= 0) {
			previousPage = data.param.firstPage;
		}
		//loadPopupFadeIn();
		postAndRedrawContent(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	$("#imgNext").click(function(e) {
		
		e.preventDefault();
		nextPage = parseInt(data.param.page)+1;
		if (nextPage >= data.param.totalPages) {
			nextPage = data.param.lastPage;
		}
		//loadPopupFadeIn();
		postAndRedrawContent(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	$("#imgLast").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
}

function reinitializePageCountEvent(data) {
	$("#10PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 10, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	$("#20PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 20, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	$("#40PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 40, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	$("#50PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 50, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
}