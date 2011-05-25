
function postAndRedrawContent(page, perPage, s, o, query, filter, type) {
	var formAction;
	if (type == 'menu') {
		formAction = '/user/ajaxMenuByUser';
	} else if (type == 'supplier') {
		formAction = '/user/ajaxSuppliersByUser';
	} else if (type == 'comment') {
		formAction = '/user/ajaxCommentByUser';
	} else if (type == 'restaurants') {
		formAction = '/user/ajaxRestaurantsByUser';
	}
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:userId, f:filter };
	
	$.post(formAction, postArray,function(data) {		
		jsonData = data;
		currentContent = type;
		
		redrawContent(data, type);
	},
	"json");
}

function addZeroResult(type) {
	var html =
	'<div style="overflow:auto; width:785px; padding:0px; clear:left; margin-right:10px; padding-bottom:10px;" align = "center">' +
	'	<div style="float:left; clear:left;padding-left:3px; padding-right:10px;font-size:13px;">';
	
	html += 'You have not contributed any informationt to the site. All viewers of the site may also update data like Wikipedia. Feel free to do add ';
	
	if (type == 'supplier') {
		html += 'suppliers';
	} else if (type == 'menu') {
		html += 'products';
	} else if (type == 'restaurants') {
		html += 'restaurants';
	}
	html += '.';
	html +='</div>' + 
	'</div>'
	;	
	return html;
}

function redrawContent(data, type) {
	
	$('#resultTableContainer').empty();
	var resultTableHtml = '';
	
	if (data.param.numResults == 0) {
		resultTableHtml += addZeroResult(type);
	} else {
		if (type == 'supplier') {
			$.each(data.results, function(i, a) {
				resultTableHtml += addSupplierResult(a, i);
			});
		} else if (type == 'menu') {
			$.each(data.results, function(i, a) {
				resultTableHtml += addMenuResult(a, i);
			});
		} else if (type == 'comment') {
			$.each(data.results, function(i, a) {
				resultTableHtml += addCommentResult(a, i);
			});
		} else if (type == 'restaurants') {
			
			$.each(data.results, function(i, a) {
				resultTableHtml += addRestaurantResult(a, i);
			});
		
		} else if (type == 'farm') {
			$.each(data.results, function(i, a) {
				resultTableHtml += addFarmResult(a, i);
			});
		}
	}
	
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

function reinitializePagingEvent(data) {
	$("#imgFirst").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#imgPrevious").click(function(e) {
		e.preventDefault();
		previousPage = parseInt(data.param.page)-1;
		if (previousPage <= 0) {
			previousPage = data.param.firstPage;
		}
		//loadPopupFadeIn();
		postAndRedrawContent(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#imgNext").click(function(e) {
		e.preventDefault();
		nextPage = parseInt(data.param.page)+1;
		if (nextPage >= data.param.totalPages) {
			nextPage = data.param.lastPage;
		}
		//loadPopupFadeIn();
		postAndRedrawContent(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#imgLast").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
}

function reinitializePageCountEvent(data) {
	$("#10PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 10, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#20PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 20, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#40PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 40, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#50PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 50, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
}