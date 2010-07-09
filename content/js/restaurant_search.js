var isMapVisible = 1;

var selectedTopCuisineId = "";
var selectedTopRestaurantTypeId = "";

var filters = '';

var selectedCuisineId = "";
var selectedRestaurantTypeId = "";
var allCuisines;
var allRestaurantTypes;



function postAndRedrawContent(page, perPage, s, o, query, filter) {
	
	//$('#resultsContainer').hide();
	//$('#messageContainer').show();
	//$('#messageContainer').addClass('center').html('<img src="/images/loading_pink_bar.gif" />');
	
	var formAction = '/restaurant/ajaxSearchRestaurants';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query, f:filter };
	
	$.post(formAction, postArray,function(data) {		
		
		redrawContent(data, filter);
		
		//reinitializeRemoveFilters(data);
	},
	"json");
	
}

function redrawAllCuisines(data, allCuisines) {
	$('#divAllCuisines').empty();
	$('#divAllRestaurantTypes').empty();
		
	// TO-DO - work here
	
	arrSelectedCuisines = new Array();
	j = 0;
	/*
	if (selectedCuisineId != '') {
		strSelectedCuisineId = selectedCuisineId;
	}
	*/
	var strSelectedCuisineId = '';
	if (selectedCuisineId != '') {
		strSelectedCuisineId = selectedCuisineId;
	} else {
		strSelectedCuisineId = selectedTopCuisineId
	}
	
	if (strSelectedCuisineId != '') {
		arrFilter = strSelectedCuisineId.split(',');
		
		for(i = 0; i < arrFilter.length; i++ ) {
			arr = arrFilter[i].split('_');
			if (arr[0] == 'c') {
				arrSelectedCuisines[j] = arr[1];
				j++;
			}
		}
	}
	
	var resultHtml = '';
	resultHtml = '<strong>Cuisines</strong><br>';
	
	resultHtml += '<table cellpadding = "2" cellspacing = "0" border = "0" width = "500">';
	
	j = 0;
	$.each(allCuisines, function(i, a) {
		if (j == 0) {
			resultHtml += '<tr>';
		}
		
		resultHtml += '<td width = "133"><input type="checkbox" value="c_'+ a.cuisineId + '" id = "cuisineId" name = "cuisineId"';
		
		for(i = 0; i < arrSelectedCuisines.length; i++ ) {
			if ( arrSelectedCuisines[i] ==  a.cuisineId) {
				resultHtml += ' CHECKED';
				break;
			}
		}
		
		resultHtml += '>';
		
		resultHtml += a.cuisineName;
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
	resultHtml += '<tr><td colspan = "3" align = "right"><a id = "cancelCuisineFilter" href = "#">Cancel</a> &nbsp;&nbsp;&nbsp; <input type = "button" id = "btnApplyCuisines" value = "Apply Filters"></td></tr>';
	resultHtml += '</table>';
	
	
	$('#divAllCuisines').html(resultHtml);
	
	//reinitializeMoreCuisine();
	reinitializePopupCuisineEvent(data, allCuisines);
}

function redrawTopCuisines(data) {
	$('#divCuisines').empty();
	
	var resultHtml = '';
	
	if (selectedCuisineId != "") {
		
		arrSelectedCuisines = new Array();
		j = 0;
		if (filters != '') {
			arrFilter = selectedCuisineId.split(',');
			
			for(i = 0; i < arrFilter.length; i++ ) {
				arr = arrFilter[i].split('_');
				if (arr[0] == 'c') {
					arrSelectedCuisines[j] = arr[1];
					j++;
				}
			}
		}
		//resultHtml += '<ul>';
		$.each(allCuisines, function(i, a) {
			for(i = 0; i < arrSelectedCuisines.length; i++ ) {
				if ( arrSelectedCuisines[i] ==  a.cuisineId) {
					resultHtml += '-' + a.cuisineName + '<br />';
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
				if (arr[0] == 'c') {
					arrTopFilters[j] = arr[1];
					j++;
				}
			}
		}
		
		$.each(topCuisines, function(i, a) {
			resultHtml += '<input type="checkbox" value="c_'+ a.cuisineId + '" id = "cuisineId" name = "cuisineId"';
			
			for(i = 0; i < arrTopFilters.length; i++ ) {
				if ( arrTopFilters[i] ==  a.cuisineId) {
					resultHtml += ' CHECKED';
					break;
				}
			}
			resultHtml += '>';
			
			resultHtml += a.cuisineName + '<br>';
		});	
	}
	
	resultHtml += '<br><a href = "#" id = "chooseMoreCuisine" name = "">Choose More...</a><br>';
		
	$('#divCuisines').html(resultHtml);
	
	reinitializeMoreCuisine(data);
}

function reinitializeMoreCuisine(data) {
	$("#chooseMoreCuisine").click(function(e){
		e.preventDefault();
		
		var formAction = '/restaurant/ajaxGetAllCuisine';
		postArray = { };
		
		$.post(formAction, postArray,function(cuisines) {		
			//centerPopup();
			loadPopup();
			allCuisines = cuisines;
			
			//redrawAllCuisines(data, allCuisines, topCuisines);
			redrawAllCuisines(data, allCuisines);
			$('#popupContact').center();
		},
		"json");
	});
	
	//CLOSING POPUP
	//Click the x event!
	$("#popupClose").click(function(){
		disablePopup();
	});
	
	
	/*
	//Click out event!
	$("#backgroundPopup").click(function(){
		disablePopup();
	});
	
	//Press Escape event!
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupStatus==1){
			disablePopup();
		}
	});
	*/
}



function redrawAllRestaurantTypes(data, allRestaurantTypes) {
	$('#divAllCuisines').empty();
	$('#divAllRestaurantTypes').empty();
	
	// TO-DO - work here
	
	arrSelectedRestaurantTypes = new Array();
	j = 0;
	
	var strSelectedRestaurantTypeId = '';
	if (selectedRestaurantTypeId != '') {
		strSelectedRestaurantTypeId = selectedRestaurantTypeId;
	} else {
		strSelectedRestaurantTypeId = selectedTopRestaurantTypeId
	}
	
	if (strSelectedRestaurantTypeId != '') {
		arrFilter = strSelectedRestaurantTypeId.split(',');
		
		for(i = 0; i < arrFilter.length; i++ ) {
			arr = arrFilter[i].split('_');
			if (arr[0] == 'r') {
				arrSelectedRestaurantTypes[j] = arr[1];
				j++;
			}
		}
	}
	
	var resultHtml = '';
	resultHtml = '<strong>Restaurants Types</strong><br>';
	
	resultHtml += '<table cellpadding = "2" cellspacing = "0" border = "0" width = "500">';
	
	j = 0;
	$.each(allRestaurantTypes, function(i, a) {
		if (j == 0) {
			resultHtml += '<tr>';
		}
		
		resultHtml += '<td width = "133"><input type="checkbox" value="r_'+ a.restaurantTypeId + '" id = "restaurantTypeId" name = "restaurantTypeId"';
		
		for(i = 0; i < arrSelectedRestaurantTypes.length; i++ ) {
			if ( arrSelectedRestaurantTypes[i] ==  a.restaurantTypeId) {
				resultHtml += ' CHECKED';
				break;
			}
		}
		
		resultHtml += '>';
		
		resultHtml += a.restaurantTypeName;
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
	resultHtml += '<tr><td colspan = "3" align = "right"><a id = "cancelRestaurantTypeFilter" href = "#">Cancel</a> &nbsp;&nbsp;&nbsp; <input type = "button" id = "btnApplyRestaurantTypes" value = "Apply Filters"></td></tr>';
	resultHtml += '</table>';
	
	$('#divAllRestaurantTypes').html(resultHtml);
	
	//reinitializeMoreCuisine();
	reinitializePopupRestaurantTypeEvent(data, allRestaurantTypes);
}

function reinitializePopupRestaurantTypeEvent (data, allRestaurantTypes) {
	
	
	
	//$(':checkbox').click(function () {
	$('#btnApplyRestaurantTypes').click(function () {
		var strRestaurantTypeId = '';	
		var strFilters = '';
		j = 0;
		
		$('#divAllRestaurantTypes :checked').each(function() {
		   if (j == 0 ) {
	        	strRestaurantTypeId += $(this).val();
	        } else {
	        	strRestaurantTypeId += ',' + $(this).val();
	        }
	        j++;
		  }
		);
		//alert("From line 3682: " + strRestaurantTypeId);
		
		
		if (selectedTopCuisineId != '') {
			if (strRestaurantTypeId != '') {
				strFilters = strRestaurantTypeId + ',' + selectedTopCuisineId;
			} else {
				strFilters = selectedTopCuisineId;
			}
		} else if (selectedCuisineId != '') {
			if (strRestaurantTypeId != '') {
				strFilters = strRestaurantTypeId + ',' + selectedCuisineId;
			} else {
				strFilters = selectedCuisineId;
			}
		} else {
			strFilters = strRestaurantTypeId;
		}
		
		selectedRestaurantTypeId = strRestaurantTypeId;
		selectedTopRestaurantTypeId = "";
		disablePopup();
		loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strFilters);
	});
	
	$("#cancelRestaurantTypeFilter").click(function(e){
		e.preventDefault();
		disablePopup();
	});
	
}

function redrawTopRestaurantTypes(data) {
	$('#divRestaurantTypes').empty();
	
	var resultHtml = '';
	
	if (selectedRestaurantTypeId != "") {
		
		arrSelectedRestaurantTypes = new Array();
		j = 0;
		if (filters != '') {
			arrFilter = selectedRestaurantTypeId.split(',');
			
			for(i = 0; i < arrFilter.length; i++ ) {
				arr = arrFilter[i].split('_');
				if (arr[0] == 'r') {
					arrSelectedRestaurantTypes[j] = arr[1];
					j++;
				}
			}
		}
		//resultHtml += '<ul>';
		$.each(allRestaurantTypes, function(i, a) {
			for(i = 0; i < arrSelectedRestaurantTypes.length; i++ ) {
				if ( arrSelectedRestaurantTypes[i] ==  a.restaurantTypeId) {
					resultHtml += '-' + a.restaurantTypeName + '<br />';
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
				if (arr[0] == 'r') {
					arrTopFilters[j] = arr[1];
					j++;
				}
			}
		}
		
		$.each(topRestaurantTypes, function(i, a) {
			resultHtml += '<input type="checkbox" value="r_'+ a.restaurantTypeId + '" id = "restaurantTypeId" name = "restaurantTypeId"';
			
			for(i = 0; i < arrTopFilters.length; i++ ) {
				if ( arrTopFilters[i] ==  a.restaurantTypeId) {
					resultHtml += ' CHECKED';
					break;
				}
			}
			resultHtml += '>';
			
			resultHtml += a.restaurantType + '<br>';
		});	
	}
	
	resultHtml += '<br><a href = "#" id = "chooseMoreRestaurantType" name = "">Choose More...</a><br>';
		
	$('#divRestaurantTypes').html(resultHtml);
	
	reinitializeMoreRestaurantType(data);
}

function reinitializeMoreRestaurantType(data) {
	$("#chooseMoreRestaurantType").click(function(e){
		e.preventDefault();
		
		var formAction = '/restaurant/ajaxGetAllRestaurantType';
		
		postArray = { };

		$.post(formAction, postArray,function(restaurantTypes) {	
			//centerPopup();
			loadPopup();
			allRestaurantTypes = restaurantTypes;
			
			redrawAllRestaurantTypes(data, allRestaurantTypes);
			$('#popupContact').center();
		},
		"json");
	});
	
	//CLOSING POPUP
	//Click the x event!
	$("#popupClose").click(function(){
		disablePopup();
	});
	
	
	/*
	//Click out event!
	$("#backgroundPopup").click(function(){
		disablePopup();
	});
	
	//Press Escape event!
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupStatus==1){
			disablePopup();
		}
	});
	*/
}
		
function redrawZipcodeBox() {
	$('#divZipcode').empty();
	formFilterContent = '<form id = "frmFilters">Zip Code <input type="text" size="6" maxlength="5" id = "q"></form>';
	$('#divZipcode').html(formFilterContent);
}
		
	

function redrawContent(data, filter) {
	
	redrawTopRestaurantTypes(data);
	redrawTopCuisines(data);
	
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
				document.location='/restaurant/view/'+record_id;
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
	
	//reinitializeTableHeadingEvent(data);
	
	reinitializeFilterEvent(data);
	
	reinitializeQueryFilterEvent(data);
	
	reinitializeShowHideMap(data);
	
	
	
	//$("#table_results").colorize( { ignoreHeaders:true });
	disablePopupFadeIn();
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
	var strRestaurantTypeFilters = '';
	
	$(':checkbox').click(function () {
		
		j = 0;
		i = 0;
		$('#divRestaurantTypes :checked').each(function() {
		   if (j == 0 ) {
	        	strFilters += $(this).val();
	        } else {
	        	strFilters += ',' + $(this).val();
	        }
	        j++;
	        
	        if (i == 0 ) {
	        	strRestaurantTypeFilters = $(this).val();
	        } else {
	        	strRestaurantTypeFilters += ',' + $(this).val();
	        }
	        i++;
	        
		  }
		);

		i = 0;
		$('#divCuisines :checked').each(function() {
		   if (j == 0 ) {
	        	strFilters += $(this).val();
	        } else {
	        	strFilters += ',' + $(this).val();
	        }
	        j++;
		  
		  
			if (i == 0 ) {
	        	strCuisineFilters = $(this).val();
	        } else {
	        	strCuisineFilters += ',' + $(this).val();
	        }
	        i++;
		  }
		  
		);
		
		//alert("From line 294: " + strRestaurantTypeId);
		//alert(strFilters);
		
		if (strRestaurantTypeFilters != '') {
			selectedTopRestaurantTypeId = strRestaurantTypeFilters;
			selectedRestaurantTypeId = '';
		}
		
		if (strCuisineFilters != '') {
			selectedTopCuisineId = strCuisineFilters;
			selectedCuisineId = '';
		}
		
		if (selectedCuisineId != '') {
			if (strFilters != '') {
				strFilters = strFilters + ',' + selectedCuisineId;
			} else {
				strFilters = selectedCuisineId;
			}
		} 
		
		if (selectedRestaurantTypeId != '') {
			if (strFilters != '') {
				strFilters = strFilters + ',' + selectedRestaurantTypeId;
			} else {
				strFilters = selectedRestaurantTypeId;
			}
		}
		
		if (strFilters != '') {
			filters = strFilters;
		}
		
		loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strFilters);
	});
}

function reinitializePopupCuisineEvent (data, allCuisines) {
	
	
	
	//$(':checkbox').click(function () {
	$('#btnApplyCuisines').click(function () {
		var strCuisineId = '';	
		var strFilters = '';
		j = 0;
		
		$('#divAllCuisines :checked').each(function() {
		   if (j == 0 ) {
	        	strCuisineId += $(this).val();
	        } else {
	        	strCuisineId += ',' + $(this).val();
	        }
	        j++;
		  }
		);
		//alert("From line 368: " + strCuisineId);
		
		
		if (selectedTopRestaurantTypeId != '') {
			if (strCuisineId != '') {
				strFilters = strCuisineId + ',' + selectedTopRestaurantTypeId;
			} else {
				strFilters = selectedTopRestaurantTypeId;
			}
		} else if (selectedRestaurantTypeId != '') {
			if (strCuisineId != '') {
				strFilters = strCuisineId + ',' + selectedRestaurantTypeId;
			} else {
				strFilters = selectedRestaurantTypeId;
			}
		} else {
			strFilters = strCuisineId;
		}
		
		selectedCuisineId = strCuisineId;
		selectedTopCuisineId = "";
		disablePopup();
		loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strFilters);
	});
	
	$("#cancelCuisineFilter").click(function(e){
		e.preventDefault();
		disablePopup();
	});
	
}



function reinitializeQueryFilterEvent (data) {
	
	$("#frmFilters").submit(function(e) {
		e.preventDefault();
		loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, $("#q").val(), data.param.filter);
	});
}


function reinitializeRemoveFilters(data) {
	
	$("#imgRemoveFilters").click(function(e) {
		e.preventDefault();
		loadPopupFadeIn();
		
		selectedCuisineId = '';
		selectedRestaurantTypeId = '';
		
		selectedTopCuisineId = "";
		selectedTopRestaurantTypeId = "";
		
		filters = '';

		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, '', '');
		$('#frmFilters')[0].reset();
	});
}


function reinitializePagingEvent(data) {
	
	$("#imgFirst").click(function(e) {
		e.preventDefault();
		loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	$("#imgPrevious").click(function(e) {
		e.preventDefault();
		previousPage = parseInt(data.param.page)-1;
		if (previousPage <= 0) {
			previousPage = data.param.firstPage;
		}
		loadPopupFadeIn();
		postAndRedrawContent(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	$("#imgNext").click(function(e) {
		e.preventDefault();
		nextPage = parseInt(data.param.page)+1;
		if (nextPage >= data.param.totalPages) {
			nextPage = data.param.lastPage;
		}
		loadPopupFadeIn();
		postAndRedrawContent(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	$("#imgLast").click(function(e) {
		e.preventDefault();
		loadPopupFadeIn();
		postAndRedrawContent(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
}

function reinitializePageCountEvent(data) {
	$("#10PerPage").click(function(e) {
		e.preventDefault();
		loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 10, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	$("#20PerPage").click(function(e) {
		e.preventDefault();
		loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 20, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	$("#40PerPage").click(function(e) {
		e.preventDefault();
		loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 40, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	$("#50PerPage").click(function(e) {
		e.preventDefault();
		loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 50, data.param.sort, data.param.order, data.param.q, data.param.filter);
	});
	
	/*
	$("#recordsPerPageList").change(function(e) {
		postAndRedrawContent(data.param.firstPage, $("#recordsPerPageList").val(), data.param.sort, data.param.order, data.param.q, data.param.filter, restaurantTypes, cuisines);
	});
	*/
}

/*
function reinitializeTableHeadingEvent(data) {
	$("#heading_restaurant").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'restaurant_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'restaurant_name', order, data.param.q, data.param.filter);
	});
}
*/


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
	
	/*
	str += '<select id = "recordsPerPageList">';
	str += '<option value = "">--Per Page--</option>';
	for(i = 10; i <= 50; i+=10) {
		str += '<option value = "' + i + '"';
		if (i == params.perPage) {
			str += ' SELECTED'
		}
		str += '>'+i+'</option>';
	}
	str += '</select>';
	*/
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


function addResult(restaurant, i) {
	var html =
	'<div style="overflow:auto; padding:5px;">' +
	'	<div style="float:left; width:300px;"><a href="/restaurant/view/' + restaurant.restaurantId + '" id = "'+ restaurant.restaurantId +'">'+ restaurant.restaurantName +'</a><br>Cuisine:';
	
	$.each(restaurant.cuisines, function(j, cuisine) {
		if (j == 0) {
			html += cuisine.cuisine;
		} else {
			html += ",&nbsp;" + cuisine.cuisine;
		}
	});
	
	html += '</div>' + 
	'	<div style="float:right; width:400px;">Address:<br />';
	$.each(restaurant.addresses, function(j, address) {
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
	html = "<font size = '2'><b><i>" + o.restaurantName + "</i></b></font><br /><font size = '1'>" +
		  o.addressLine1 + "<br />" + 
		  o.addressLine2 + "<br />" + 
		  o.addressLine3 + "</font><br />"
		  ;
	return html;
}
