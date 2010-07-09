var isMapVisible = 1;

var selectedTopFarmTypeId = "";

var filters = '';

var selectedFarmTypeId = "";
var allFarmTypes;



function postAndRedrawContent(page, perPage, s, o, query, filter) {
	
	var formAction = '/farm/ajaxSearchFarms';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query, f:filter };
	
	$.post(formAction, postArray,function(data) {		
		
		redrawContent(data, filter);
	},
	"json");
	
}

function redrawAllFarmTypes(data, allFarmTypes) {
	$('#divAllFarmTypes').empty();
	
	arrSelectedFarmTypes = new Array();
	j = 0;
	
	var strSelectedFarmTypeId = '';
	if (selectedFarmTypeId != '') {
		strSelectedFarmTypeId = selectedFarmTypeId;
	} else {
		strSelectedFarmTypeId = selectedTopFarmTypeId
	}
	
	if (strSelectedFarmTypeId != '') {
		arrFilter = strSelectedFarmTypeId.split(',');
		
		for(i = 0; i < arrFilter.length; i++ ) {
			arr = arrFilter[i].split('_');
			if (arr[0] == 'f') {
				arrSelectedFarmTypes[j] = arr[1];
				j++;
			}
		}
	}
	
	var resultHtml = '';
	resultHtml = '<strong>Farms Types</strong><br>';
	
	resultHtml += '<table cellpadding = "2" cellspacing = "0" border = "0" width = "500">';
	
	j = 0;
	$.each(allFarmTypes, function(i, a) {
		if (j == 0) {
			resultHtml += '<tr>';
		}
		
		resultHtml += '<td width = "133"><input type="checkbox" value="f_'+ a.farmTypeId + '" id = "farmTypeId" name = "farmTypeId"';
		
		for(i = 0; i < arrSelectedFarmTypes.length; i++ ) {
			if ( arrSelectedFarmTypes[i] ==  a.farmTypeId) {
				resultHtml += ' CHECKED';
				break;
			}
		}
		
		resultHtml += '>';
		
		resultHtml += a.farmType;
		resultHtml += '</td>';
		if (j == 2) {
			resultHtml += '</tr>';
		}
		
		j++;
		if (j == 3) {
			j = 0;
		}
	});
	
	if (j < 3 && j > 0) {
		cellRequired = eval(3-j);
		
		for(i = 1; i<= cellRequired; i++) {
			resultHtml += '<td>&nbsp;</td>';
		}
		resultHtml += '</tr>';
	}
	resultHtml += '<tr><td colspan = "3" align = "right"><a id = "cancelFarmTypeFilter" href = "#">Cancel</a> &nbsp;&nbsp;&nbsp; <input type = "button" id = "btnApplyFarmTypes" value = "Apply Filters"></td></tr>';
	resultHtml += '</table>';
	
	$('#divAllFarmTypes').html(resultHtml);
	
	reinitializePopupFarmTypeEvent(data, allFarmTypes);
}

function reinitializePopupFarmTypeEvent (data, allFarmTypes) {
	//$(':checkbox').click(function () {
	$('#btnApplyFarmTypes').click(function () {
		var strFarmTypeId = '';	
		var strFilters = '';
		j = 0;
		
		$('#divAllFarmTypes :checked').each(function() {
		   if (j == 0 ) {
	        	strFarmTypeId += $(this).val();
	        } else {
	        	strFarmTypeId += ',' + $(this).val();
	        }
	        j++;
		  }
		);
		
		strFilters = strFarmTypeId;
		selectedFarmTypeId = strFarmTypeId;
		selectedTopFarmTypeId = "";
		//disablePopup();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strFilters);
	});
	
	$("#cancelFarmTypeFilter").click(function(e){
		e.preventDefault();
		//disablePopup();
	});
	
}

function redrawTopFarmTypes(data) {
	$('#divFarmTypes').empty();
	
	var resultHtml = '';
	
	if (selectedFarmTypeId != "") {
		
		arrSelectedFarmTypes = new Array();
		j = 0;
		if (filters != '') {
			arrFilter = selectedFarmTypeId.split(',');
			
			for(i = 0; i < arrFilter.length; i++ ) {
				arr = arrFilter[i].split('_');
				if (arr[0] == 'f') {
					arrSelectedFarmTypes[j] = arr[1];
					j++;
				}
			}
		}
		//resultHtml += '<ul>';
		$.each(allFarmTypes, function(i, a) {
			for(i = 0; i < arrSelectedFarmTypes.length; i++ ) {
				if ( arrSelectedFarmTypes[i] ==  a.farmTypeId) {
					resultHtml += '-' + a.farmType + '<br />';
					break;
				}
			}
		});	
		//resultHtml += '</ul>';
		
	} else {
		
		arrTopFilters = new Array();
		j = 0;
		if (filters != '') {
			arrFilter = filters.split(',');
			
			for(i = 0; i < arrFilter.length; i++ ) {
				arr = arrFilter[i].split('_');
				if (arr[0] == 'f') {
					arrTopFilters[j] = arr[1];
					j++;
				}
			}
		}
		
		$.each(topFarmTypes, function(i, a) {
			resultHtml += '<input type="checkbox" value="f_'+ a.farmTypeId + '" id = "farmTypeId" name = "farmTypeId"';
			
			for(i = 0; i < arrTopFilters.length; i++ ) {
				if ( arrTopFilters[i] ==  a.farmTypeId) {
					resultHtml += ' CHECKED';
					break;
				}
			}
			resultHtml += '>';
			
			resultHtml += a.farmType + '<br>';
		});	
	}
	
	//resultHtml += '<br><a href = "#" id = "chooseMoreFarmType" name = "">Choose More...</a><br>';
		
	$('#divFarmTypes').html(resultHtml);
	
	reinitializeMoreFarmType(data);
}

function reinitializeMoreFarmType(data) {
	$("#chooseMoreFarmType").click(function(e){
		e.preventDefault();
		
		var formAction = '/farm/ajaxGetAllFarmType';
		
		postArray = { };

		$.post(formAction, postArray,function(farmTypes) {
			//centerPopup();
			loadPopup();
			allFarmTypes = farmTypes;
			
			redrawAllFarmTypes(data, allFarmTypes);
			$('#popupContact').center();
		},
		"json");
	});
	
	//CLOSING POPUP
	//Click the x event!
	$("#popupClose").click(function(){
		disablePopup();
	});
	
}
		
function redrawZipcodeBox() {
	$('#divZipcode').empty();
	formFilterContent = '<form id = "frmFilters">Zip Code <input type="text" size="6" maxlength="5" id = "q"></form>';
	$('#divZipcode').html(formFilterContent);
}
		
	

function redrawContent(data, filter) {
	
	redrawTopFarmTypes(data);
	
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
	
	if (showFilters ==  true) {
		$('#removeFilters').empty();
		removeFilterContent = '<a id = "imgRemoveFilters" href = "#">Remove Filters</a>';
		$('#removeFilters').append(removeFilterContent);
	}
	
	if (showMap ==  true) { 
		$('#divHideMap').empty();
		showHideMapContent = '<a href = "#" id = "linkHideMap">Show/Hide Map</a>';
		$('#divHideMap').append(showHideMapContent);
	}
	
	redrawZipcodeBox();
	
	$("#q").val(data.param.q);
	
	//$('#table_results tbody tr td a').click(function(e) {
	$('#resultTableContainer div div a').click(function(e) {
		record_id = $(this).attr('id');
		
		if (record_id != '') {
			if (isNaN(record_id) ) {
				e.preventDefault();
				var arr = record_id.split('_');
				record_id = arr[1];
				
				viewMarker(record_id);
			} else {
				document.location='/farm/view/'+record_id;
			}
		}
		
	});
	
	if (showMap ==  true) { 
		reinitializeMap(data, data.param.zoomLevel);
	}
	
	reinitializePagingEvent(data);
	
	reinitializePageCountEvent(data);
	
	if (showFilters ==  true) {
		reinitializeRemoveFilters(data);
	}
	
	reinitializeFilterEvent(data);
	
	reinitializeQueryFilterEvent(data);
	
	reinitializeShowHideMap(data);
	
	//disablePopupFadeIn();
}

function addZeroResult() {
	var html =
	'<div style="overflow:auto; padding:5px;">' +
	'	<div style="float:left; width:700px;" align = "center">No results found. Please retry with some other filter options...</div>' + 
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

function reinitializeFilterEvent (data) {
	
	var strFilters = '';
	var strCuisineFilters = '';
	var strFarmTypeFilters = '';
	
	$(':checkbox').click(function () {
		
		j = 0;
		i = 0;
		$('#divFarmTypes :checked').each(function() {
		   if (j == 0 ) {
	        	strFilters += $(this).val();
	        } else {
	        	strFilters += ',' + $(this).val();
	        }
	        j++;
	        
	        if (i == 0 ) {
	        	strFarmTypeFilters = $(this).val();
	        } else {
	        	strFarmTypeFilters += ',' + $(this).val();
	        }
	        i++;
	        
		  }
		);
		
		if (strFarmTypeFilters != '') {
			selectedTopFarmTypeId = strFarmTypeFilters;
			selectedFarmTypeId = '';
		}
		
		
		if (selectedFarmTypeId != '') {
			if (strFilters != '') {
				strFilters = strFilters + ',' + selectedFarmTypeId;
			} else {
				strFilters = selectedFarmTypeId;
			}
		}
		
		if (strFilters != '') {
			filters = strFilters;
		}
		
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strFilters);
	});
}


function reinitializeQueryFilterEvent (data) {
	
	$("#frmFilters").submit(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, $("#q").val(), data.param.filter);
	});
}


function reinitializeRemoveFilters(data) {
	
	$("#imgRemoveFilters").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		
		selectedCuisineId = '';
		selectedFarmTypeId = '';
		
		selectedTopCuisineId = "";
		selectedTopFarmTypeId = "";
		
		filters = '';

		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, '', '');
		$('#frmFilters')[0].reset();
	});
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


function addResult(farm, i) {
	var html =
	'<div style="overflow:auto; padding:5px;">' +
	'	<div style="float:left; width:300px;"><a href="/farm/view/' + farm.farmId + '" id = "'+ farm.farmId +'">'+ farm.farmName +'</a><br>Type:' + farm.farmType;
	
	html += '</div>' + 
	'	<div style="float:right; width:400px;">Address:<br />';
	$.each(farm.addresses, function(j, address) {
		if (j == 0) {
			html += '<a href="#" id = "map_'+ address.addressId +'"><em>' + address.completeAddress + '</em></a>';
		} else {
			html += "<br /><br />" + '<a href="#" id = "map_'+ address.addressId +'"><em>' + address.completeAddress + '</em></a>';
		}
	});
	html += '</div>';
	html +=
	'</div>'
	;
	
	return html;
}

function getMarkerHtml(o) {
	html = "<font size = '2'><b><i>" + o.farmName + "</i></b></font><br /><font size = '1'>" +
		  o.addressLine1 + "<br />" + 
		  o.addressLine2 + "<br />" + 
		  o.addressLine3 + "</font><br />"
		  ;
	return html;
}