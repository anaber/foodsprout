var isMapVisible = 1;

function postAndRedrawContent(page, perPage, s, o, query, filter, radius, city) {
	
	var formAction = '/farmersmarket/ajaxSearchFarmersMarket';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query, f:filter, r:radius , city:city };
	
	$.post(formAction, postArray,function(data) {		
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
	
	if (data) {
		$('#resultTableContainer').empty();
		$('#resultTableContainer').html(data.listHtml);
		$('#pagingDiv').html(data.pagingHtml);
	}
	
	$('html, body').scrollTop(0);
	
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
		// this done in farmers_market_filter.php 
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
	
	reinitializeQueryFilterEvent(data);
	
	reinitializeShowHideMap(data);
	
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


function reinitializeQueryFilterEvent (data) {
	
	$("#frmFilters").submit(function(e) {
		e.preventDefault();
		if (data) {
			postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, $("#q").val(), data.param.filter, data.param.radius, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, param.perPage, param.sort, param.order, $("#q").val(), param.filter, param.radius, param.city);
		}
	});
}

function reinitializeRadiusSearch () {
	$( "#slider" ).slider({
   		stop: function(event, ui) { 
   			data = farmsData;
   			if (data) {
				postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, $("#slider").slider("value"), data.param.city );
			} else {
				postAndRedrawContent(param.firstPage, param.perPage, param.sort, param.order, param.q, param.filter, $("#slider").slider("value"), param.city );
			}
   		}
	});
}

function reinitializePagingEvent(data) {
	
	$("#imgFirst").click(function(e) {
		e.preventDefault();
		if (data) {
			postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius, param.city);
			hashUrl = buildHashUrl(param.firstPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius, param.city);
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
			postAndRedrawContent(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
			hashUrl = buildHashUrl(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
		} else {
			previousPage = parseInt(param.page)-1;
			if (previousPage <= 0) {
				previousPage = param.firstPage;
			}
			postAndRedrawContent(previousPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius, param.city);
			hashUrl = buildHashUrl(previousPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius, param.city);
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
			postAndRedrawContent(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
			hashUrl = buildHashUrl(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
		} else {
			nextPage = parseInt(param.page)+1;
			if (nextPage >= param.totalPages) {
				nextPage = param.lastPage;
			}
			postAndRedrawContent(nextPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius, param.city);
			hashUrl = buildHashUrl(nextPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#imgLast").click(function(e) {
		e.preventDefault();
		if (data) {
			postAndRedrawContent(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
			hashUrl = buildHashUrl(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
		} else {
			postAndRedrawContent(param.lastPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius, param.city);
			hashUrl = buildHashUrl(param.lastPage, param.perPage, param.sort, param.order, param.q, param.filter, param.radius, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
}

function reinitializePageCountEvent(data) {
	$("#10PerPage").click(function(e) {
		e.preventDefault();
		if (data) {
			postAndRedrawContent(data.param.firstPage, 10, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, 10, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, 10, param.sort, param.order, param.q, param.filter, param.radius, param.city);
			hashUrl = buildHashUrl(param.firstPage, 10, param.sort, param.order, param.q, param.filter, param.radius, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#20PerPage").click(function(e) {
		e.preventDefault();
		if (data) {
			postAndRedrawContent(data.param.firstPage, 20, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, 20, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, 20, param.sort, param.order, param.q, param.filter, param.radius, param.city);
			hashUrl = buildHashUrl(param.firstPage, 20, param.sort, param.order, param.q, param.filter, param.radius, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#40PerPage").click(function(e) {
		e.preventDefault();
		if (data) {
			postAndRedrawContent(data.param.firstPage, 40, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, 40, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, 40, param.sort, param.order, param.q, param.filter, param.radius, param.city);
			hashUrl = buildHashUrl(param.firstPage, 40, param.sort, param.order, param.q, param.filter, param.radius, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
	
	$("#50PerPage").click(function(e) {
		e.preventDefault();
		if (data) {
			postAndRedrawContent(data.param.firstPage, 50, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
			hashUrl = buildHashUrl(data.param.firstPage, 50, data.param.sort, data.param.order, data.param.q, data.param.filter, data.param.radius, data.param.city);
		} else {
			postAndRedrawContent(param.firstPage, 50, param.sort, param.order, param.q, param.filter, param.radius, param.city);
			hashUrl = buildHashUrl(param.firstPage, 50, param.sort, param.order, param.q, param.filter, param.radius, param.city);
		}
		window.location.hash = '!'+hashUrl;
	});
}
/*
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
	'<div style="overflow:auto; padding-bottom:10px;">' +
	'	<div class = "listing-header">';
	
	if (farmersMarket.customUrl) {
		html += '<a href="/farmersmarket/' + farmersMarket.customUrl + '" id = "'+ farmersMarket.farmersMarketId +'" style="text-decoration:none;">'+ farmersMarket.farmersMarketName +'</a>';
	} else {
		html += '<a href="/farmersmarket/view/' + farmersMarket.farmersMarketId + '" id = "'+ farmersMarket.farmersMarketId +'" style="text-decoration:none;">'+ farmersMarket.farmersMarketName +'</a>';
	}
	
	html +=
	'	</div>' +
	'	<div class = "clear"></div>';
	html +=
	'	<div class = "listing-address-title">'+
	'		<b>Address:</b>'+
	'	</div>' +
	'	<div class = "listing-address">';
	$.each(farmersMarket.addresses, function(j, address) {
		if (j == 0) {
			html += '<a href="#" id = "map_'+ address.addressId +'" style="font-size:13px;text-decoration:none;">' + address.displayAddress + '</a>';
		} else {
			html += "<br /><br />" + '<a href="#" id = "map_'+ address.addressId +'" style="font-size:13px;text-decoration:none;">' + address.displayAddress + '</a>';
		}
	});
	
	html += 
	'	</div>' +
	'	<div class = "clear"></div>';
	html +=
	'</div>' +
	'<div class = "clear"></div>'
	;
	
	return html;
}
*/

function getMarkerHtml(o) {
	html = "<font size = '2'><b><i>" + o.farmersMarketName + "</i></b></font><br /><font size = '1'>" +
		  o.addressLine1 + "<br />" + 
		  o.addressLine2 + "<br />" + 
		  o.addressLine3 + "</font><br />"
		  ;
	return html;
}

function buildHashUrl(p, pp, sort, order, q, filter, radius, city) {
	str = 'p='+p+'&pp='+pp+'&sort='+sort+'&order='+order+'&f='+filter+'&q='+q+'&r='+radius+'&city='+city;
	return str;
}