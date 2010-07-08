function postAndRedrawContent(page, perPage, s, o, query, filter) {
	
	var formAction = '/state/ajaxSearchStates';
	postArray = {  };
	
	$.post(formAction, postArray,function(data) {
		
		var formAction = '/manufacture/ajaxSearchManufactures';
	
		postArray = { p:page, pp:perPage, sort:s, order:o, q:query, f:filter };
		
		$.post(formAction, postArray,function(data2) {		
			dataManufactures = data2;
			redrawContent(data2, data);
		},
		"json");
	},
	"json");
}

function redrawContent(data, states) {
	
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
	$('html, body').animate({scrollTop:0}, 'slow');
	
	$('#numRecords').empty();
	numRecordsContent = drawNumRecords(data.param);			
	$('#numRecords').append(numRecordsContent);
	
	$('#recordsPerPage').empty();
	recordsPerPageContent = drawRecordsPerPage(data.param);
	$('#recordsPerPage').append(recordsPerPageContent);
	
	$('#pagingLinks').empty();
	pagingLinksContent = drawPagingLinks(data.param);
	$('#pagingLinks').append(pagingLinksContent);
	
	//redrawFilterBox(data, states);
	
	reinitializePagingEvent(data);
	
	reinitializePageCountEvent(data);
	
	//reinitializeFilterEvent(data);
	
	//disablePopupFadeIn();
	
	if (data.param.filter) {
		$('#stateId').val(data.param.filter);
	} else  {
		$('#stateId').val('');
	}
	
	if (data.param.q) {
		//$('#suggestion_box').val(data.param.q);
	} else  {
		$('#suggestion_box').val('');
	}
	
}

function redrawFilterBox(data, states) {
	
	$('#divFilters').empty();
	filterContent = 
		'State '+
		'<select name="stateId" id="stateId">'+
		'<option value = "">--State--</option>'+
		'</select>';
	$('#divFilters').html(filterContent);
	
	$('#stateId')
		.find('option')
	    .remove();
	$('#stateId').append($("<option></option>").attr("value", '').text('--State--'));
	$.each(states, function(i, a) {
		$('#stateId').append($("<option></option>").attr("value",a.stateId).text(a.stateName));
	});

	$("#suggestion_box").val(data.param.q);
	
	if (data.param.filter) {
		$('#stateId').val(data.param.filter);
	}
}

function reinitializeFilterEvent (data) {
	
	$("#stateId").change(function () {
		stateId = $("#stateId").val();
		
		if ( stateId != '' ) {
			//strFilter = 's__' + stateId;
			//$("#selectedStateId").val(stateId);
			
			//loadPopupFadeIn();
			postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, '', stateId);
		}
	});
	
	/*
	$("#suggestion_box").keyup(function() {
		q = $("#suggestion_box").val();
			
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, q, data.param.filter);
	});
	*/
	
	
}



function addResult(manufacture, count) {
	var html =
	'<div style="overflow:auto; padding:5px;">' +
	'	<div style="float:left; width:300px;"><a href="/manufacture/view/' + manufacture.manufactureId + '" id = "'+ manufacture.manufactureId +'">'+ manufacture.manufactureName +'</a><br>Type: '+ manufacture.manufactureType + '</div>' +
	'	<div style="float:right; width:400px;">Address:<br />';
	
	$.each(manufacture.addresses, function(j, address) {
		if (j == 0) {
			html += '<a href="#" id = "map_'+ address.addressId +'"><em>' + address.displayAddress + '</em></a>';
		} else {
			html += "<br /><br />" + '<a href="#" id = "map_'+ address.addressId +'"><em>' + address.displayAddress + '</em></a>';
		}
	});
	
	html += '</div>';
	html +=
	'</div>'
	;
	
	return html;
}

function addZeroResult() {
	var html =
	'<div style="overflow:auto; padding:5px;">' +
	'	<div style="float:left; width:700px;" align = "center">No results found. Please retry with some other filter options...</div>' + 
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