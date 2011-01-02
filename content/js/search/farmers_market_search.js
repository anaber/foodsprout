var isMapVisible = 1;

function postAndRedrawContent(page, perPage, s, o, query, filter, radius) {
	
	var formAction = '/farmersmarket/ajaxSearchFarmersMarket';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query, f:filter, r:radius };
	
	$.post(formAction, postArray,function(data) {		
		farmersMarketData = data;
		redrawContent(data);
	},
	"json");
	
}

function redrawZipcodeBox() {
	$('#divZipcode').empty();
	formFilterContent = '<form id = "frmFilters">Zip Code <input type="text" size="6" maxlength="5" id = "q"></form>';
	$('#divZipcode').html(formFilterContent);
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
	
	//alert(resultTableHtml);
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
	
	if (showMap ==  true) { 
		$('#divHideMap').empty();
		showHideMapContent = '<a href = "#" id = "linkHideMap">Show/Hide Map</a>';
		$('#divHideMap').append(showHideMapContent);
	}
	
	redrawZipcodeBox();
	$( "#slider" ).slider( "value", data.param.radius );
	$("#radius").html( $("#slider").slider("value") + ' miles' );
	
	$("#q").val(data.param.q);
	
	//$('#table_results tbody tr td a').click(function(e) {
	$('#resultTableContainer div div a').click(function(e) {
		record_id = $(this).attr('id');
		
		if (record_id != '') {
			if (isNaN(record_id) ) {
				e.preventDefault();
				var arr = record_id.split('_');
				record_id = arr[1];
				
				viewMarker(record_id, 1);
				//$('html, body').animate({scrollTop:0}, 'slow');
				$('html, body').scrollTop(0);
			} else {
				document.location='/farmersmarket/view/'+record_id;
			}
		}
		
	});
	
	if (showMap ==  true) { 
		reinitializeMap(data, data.param.zoomLevel);
	}
	
	reinitializePagingEvent(data);
	
	reinitializePageCountEvent(data);
	
	reinitializeQueryFilterEvent(data);
	
	reinitializeShowHideMap(data);
	
	
	//disablePopupFadeIn();
}

function addZeroResult() {
	var html =
	'<div style="overflow:auto; padding:0px; clear:left; margin-right:10px; padding-bottom:10px;" align = "center">' +
	'	<div style="float:left; width:600px; clear:left;padding-left:3px; padding-right:10px;font-size:13px;">No results found. Please retry with some other filter options.</div>' + 
	'</div>'
	;	
	return html;
}

function reinitializeShowHideMap(data) {
	$("#linkHideMap").click(function(e) {
		
		e.preventDefault();
		
		var $map = $('#map');
		if (isMapVisible == 1) {
			$map.hide(800);
			isMapVisible = 0;
		} else {
			$map.show(800);
			isMapVisible = 1;
		}
	});
}


function reinitializeQueryFilterEvent (data) {
	
	$("#frmFilters").submit(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, $("#q").val(), data.param.filter, data.param.radius);
	});
}

function reinitializeRadiusSearch () {
	$( "#slider" ).slider({
   		stop: function(event, ui) { 
   			data = farmersMarketData;
   			postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, $("#slider").slider("value") );
   		}
	});
}

function reinitializePagingEvent(data) {
	
	$("#imgFirst").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
	});
	
	$("#imgPrevious").click(function(e) {
		e.preventDefault();
		previousPage = parseInt(data.param.page)-1;
		if (previousPage <= 0) {
			previousPage = data.param.firstPage;
		}
		//loadPopupFadeIn();
		postAndRedrawContent(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
	});
	
	$("#imgNext").click(function(e) {
		e.preventDefault();
		nextPage = parseInt(data.param.page)+1;
		if (nextPage >= data.param.totalPages) {
			nextPage = data.param.lastPage;
		}
		//loadPopupFadeIn();
		postAndRedrawContent(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
	});
	
	$("#imgLast").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
	});
	
}

function reinitializePageCountEvent(data) {
	$("#10PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 10, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
	});
	
	$("#20PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 20, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
	});
	
	$("#40PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 40, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
	});
	
	$("#50PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 50, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
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


function addResult(farmersMarket, i) {
	var html =
	'<div style="overflow:auto; padding:0px; clear:left; width:610px; margin-right:10px; padding-bottom:10px;">' +
	'	<div style="float:left; clear:both; padding:3px; width:600px; background:#e5e5e5; font-weight:bold;"><a href="/farmersmarket/view/' + farmersMarket.farmersMarketId + '" id = "'+ farmersMarket.farmersMarketId +'" style="text-decoration:none;">'+ farmersMarket.farmersMarketName +'</a>';
	
	html += '</div>' + 
	'	<div style="float:left; width:60px;font-size:13px;"><b>Address:</b></div><div style="float:left; width:340px;font-size:13px;">';
	$.each(farmersMarket.addresses, function(j, address) {
		if (j == 0) {
			html += '<a href="#" id = "map_'+ address.addressId +'" style="font-size:13px;text-decoration:none;">' + address.displayAddress + '</a>';
		} else {
			html += "<br /><br />" + '<a href="#" id = "map_'+ address.addressId +'" style="font-size:13px;text-decoration:none;">' + address.displayAddress + '</a>';
		}
	});
	
	html += '</div>';
	html +=
	'</div>'
	;
	
	return html;
}

function getMarkerHtml(o) {
	html = "<font size = '2'><b><i>" + o.farmersMarketName + "</i></b></font><br /><font size = '1'>" +
		  o.addressLine1 + "<br />" + 
		  o.addressLine2 + "<br />" + 
		  o.addressLine3 + "</font><br />"
		  ;
	return html;
}