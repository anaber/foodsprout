function redrawContent(data) {
	$('#resultTableContainer').empty();
	var resultTableHtml = getResultTableHeader();
	//var resultTableHtml = '';
	$.each(data.results, function(i, a) {
		resultTableHtml += addResult(a, i);
	});	
	
	resultTableHtml += getResultTableFooter();
	$('#resultTableContainer').append(resultTableHtml);
	
	$('#messageContainer').hide();
	$('#resultsContainer').show();
	
	
	$('#numRecords').empty();
	numRecordsContent = drawNumRecords(data.param);			
	$('#numRecords').append(numRecordsContent);
	
	$('#recordsPerPage').empty();
	recordsPerPageContent = drawRecordsPerPage(data.param);
	$('#recordsPerPage').append(recordsPerPageContent);
	
	$('#pagingLinks').empty();
	pagingLinksContent = drawPagingLinks(data.param);
	$('#pagingLinks').append(pagingLinksContent);
	
	//$('#searchBox').empty();
	//searchBoxContent = drawSearchBox(data.param);
	//$('#searchBox').append(searchBoxContent);
	
	
	reinitializePagingEvent(data);
	
	reinitializePageCountEvent(data);
	
	reinitializeTableHeadingEvent(data);
	
	$("#tbllist").colorize( { ignoreHeaders:true });
}

function reinitializePagingEvent(data) {
	
	$("#imgFirst").click(function(e) {
		e.preventDefault();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q);
	});
	
	$("#imgPrevious").click(function(e) {
		e.preventDefault();
		previousPage = parseInt(data.param.page)-1;
		if (previousPage <= 0) {
			previousPage = data.param.firstPage;
		}
		postAndRedrawContent(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q);
	});
	
	$("#imgNext").click(function(e) {
		e.preventDefault();
		nextPage = parseInt(data.param.page)+1;
		if (nextPage >= data.param.totalPages) {
			nextPage = data.param.lastPage;
		}
		postAndRedrawContent(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q);
	});
	
	$("#imgLast").click(function(e) {
		e.preventDefault();
		postAndRedrawContent(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q);
	});
	
}

function reinitializePageCountEvent(data) {
	$("#recordsPerPageList").change(function(e) {
		postAndRedrawContent(data.param.firstPage, $("#recordsPerPageList").val(), data.param.sort, data.param.order, data.param.q);
	});
}

function getOrder(data, field_name ) {
	var order = 'ASC';
	
	if (data.param.sort == field_name) {
		if (data.param.order == 'ASC') {
			order = 'DESC';
		} else {
			order = 'ASC';
		}
	}
	return order;
}

function drawRecordsPerPage(params) {
	str = '';
	str += '<select id = "recordsPerPageList">';
	str += '<option value = "">--Per Page--</option>';
	for(i = 10; i <= 100; i+=10) {
		str += '<option value = "' + i + '"';
		if (i == params.perPage) {
			str += ' SELECTED'
		}
		str += '>'+i+'</option>';
	}
	str += '</select>';

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

function drawSearchBox(params) {
	str = '';
	str += '<input type = "text" name = "q" id = "q" size = "30">';
	return str;
}

function drawNumRecords(params) {
	str = 'Viewing records ' + params.start + '-' + params.end + ' of ' + params.numResults;
	return str;
}

function getResultTableFooter() {
	var html = 
	'</tbody>' +
	'</table>';
	return html;
}


