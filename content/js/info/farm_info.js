
function postAndRedrawContent(page, perPage, s, o, query, filter, type) {
	var formAction;
	if (type == 'supplier') {
		formAction = '/farm/ajaxSearchFarmSuppliee';
	} else if (type == 'comment') {
		formAction = '/farm/ajaxSearchFarmComments';
	} else if (type == 'photo') {
		formAction = '/farm/ajaxSearchFarmPhotos';
	}
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:farmId, f:filter };
	
	$.post(formAction, postArray,function(data) {		
		jsonData = data;
		currentContent = type;
		
		redrawContent(data, type);
	},
	"json");
}


function addZeroResult(type) {
	var html =
	'	<div class = "zero-result-box">';
	
	html += 'We are currently working on adding ';
	
	if (type == 'supplier') {
		html += 'suppliers';
	} else if (type == 'menu') {
		html += 'products';
	} else if (type == 'comment') {
		html += 'comments';
	} else if (type == 'photo') {
		html += 'photos';
	}
	
	html += ' for "' + name + '". All viewers of the site may also update data like Wikipedia. Feel free to add ';
	
	if (type == 'supplier') {
		html += '<a href="#" id = "addSupplier2" style="font-size:13px;text-decoration:none;">suppliers</a>';
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
	
	$('#resultTableContainer').empty();
	var resultTableHtml = '';
	
	if (data.param.numResults == 0) {
		resultTableHtml += addZeroResult(type);
	} else {
		if (type == 'supplier') {
			$.each(data.results, function(i, a) {
				resultTableHtml += addCompanyResult(a, i);
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
			resultTableHtml += '<hr size = "1" class="flt" style="width:530px;border: none 0;border-top: 1px dashed #ccc;height: 1px;">'
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
	
	changeSelectedTab();
	
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
	
	$('#addItem').empty();
	addItemContent = drawAddItem();
	$('#addItem').append(addItemContent);
	
	reinitializePagingEvent(data);
	
	reinitializePageCountEvent(data);
	
	if (data.param.numResults > 0) {
		$('#numRecords2').empty();
		$('#numRecords2').append(numRecordsContent);
	
		$('#recordsPerPage2').empty();
		recordsPerPageContent = drawRecordsPerPage2(data.param);
		$('#recordsPerPage2').append(recordsPerPageContent);
	
		$('#pagingLinks2').empty();
		pagingLinksContent = drawPagingLinks2(data.param);
		$('#pagingLinks2').append(pagingLinksContent);
		
		$('#bottomPaging').show();
		
		reinitializePagingEvent2(data);
	
		reinitializePageCountEvent2(data);
	}
	
	reinitializeAddItemEvent(data);
	if (type == 'comment') {
		$('#farmId').val(farmId);
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
		html += '<div id = "addSupplier" class = "addItem">&nbsp;+ Supplier</div>';
	} else if (currentContent == 'menu') {
		html += '<div id = "addMenu" class = "addItem">&nbsp;+ Menu</div>';
	} 
	return html;
}

function addCompanyResult(company, count) {
	
	var html =
	'<div style="overflow:auto; padding-bottom:10px;">' + 
	'	<div class = "listing-supplier-header">';
	
	if (company.customUrl) {
		html += '	<a href="/' + company.type + '/' + company.customUrl + '" style="font-size:13px;text-decoration:none;">'+ company.companyName +'</a>';
	} else {
		html += '	<a href="/' + company.type + '/view/' + company.companyId + '" style="font-size:13px;text-decoration:none;">'+ company.companyName +'</a>';
	}
	html +=
	'		<div class = "clear"></div>'+
	'	</div>' +
	'	<div class = "clear"></div>';
		
	html += 
	'	<div class = "listing-supplier-information">';
	html += '<b>Type:</b> '+ company.type;
	html += 
	'	</div>' + 
	'	<div class = "listing-address-title">'+
	'		<b>Address:</b>'+
	'	</div>' +
	'	<div class = "listing-address">';
	
	$.each(company.addresses, function(j, address) {
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
