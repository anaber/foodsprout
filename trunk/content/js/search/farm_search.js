var isMapVisible = 1;

var selectedTopFarmTypeId = "";
var selectedTopFarmCropId = "";
var selectedTopCertificationId = "";

var filters = '';

var selectedFarmTypeId = "";
var selectedFarmCropId = "";
var selectedCertificationId = "";

var allFarmTypes;
var allFarmCrops;
var allCertifications;

function postAndRedrawContent(page, perPage, s, o, query, filter, radius) {
	
	var formAction = '/farm/ajaxSearchFarms';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query, f:filter, r:radius };
	
	$.post(formAction, postArray,function(data) {
		farmsData = data;
		redrawContent(data);
	},
	"json");
	
}

function redrawTopFarmLivestock(data) {
	$('#divFarmLivestocks').empty();
	
	var resultHtml = '';
	//alert(selectedFarmTypeId);
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
		
		$.each(allFarmTypes, function(i, a) {
			for(i = 0; i < arrSelectedFarmTypes.length; i++ ) {
				if ( arrSelectedFarmTypes[i] ==  a.farmTypeId) {
					resultHtml += '-' + a.farmType + '<br />';
					break;
				}
			}
		});	
		
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
				} else {
					
				}
			}
			resultHtml += '>';
			
			resultHtml += a.farmType + '<br>';
		});	
	}
	
	$('#divFarmLivestocks').html(resultHtml);
}

function redrawTopFarmCrops(data) {
	$('#divFarmCrops').empty();
	
	var resultHtml = '';
	
	if (selectedFarmCropId != "") {
		
		arrSelectedFarmCrops = new Array();
		j = 0;
		if (filters != '') {
			arrFilter = selectedFarmCropId.split(',');
			
			for(i = 0; i < arrFilter.length; i++ ) {
				arr = arrFilter[i].split('_');
				if (arr[0] == 'fc') {
					arrSelectedFarmCrops[j] = arr[1];
					j++;
				}
			}
		}
		
		$.each(allFarmCrops, function(i, a) {
			for(i = 0; i < arrSelectedFarmCrops.length; i++ ) {
				if ( arrSelectedFarmCrops[i] ==  a.farmCropId) {
					resultHtml += '-' + a.farmCrop + '<br />';
					break;
				}
			}
		});	
		
	} else {
		
		arrTopFilters = new Array();
		j = 0;
		if (filters != '') {
			arrFilter = filters.split(',');
			
			for(i = 0; i < arrFilter.length; i++ ) {
				arr = arrFilter[i].split('_');
				if (arr[0] == 'fc') {
					arrTopFilters[j] = arr[1];
					j++;
				}
			}
		}
		
		$.each(topFarmCrops, function(i, a) {
			resultHtml += '<input type="checkbox" value="fc_'+ a.farmCropId + '" id = "farmCropId" name = "farmCropId"';
			
			for(i = 0; i < arrTopFilters.length; i++ ) {
				if ( arrTopFilters[i] ==  a.farmCropId) {
					resultHtml += ' CHECKED';
					break;
				} else {
					
				}
			}
			resultHtml += '>';
			
			resultHtml += a.farmCrop + '<br>';
		});	
	}
	resultHtml += '<br><a href = "#" id = "chooseMoreFarmCrop" name = "" style="font-size:13px;text-decoration:none;">Choose More...</a><br>';
	
	$('#divFarmCrops').html(resultHtml);
	
	reinitializeMoreFarmCrop(data);
}

function reinitializeMoreFarmCrop(data) {
	$("#chooseMoreFarmCrop").click(function(e){
		e.preventDefault();
		
		var formAction = '/farm/ajaxGetAllFarmCrops';
		
		postArray = { };

		$.post(formAction, postArray,function(farmCrops) {	
			//centerPopup();
			loadPopup();
			allFarmCrops = farmCrops;
			
			redrawAllFarmCrops(data, farmCrops);
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

function redrawAllFarmCrops(data, allFarmCrops) {
	$('#divAllFarmCrops').empty();
	
	// TO-DO - work here
	
	arrSelectedFarmCrops = new Array();
	j = 0;
	
	var strSelectedFarmCropId = '';
	if (selectedFarmCropId != '') {
		strSelectedFarmCropId = selectedFarmCropId;
	} else {
		strSelectedFarmCropId = selectedTopFarmCropId
	}
	
	if (strSelectedFarmCropId != '') {
		arrFilter = strSelectedFarmCropId.split(',');
		
		for(i = 0; i < arrFilter.length; i++ ) {
			arr = arrFilter[i].split('_');
			if (arr[0] == 'fc') {
				arrSelectedFarmCrops[j] = arr[1];
				j++;
			}
		}
	}
	
	var resultHtml = '';
	resultHtml = '<strong>Farm Crops</strong><br>';
	
	resultHtml += '<table cellpadding = "2" cellspacing = "0" border = "0" width = "500">';
	
	j = 0;
	$.each(allFarmCrops, function(i, a) {
		if (j == 0) {
			resultHtml += '<tr>';
		}
		
		resultHtml += '<td width = "133"><input type="checkbox" value="fc_'+ a.farmCropId + '" id = "farmCropId" name = "farmCropId"';
		
		for(i = 0; i < arrSelectedFarmCrops.length; i++ ) {
			if ( arrSelectedFarmCrops[i] ==  a.farmCropId) {
				resultHtml += ' CHECKED';
				break;
			}
		}
		
		resultHtml += '>';
		
		resultHtml += a.farmCrop;
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
	resultHtml += '<tr><td colspan = "3" align = "right"><a id = "cancelFarmCropFilter" href = "#" style="font-size:13px;text-decoration:none;">Cancel</a> &nbsp;&nbsp;&nbsp; <input type = "button" id = "btnApplyFarmCrops" value = "Apply Filters"></td></tr>';
	resultHtml += '</table>';
	
	$('#divAllFarmCrops').html(resultHtml);
	
	//reinitializeMoreCuisine();
	reinitializePopupFarmCropEvent(data, allFarmCrops);
}

function reinitializePopupFarmCropEvent (data, allFarmCrops) {
	
	//$(':checkbox').click(function () {
	$('#btnApplyFarmCrops').click(function () {
		var strFarmCropId = '';	
		var strFilters = '';
		j = 0;
		
		$('#divAllFarmCrops :checked').each(function() {
		   if (j == 0 ) {
	        	strFarmCropId += $(this).val();
	        } else {
	        	strFarmCropId += ',' + $(this).val();
	        }
	        j++;
		  }
		);

		if ( selectedTopFarmTypeId != '' || selectedTopCertificationId != '' ) {
			if (strFarmCropId != '') {
				strFilters = strFarmCropId + (selectedTopFarmTypeId != '' ? ',' + selectedTopFarmTypeId : '') + (selectedTopCertificationId != '' ? ',' + selectedTopCertificationId : '');
			} else {
				strFilters = (selectedTopFarmTypeId != '' ? ',' + selectedTopFarmTypeId : '') + (selectedTopCertificationId != '' ? ',' + selectedTopCertificationId : '');
			}
		} else if ( selectedFarmTypeId != '' || selectedCertificationId != '' ) {
			if (strFarmCropId != '') {
				strFilters = strFarmCropId + (selectedFarmTypeId != '' ? ',' + selectedFarmTypeId : '') + (selectedCertificationId != '' ? ',' + selectedCertificationId : '');
			} else {
				strFilters = (selectedFarmTypeId != '' ? ',' + selectedFarmTypeId : '') + (selectedCertificationId != '' ? ',' + selectedCertificationId : '');
			}
		} else {
			strFilters = strFarmCropId;
		}
		
		selectedFarmCropId = strFarmCropId;
		selectedTopFarmCropId = "";
		disablePopup();
		
		if (data) {
			postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strFilters, data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strFilters, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, param.perPage, param.sort, param.order, param.q, strFilters, param.city);
			hashUrl = buildHashUrl(param.firstPage, param.perPage, param.sort, param.order, param.q, strFilters, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#cancelFarmCropFilter").click(function(e){
		e.preventDefault();
		disablePopup();
	});
	
}

function redrawTopCertifications(data) {
	$('#divCertifications').empty();
	
	var resultHtml = '';
	
	if (selectedCertificationId != "") {
		
		arrSelectedCertifications = new Array();
		j = 0;
		if (filters != '') {
			arrFilter = selectedCertificationId.split(',');
			
			for(i = 0; i < arrFilter.length; i++ ) {
				arr = arrFilter[i].split('_');
				if (arr[0] == 'c') {
					arrSelectedCertifications[j] = arr[1];
					j++;
				}
			}
		}
		
		$.each(allCertifications, function(i, a) {
			for(i = 0; i < arrSelectedCertifications.length; i++ ) {
				if ( arrSelectedCertifications[i] ==  a.certificationId) {
					resultHtml += '-' + a.certification + '<br />';
					break;
				}
			}
		});	
		
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
		
		$.each(topCertifications, function(i, a) {
			resultHtml += '<input type="checkbox" value="c_'+ a.certificationId + '" id = "certificationId" name = "certificationId"';
			
			for(i = 0; i < arrTopFilters.length; i++ ) {
				if ( arrTopFilters[i] ==  a.certificationId) {
					resultHtml += ' CHECKED';
					break;
				} else {
					
				}
			}
			resultHtml += '>';
			
			resultHtml += a.certification + '<br>';
		});	
	}
	
	$('#divCertifications').html(resultHtml);
}

function redrawZipcodeBox() {
	$('#divZipcode').empty();
	formFilterContent = '<form id = "frmFilters">Zip Code <input type="text" size="6" maxlength="5" id = "q"></form>';
	$('#divZipcode').html(formFilterContent);
}

function redrawContent(data) {
	
	redrawTopFarmLivestock(data);
	redrawTopFarmCrops(data);
	redrawTopCertifications(data);
	
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
	//$('html, body').animate({scrollTop:0}, 'slow');
	$('html, body').scrollTop(0);
	
	if (showFilters ==  true) {
		$('#removeFilters').empty();
		removeFilterContent = '<a id = "imgRemoveFilters" href = "#" style="font-size:13px;text-decoration:none;">Remove Filters</a>';
		$('#removeFilters').append(removeFilterContent);
	}
	
	if (showMap ==  true) { 
		$('#divHideMap').empty();
		showHideMapContent = '<a href = "#" id = "linkHideMap" style="font-size:13px;text-decoration:none;">Show/Hide Map</a>';
		$('#divHideMap').append(showHideMapContent);
	}
	
	if (data) {
		redrawZipcodeBox();
		$("#q").val(data.param.q);
	} else {
		// No need to set zipcode, 
		// this done in farm_filter.php 
	}
	
	if (data) {
		$( "#slider" ).slider( "value", data.param.radius );
		$("#radius").html( $("#slider").slider("value") + ' miles' );
	} else {
		$( "#slider" ).slider( "value", param.radius );
		$("#radius").html( $("#slider").slider("value") + ' miles' );
	}
	
	//$('#table_results tbody tr td a').click(function(e) {
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
			} else {
				document.location='/farm/view/'+record_id;
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
	
	
	var strFarmTypeFilters = '';
	var strCertificationFilters = '';
	var strFarmCropFilters = '';
	
	//alert("At Top : " + strFilters);
	
	$(':checkbox').click(function () {
		
		var strFilters = '';
		
		j = 0;
		i = 0;
		$('#divFarmLivestocks :checked').each(function() {
			//alert("Condition 1");return false;
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
		
		i = 0;
		$('#divCertifications :checked').each(function() {
			//alert("Condition 0 : " + strFilters);
			if (j == 0 ) {
	        	strFilters += $(this).val();
	        } else {
	        	strFilters += ',' + $(this).val();
	        }
	        j++;
		  
			if (i == 0 ) {
	        	strCertificationFilters = $(this).val();
	        } else {
	        	strCertificationFilters += ',' + $(this).val();
	        }
	        i++;
		});
		//alert("Condition 1 : " + strFilters);
		
		i = 0;
		$('#divFarmCrops :checked').each(function() {
			//alert("Condition 3");return false;
			if (j == 0 ) {
	        	strFilters += $(this).val();
	        } else {
	        	strFilters += ',' + $(this).val();
	        }
	        j++;
		  
		  
			if (i == 0 ) {
	        	strFarmCropFilters = $(this).val();
	        } else {
	        	strFarmCropFilters += ',' + $(this).val();
	        }
	        i++;
		});
		//alert("Condition 2 : " + strFilters);
		
		if (strFarmTypeFilters != '') {
			selectedTopFarmTypeId = strFarmTypeFilters;
			selectedFarmTypeId = '';
		}
		
		if (strCertificationFilters != '') {
			selectedTopCertificationId = strCertificationFilters;
			selectedCertificationId = '';
		}
		
		if (strFarmCropFilters != '') {
			selectedTopFarmCropId = strFarmCropFilters;
			selectedFarmCropId = '';
		}
		
		if (selectedFarmTypeId != '') {
			if (strFilters != '') {
				strFilters = strFilters + ',' + selectedFarmTypeId;
			} else {
				strFilters = selectedFarmTypeId;
			}
		}
		
		if (selectedCertificationId != '') {
			if (strFilters != '') {
				strFilters = strFilters + ',' + selectedCertificationId;
			} else {
				strFilters = selectedCertificationId;
			}
		}
		
		if (selectedFarmCropId != '') {
			if (strFilters != '') {
				strFilters = strFilters + ',' + selectedFarmCropId;
			} else {
				strFilters = selectedFarmCropId;
			}
		}
		//alert(strFilters );
		
		//if (strFilters != '') {
			filters = strFilters;
		//}
		//alert(strFilters);
		//loadPopupFadeIn();
		
		if (data) {
			postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strFilters, data.param.radius);
			hashUrl = buildHashUrl(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, strFilters, data.param.radius);
		} else {
			postAndRedrawContent(param.firstPage, param.perPage, param.sort, param.order, param.q, strFilters, param.radius);
			hashUrl = buildHashUrl(param.firstPage, param.perPage, param.sort, param.order, param.q, strFilters, param.radius);
		}
		window.location.hash = '!'+hashUrl;
	});
}


function reinitializeQueryFilterEvent (data) {
	
	$("#frmFilters").submit(function(e) {
		e.preventDefault();
		if (data) {
			postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, $("#q").val(), data.param.filter, data.param.radius);
			hashUrl = buildHashUrl(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, $("#q").val(), data.param.filter, data.param.radius);
		} else {
			postAndRedrawContent(param.firstPage, param.perPage, param.sort, param.order, $("#q").val(), param.filter, param.radius);
			hashUrl = buildHashUrl(param.firstPage, param.perPage, param.sort, param.order, $("#q").val(), param.filter, param.radius);
		}
		window.location.hash = '!'+hashUrl;
	});
}


function reinitializeRadiusSearch () {
	$( "#slider" ).slider({
   		stop: function(event, ui) { 
   			data = farmsData;
   			if (data) {
				postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, $("#slider").slider("value"));
				hashUrl = buildHashUrl(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, $("#slider").slider("value") );
			} else {
				postAndRedrawContent(param.firstPage, param.perPage, param.sort, param.order, param.q, param.filter, $("#slider").slider("value"));
				hashUrl = buildHashUrl(param.firstPage, param.perPage, param.sort, param.order, param.q, param.filter, $("#slider").slider("value"));
			}
			window.location.hash = '!'+hashUrl;
   		}
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

		if (data) {
			postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, '', '', data.param.radius);
			hashUrl = buildHashUrl(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, '', '', data.param.radius);
		} else {
			postAndRedrawContent(param.firstPage, param.perPage, param.sort, param.order, '', '', param.radius);
			hashUrl = buildHashUrl(param.firstPage, param.perPage, param.sort, param.order, '', '', param.radius);
		}
		window.location.hash = '!'+hashUrl;
		$('#frmFilters')[0].reset();
	});
}


function reinitializePagingEvent(data) {
	
	$("#imgFirst").click(function(e) {
		e.preventDefault();
		if (data) {
			postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
			hashUrl = buildHashUrl(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
		} else {
			postAndRedrawContent(param.firstPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius);
			hashUrl = buildHashUrl(param.firstPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#imgPrevious").click(function(e) {
		e.preventDefault();
		if (data) {
			previousPage = parseInt(data.param.page)-1;
			if (previousPage <= 0) {
				previousPage = data.param.firstPage;
			}
			postAndRedrawContent(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
			hashUrl = buildHashUrl(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
		} else {
			previousPage = parseInt(param.page)-1;
			if (previousPage <= 0) {
				previousPage = param.firstPage;
			}
			postAndRedrawContent(previousPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius);
			hashUrl = buildHashUrl(previousPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#imgNext").click(function(e) {
		e.preventDefault();
		if (data) {
			nextPage = parseInt(data.param.page)+1;
			if (nextPage >= data.param.totalPages) {
				nextPage = data.param.lastPage;
			}
			postAndRedrawContent(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
			hashUrl = buildHashUrl(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
		} else {
			nextPage = parseInt(param.page)+1;
			if (nextPage >= param.totalPages) {
				nextPage = param.lastPage;
			}
			postAndRedrawContent(nextPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius);
			hashUrl = buildHashUrl(nextPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#imgLast").click(function(e) {
		e.preventDefault();
		if (data) {
			postAndRedrawContent(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
			hashUrl = buildHashUrl(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
		} else {
			postAndRedrawContent(param.lastPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius);
			hashUrl = buildHashUrl(param.lastPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius);
		}
		window.location.hash = '!'+hashUrl;
	});
}

function reinitializePageCountEvent(data) {
	$("#10PerPage").click(function(e) {
		e.preventDefault();
		if (data) {
			postAndRedrawContent(data.param.firstPage, 10, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
			hashUrl = buildHashUrl(data.param.firstPage, 10, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
		} else {
			postAndRedrawContent(param.firstPage, 10, param.sort, param.order, param.q, param.filter, param.radius);
			hashUrl = buildHashUrl(param.firstPage, 10, param.sort, param.order, param.q, param.filter, param.radius);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#20PerPage").click(function(e) {
		e.preventDefault();
		if (data) {
			postAndRedrawContent(data.param.firstPage, 20, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
			hashUrl = buildHashUrl(data.param.firstPage, 20, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
		} else {
			postAndRedrawContent(param.firstPage, 20, param.sort, param.order, param.q, param.filter, param.radius);
			hashUrl = buildHashUrl(param.firstPage, 20, param.sort, param.order, param.q, param.filter, param.radius);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#40PerPage").click(function(e) {
		e.preventDefault();
		if (data) {
			postAndRedrawContent(data.param.firstPage, 40, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
			hashUrl = buildHashUrl(data.param.firstPage, 40, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
		} else {
			postAndRedrawContent(param.firstPage, 40, param.sort, param.order, param.q, param.filter, param.radius);
			hashUrl = buildHashUrl(param.firstPage, 40, param.sort, param.order, param.q, param.filter, param.radius);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#50PerPage").click(function(e) {
		e.preventDefault();
		if (data) {
			postAndRedrawContent(data.param.firstPage, 50, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
			hashUrl = buildHashUrl(data.param.firstPage, 50, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius);
		} else {
			postAndRedrawContent(param.firstPage, 50, param.sort, param.order, param.q, param.filter, param.radius);
			hashUrl = buildHashUrl(param.firstPage, 50, param.sort, param.order, param.q, param.filter, param.radius);
		}
		window.location.hash = '!'+hashUrl;
	});
}

function getMarkerHtml(o) {
	html = "<font size = '2'><b><i>" + o.farmName + "</i></b></font><br /><font size = '1'>" +
		  o.addressLine1 + "<br />" + 
		  o.addressLine2 + "<br />" + 
		  o.addressLine3 + "</font><br />"
		  ;
	return html;
}

function buildHashUrl(p, pp, sort, order, q, filter, radius) {
	str = 'p='+p+'&pp='+pp+'&sort='+sort+'&order='+order+'&f='+filter+'&q='+q+'&r='+radius;
	return str;
}