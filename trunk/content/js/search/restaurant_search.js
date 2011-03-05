var isMapVisible = 1;

var selectedTopCuisineId = "";
var selectedTopRestaurantTypeId = "";

var filters = '';

var selectedCuisineId = "";
var selectedRestaurantTypeId = "";
var allCuisines;
var allRestaurantTypes;



function postAndRedrawContent(page, perPage, s, o, query, filter, city) {
	
	var formAction = '/restaurant/ajaxSearchRestaurants';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query, f:filter, city:city };
	
	$.post(formAction, postArray,function(data) {	
		
		redrawContent(data);		
	}
	,"json"
	);
	
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
	resultHtml += '<tr><td colspan = "3" align = "right"><a id = "cancelCuisineFilter" href = "#" style="font-size:13px;text-decoration:none;">Cancel</a> &nbsp;&nbsp;&nbsp; <input type = "button" id = "btnApplyCuisines" value = "Apply Filters"></td></tr>';
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
		
		/**
		 * --------------------------------------
		 * AJAX Crawling
		 * --------------------------------------
		 */
		arrTopFilters = new Array();
		j = 0;
		strCuisineId = '';
		
		if (data) {
			filters = data.param.filter;
			
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
			
		} else if (param) {
			arrFilter = param.filter.split(',');
			
			for(i = 0; i < arrFilter.length; i++ ) {
				arr = arrFilter[i].split('_');
				if (arr[0] == 'c') {
					if (strCuisineId == '') {
						strCuisineId += arrFilter[i];
					} else {
						strCuisineId += ',' + arrFilter[i];
					}
					arrTopFilters[j] = arr[1];
					j++;
				}
			}
			selectedCuisineId = strCuisineId;
		}
		
		//-----------------------------------
		
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
	
	resultHtml += '<br><a href = "#" id = "chooseMoreCuisine" name = "" style="font-size:13px;text-decoration:none;">Choose More...</a><br>';
		
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
	resultHtml += '<tr><td colspan = "3" align = "right"><a id = "cancelRestaurantTypeFilter" href = "#" style="font-size:13px;text-decoration:none;">Cancel</a> &nbsp;&nbsp;&nbsp; <input type = "button" id = "btnApplyRestaurantTypes" value = "Apply Filters"></td></tr>';
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
		
		if (data) {
			postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strFilters, data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strFilters, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, param.perPage, param.sort, param.order, param.q, strFilters, param.city);
			hashUrl = buildHashUrl(param.firstPage, param.perPage, param.sort, param.order, param.q, strFilters, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#cancelRestaurantTypeFilter").click(function(e){
		e.preventDefault();
		disablePopup();
	});
	
}

function redrawTopRestaurantTypes(data) {
	$('#divRestaurantTypes').empty();
	//alert(selectedRestaurantTypeId);
	var resultHtml = '';
	if (selectedRestaurantTypeId != "") {
		//alert("Filters:" + selectedRestaurantTypeId + ":");
		arrSelectedRestaurantTypes = new Array();
		j = 0;
		if (filters != '') {
			arrFilter = selectedRestaurantTypeId.split(',');
			
			for(i = 0; i < arrFilter.length; i++ ) {
				arr = arrFilter[i].split('_');
				if (arr[0] == 'r') {
					arrSelectedRestaurantTypes[j] = arr[1];
					//alert("Here :" + arrSelectedRestaurantTypes[j] + ":");
					j++;
				}
			}
		}
		
		$.each(allRestaurantTypes, function(i, a) {
			//alert(a.restaurantTypeId);
			for(i = 0; i < arrSelectedRestaurantTypes.length; i++ ) {
				//alert(arrSelectedRestaurantTypes[i]);return false;
				if ( arrSelectedRestaurantTypes[i] ==  a.restaurantTypeId) {
					resultHtml += '-' + a.restaurantTypeName + '<br />';
					break;
				}
			}
		});	
		
	} else {
		/**
		 * --------------------------------------
		 * AJAX Crawling
		 * --------------------------------------
		 */
		arrTopFilters = new Array();
		j = 0;
		strRestaurantTypeId = '';
		//if (param && param.filter != false) {
		if (data) {
			//alert(data.param.filter);
			filters = data.param.filter;
			if (filters != '') {
				//alert("IF");
				arrFilter = filters.split(',');
				
				for(i = 0; i < arrFilter.length; i++ ) {
					arr = arrFilter[i].split('_');
					if (arr[0] == 'r') {
						arrTopFilters[j] = arr[1];
						j++;
					}
				}
			}
		} else if (param) {
			arrFilter = param.filter.split(',');
			
			for(i = 0; i < arrFilter.length; i++ ) {
				//alert(arrFilter[i]);
				arr = arrFilter[i].split('_');
				if (arr[0] == 'r') {
					if (strRestaurantTypeId == '') {
						strRestaurantTypeId += arrFilter[i];
					} else {
						strRestaurantTypeId += ',' + arrFilter[i];
					}
					arrTopFilters[j] = arr[1];
					j++;
				}
			}
			selectedRestaurantTypeId = strRestaurantTypeId;
		}
		
		//-----------------------------------
		
		$.each(topRestaurantTypes, function(i, a) {
			resultHtml += '<input type="checkbox" value="r_'+ a.restaurantTypeId + '" id = "restaurantTypeId" name = "restaurantTypeId"';
			
			for(i = 0; i < arrTopFilters.length; i++ ) {
				if ( arrTopFilters[i] ==  a.restaurantTypeId) {
					resultHtml += ' CHECKED';
					break;
				} else {
					
				}
			}
			resultHtml += '>';
			
			resultHtml += a.restaurantType + '<br>';
		});
		
		
	}
	
	resultHtml += '<br><a href = "#" id = "chooseMoreRestaurantType" name = "" style="font-size:13px;text-decoration:none;">Choose More...</a><br>';
		
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
		
function redrawSustainableRestaurantsCheckbox() {
	$('#divSustainableRestaurants').empty();
	var checkboxSelected = false;
	
	if (filters != '') {
		arrFilter = filters.split(',');
		
		for(i = 0; i < arrFilter.length; i++ ) {
			if (arrFilter[i] == 's') {
				checkboxSelected = true;
			}
		}
	}
	
	content = '<input type = "checkbox" name = "showSustainableRestaurants" id = "showSustainableRestaurants"';
	if (checkboxSelected) {
		content += ' CHECKED';
	}
	content += '>&nbsp;Sustainable Restaurants';
	
	$('#divSustainableRestaurants').html(content);
}

function redrawContent(data) {
	
	redrawTopRestaurantTypes(data);
	redrawTopCuisines(data);
	
	/**
	 * --------------------------------------
	 * AJAX Crawling
	 * --------------------------------------
	 */
	if (data) {
		$('#resultTableContainer').empty();
		$('#resultTableContainer').html(data.listHtml);
		$('#pagingDiv').html(data.pagingHtml);
		
	}
	//-----------------------------------
	
	// Move scroll to top of window.
	$('html, body').scrollTop(0);
	
	if (showFilters ==  true) {
		$('#removeFilters').empty();
		removeFilterContent = '<a id = "imgRemoveFilters" href = "' + uri + '" style="font-size:13px;text-decoration:none;">Remove Filters</a>';
		$('#removeFilters').append(removeFilterContent);
	}
	
	if (showMap ==  true) {
		$('#divHideMap').empty();
		showHideMapContent = '<a href = "#" id = "linkHideMap" style="font-size:13px;text-decoration:none;">Show/Hide Map</a>';
		$('#divHideMap').append(showHideMapContent);
	}
	
	if (data) {
		if (data.param.city != '') {	
			// Do nothing
		} else {
			redrawZipcodeBox();
			$("#q").val(data.param.q);
			redrawSustainableRestaurantsCheckbox();
		}
	} else {
		if (param.city != false) {	
			// Do nothing
		} else {
			// No need to set zipcode, 
			// this done in restaurant_filter.php 
			redrawSustainableRestaurantsCheckbox();
		}
	}
	
	$('#resultTableContainer div div a').click(function(e) {
		record_id = $(this).attr('id');
		
		if (record_id != '') {
			if (isNaN(record_id) ) {
				e.preventDefault();
				var arr = record_id.split('_');
				record_id = arr[1];
				
				viewMarker(map, record_id, 1);
				//$('html, body').animate({scrollTop:0}, 'slow');
				$('html, body').scrollTop(0);
			}
		}
	});
	
	
	if (showMap ==  true) { 
		if (data) {
			reinitializeMap(map, data, data.param.zoomLevel);
		} else {
			reinitializeMap(map, '', param.zoomLevel);
		}
	}
	
	reinitializePagingEvent(data);
	
	reinitializePageCountEvent(data);
	
	if (showFilters ==  true) {
		reinitializeRemoveFilters(data);
	}
	
	reinitializeFilterEvent(data);
	
	reinitializeQueryFilterEvent(data);
	reinitializeShowHideMap(data);
	
	disablePopupFadeIn();
}

/*
function addZeroResult() {
	var html =
	'<div style="overflow:auto; padding:0px; clear:left; margin-right:10px; padding-bottom:10px;" align = "center">' +
	'	<div style="float:left; width:600px; clear:left;padding-left:3px; padding-right:10px;font-size:13px;">No results found. Please retry with some other filter options.</div>' + 
	'</div>'
	;	
	return html;
}
*/

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
	var strSustainableFilters = '';
	
	$(':checkbox').click(function () {
		
		j = 0;
		i = 0;
		$('#divRestaurantTypes :checked').each(function() {
		   	//alert("Condition 1");
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
	        
		  });

		i = 0;
		$('#divCuisines :checked').each(function() {
			//alert("Condition 2");
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
		});
		
		$('#divSustainableRestaurants :checked').each(function() {
		  	//alert("Condition 3");
		  	strSustainableFilters = 's';
		  	//alert("Sustainable restaurants clicked");
		});
		
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
		
		if (strSustainableFilters != '') {
			if (strFilters != '') {
				strFilters = strFilters + ',' + strSustainableFilters;
			} else {
				strFilters = strSustainableFilters;
			}
		}
		//alert("Line : 808:" + strFilters);
		// Don't remember why I had added this condition. But its causing bug, so removing this for now.
		//if (strFilters != '') {
			filters = strFilters;
		//}
		//alert(strFilters);
		
		loadPopupFadeIn();
		if (data) {
			postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strFilters, data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strFilters, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, param.perPage, param.sort, param.order, param.q, strFilters, param.city);
			hashUrl = buildHashUrl(param.firstPage, param.perPage, param.sort, param.order, param.q, strFilters, param.city);
		}
		window.location.hash = '!'+hashUrl;
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
		
		if (data) {
			postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strFilters, data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strFilters, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, param.perPage, param.sort, param.order, param.q, strFilters, param.city);
			hashUrl = buildHashUrl(param.firstPage, param.perPage, param.sort, param.order, param.q, strFilters, param.city);
		}
		window.location.hash = '!'+hashUrl;
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
		if (data) {
			postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, $("#q").val(), data.param.filter, data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, $("#q").val(), data.param.filter, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, param.perPage, param.sort, param.order, $("#q").val(), param.filter, param.city);
			hashUrl = buildHashUrl(param.firstPage, param.perPage, param.sort, param.order, $("#q").val(), param.filter, param.city);
		}
		window.location.hash = '!'+hashUrl;
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
		
		if (data) {
			postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, '', '', data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, '', '', data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, param.perPage, param.sort, param.order, '', '', param.city);
			hashUrl = buildHashUrl(param.firstPage, param.perPage, param.sort, param.order, '', '', param.city);
		}
		window.location.hash = '!'+hashUrl;
		$('#frmFilters')[0].reset();
	});
}

function reinitializePagingEvent(data) {
	
	$("#imgFirst").click(function(e) {
		e.preventDefault();
		loadPopupFadeIn();
		if (data) {
			postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, param.perPage, param.sort, param.order, param.q, param.filter, param.city);
			hashUrl = buildHashUrl(param.firstPage, param.perPage, param.sort, param.order, param.q, param.filter, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#imgPrevious").click(function(e) {
		e.preventDefault();
		
		loadPopupFadeIn();
		if (data) {
			previousPage = parseInt(data.param.page)-1;
			if (previousPage <= 0) {
				previousPage = data.param.firstPage;
			}
			postAndRedrawContent(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
			hashUrl = buildHashUrl(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
		} else {
			previousPage = parseInt(param.page)-1;
			if (previousPage <= 0) {
				previousPage = param.firstPage;
			}
			postAndRedrawContent(previousPage, param.perPage, param.sort, param.order, param.q, param.filter, param.city);
			hashUrl = buildHashUrl(previousPage, param.perPage, param.sort, param.order, param.q, param.filter, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#imgNext").click(function(e) {
		e.preventDefault();
		
		loadPopupFadeIn();
		
		if (data) {
			nextPage = parseInt(data.param.page)+1;
			if (nextPage >= data.param.totalPages) {
				nextPage = data.param.lastPage;
			}
			postAndRedrawContent(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
			hashUrl = buildHashUrl(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
		} else {
			nextPage = parseInt(param.page)+1;
			if (nextPage >= param.totalPages) {
				nextPage = param.lastPage;
			}
			postAndRedrawContent(nextPage, param.perPage, param.sort, param.order, param.q, param.filter, param.city);
			hashUrl = buildHashUrl(nextPage, param.perPage, param.sort, param.order, param.q, param.filter, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#imgLast").click(function(e) {
		e.preventDefault();
		loadPopupFadeIn();
		if (data) {
			postAndRedrawContent(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
			hashUrl = buildHashUrl(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
		} else {
			postAndRedrawContent(param.lastPage, param.perPage, param.sort, param.order, param.q, param.filter, param.city);
			hashUrl = buildHashUrl(param.lastPage, param.perPage, param.sort, param.order, param.q, param.filter, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
}

function reinitializePageCountEvent(data) {
	$("#10PerPage").click(function(e) {
		e.preventDefault();
		loadPopupFadeIn();
		if (data) {
			postAndRedrawContent(data.param.firstPage, 10, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, 10, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, 10, param.sort, param.order, param.q, param.filter, param.city);
			hashUrl = buildHashUrl(param.firstPage, 10, param.sort, param.order, param.q, param.filter, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#20PerPage").click(function(e) {
		e.preventDefault();
		loadPopupFadeIn();
		if (data) {
			postAndRedrawContent(data.param.firstPage, 20, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, 20, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, 20, param.sort, param.order, param.q, param.filter, param.city);
			hashUrl = buildHashUrl(param.firstPage, 20, param.sort, param.order, param.q, param.filter, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#40PerPage").click(function(e) {
		e.preventDefault();
		loadPopupFadeIn();
		if (data) {
			postAndRedrawContent(data.param.firstPage, 40, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, 40, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, 40, param.sort, param.order, param.q, param.filter, param.city);
			hashUrl = buildHashUrl(param.firstPage, 40, param.sort, param.order, param.q, param.filter, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#50PerPage").click(function(e) {
		e.preventDefault();
		loadPopupFadeIn();
		if (data) {
			postAndRedrawContent(data.param.firstPage, 50, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, 50, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, 50, param.sort, param.order, param.q, param.filter, param.city);
			hashUrl = buildHashUrl(param.firstPage, 50, param.sort, param.order, param.q, param.filter, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
}

function getMarkerHtml(o) {
	html = "<font size = '2'><b><i>" + o.restaurantName + "</i></b></font><br /><font size = '1'>" +
		  o.addressLine1 + "<br />" + 
		  o.addressLine2 + "<br />" + 
		  o.addressLine3 + "</font><br />"
		  ;
	return html;
}

function buildHashUrl(p, pp, sort, order, q, filter, city) {
	str = 'p='+p+'&pp='+pp+'&sort='+sort+'&order='+order+'&f='+filter+'&q='+q+'&city='+city;
	return str;
}
