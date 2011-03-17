
function postAndRedrawContent(page, perPage, s, o, query, filter, type) {
	var formAction;
	if (type == 'supplier') {
		formAction = '/farmersmarket/ajaxSearchFarmersMarketSuppliers';
	} else if (type == 'comment') {
		formAction = '/farmersmarket/ajaxSearchFarmersMarketComments';
	} else if (type == 'photo') {
		formAction = '/farmersmarket/ajaxSearchFarmersMarketPhotos';
	}
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:farmersMarketId, f:filter, addressId:addressId };
	
	$.post(formAction, postArray,function(data) {		
		jsonData = data;
		currentContent = type;
		
		redrawContent(data, type);
		reinitializeMap(map, data, 8, true);
	},
	"json");
}

function addZeroResult(type) {
	var html =
	'	<div class = "zero-result-box">';
	
	html += 'We are currently working on adding ';
	
	if (type == 'supplier') {
		html += 'farms';
	} else if (type == 'menu') {
		html += 'products';
	} else if (type == 'comment') {
		html += 'comments';
	} else if (type == 'photo') {
		html += 'photos';
	}
	
	html += ' for "' + name + '". All viewers of the site may also update data like Wikipedia. Feel free to do add ';
	
	if (type == 'supplier') {
		html += '<a href="#" id = "addSupplier2" style="font-size:13px;text-decoration:none;">farms</a>';
	} else if (type == 'menu') {
		html += '<a href="#" id = "addMenu2" style="font-size:13px;text-decoration:none;">products</a>';
	} else if (type == 'comment') {
		html += 'comments';
	} else if (type == 'photo') {
		html += 'photos';
	}
	
	html +=
	'	</div>'+
	'	<div class = "clear"></div>';
	
	return html;
}

function redrawContent(data, type) {
	
	//$('#resultTableContainer').empty();
	var resultTableHtml = '';
	
	/**
	 * --------------------------------------
	 * AJAX Crawling
	 * --------------------------------------
	 */
	if (data) {
		$('#resultTableContainer').empty();
		
		resultTableHtml = data.listHtml;
		
		if (type == 'comment') {
			resultTableHtml += addCommentForm();
		}
		
		if (type == 'photo') {
			resultTableHtml += addPhotoForm();
		}
		
		
		$('#resultTableContainer').html(resultTableHtml);
		$('#pagingDiv').html(data.pagingHtml);
		if ( type == 'supplier' || type == 'menu' ) {
			$('#bottomPaging').html(data.pagingHtml2);
		}
		
	}
	//-----------------------------------
	
	/*
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
			resultTableHtml += '<div id="divNewComment"></div>'; 
		} else if (type == 'photo') {
			resultTableHtml += '<div id="gallery">'; 
			$.each(data.results, function(i, a) {
				resultTableHtml += addPhotoResult(a, i);
			});
			resultTableHtml += '</div>';
			resultTableHtml += '<hr size = "1" class = "flt listing-dash-line">'
		}
	}
	
	if (type == 'comment') {
		resultTableHtml += addCommentForm();
	}
	
	if (type == 'photo') {
		resultTableHtml += addPhotoForm();
	}
	
	$('#resultTableContainer').append(resultTableHtml);
	
	//$('#messageContainer').hide();
	$('#resultsContainer').show();
	*/
	
	changeSelectedTab();
	
	// Move scroll to top of window.
	//$('html, body').animate({scrollTop:0}, 'slow');
	$('html, body').scrollTop(0);
	/*
	$('#numRecords').empty();
	numRecordsContent = drawNumRecords(data.param);			
	$('#numRecords').append(numRecordsContent);
	
	$('#recordsPerPage').empty();
	recordsPerPageContent = drawRecordsPerPage(data.param);
	$('#recordsPerPage').append(recordsPerPageContent);
	
	$('#pagingLinks').empty();
	pagingLinksContent = drawPagingLinks(data.param);
	$('#pagingLinks').append(pagingLinksContent);
	*/
	
	$('#addItem').empty();
	addItemContent = drawAddItem();
	$('#addItem').append(addItemContent);
	
	reinitializePagingEvent(data);
	
	reinitializePageCountEvent(data);
	
	if (data) {
		if (data.param.numResults > 0) {
			/*
			$('#numRecords2').empty();
			$('#numRecords2').append(numRecordsContent);
		
			$('#recordsPerPage2').empty();
			recordsPerPageContent = drawRecordsPerPage2(data.param);
			$('#recordsPerPage2').append(recordsPerPageContent);
		
			$('#pagingLinks2').empty();
			pagingLinksContent = drawPagingLinks2(data.param);
			$('#pagingLinks2').append(pagingLinksContent);
			
			$('#bottomPaging').show();
			*/
			
			reinitializePagingEvent2(data);
			reinitializePageCountEvent2(data);
		}
	} else {
		if (param.numResults > 0) {
			reinitializePagingEvent2(data);
			reinitializePageCountEvent2(data);
		}
	}
	
	reinitializeAddItemEvent(data);
	if (type == 'comment') {
		$('#farmersMarketId').val(farmersMarketId);
		reinitializeCommentCharacterCount();
		reinitializeSubmitCommentForm(data);
	}
	
	if (type == 'photo') {
		reinitializeLitebox();
		reinitializeUploadPhotoForm();
	}
	//disablePopupFadeIn();
}

function drawAddItem() {
	
	$("#addItem").removeClass();
	html = "";
	if (currentContent == 'supplier') {
		html += '<div id = "addSupplier" class = "addItem">&nbsp;+ Farm</div>';
	} else if (currentContent == 'menu') {
		html += '<div id = "addMenu" class = "addItem">&nbsp;+ Menu</div>';
	}
	return html;
}
/*
function addSupplierResult(supplier, count) {
	var html =
	'<div style="overflow:auto; padding-bottom:10px;">' + 
	'	<div class = "listing-supplier-header">';
	
	if (supplier.customUrl) {
		html += '	<a href="/' + supplier.supplierType + '/' + supplier.customUrl + '" style="font-size:13px;text-decoration:none;">'+ supplier.supplierName +'</a>';
	} else {
		html += '	<a href="/' + supplier.supplierType + '/view/' + supplier.supplierReferenceId + '" style="font-size:13px;text-decoration:none;">'+ supplier.supplierName +'</a>';
	}
	html +=
	'		<div class = "clear"></div>'+
	'	</div>' +
	'	<div class = "clear"></div>';
		
	html += 
	'	<div class = "listing-supplier-information">';
	html += '<b>Type:</b> '+ supplier.supplierType;
	html += 
	'	</div>' + 
	'	<div class = "listing-address-title">'+
	'		<b>Address:</b>'+
	'	</div>' +
	'	<div class = "listing-address">';
	
	$.each(supplier.addresses, function(j, address) {
		if (j == 0) {
			html += address.displayAddress ;
		} else {
			html += "<br /><br />" + address.displayAddress ;
		}
	});
	
	html += 
	'	</div>';
	html +=
	'</div>' +
	'<div class = "clear"></div>'
	;
	
	return html;
}
*/