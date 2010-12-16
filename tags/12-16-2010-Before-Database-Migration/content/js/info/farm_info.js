
function postAndRedrawContent(page, perPage, s, o, query, filter, type) {
	var formAction;
	if (type == 'supplier') {
		formAction = '/farm/ajaxSearchFarmCompanies';
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
	'<div style="overflow:auto; padding:0px; clear:left; margin-right:10px; padding-bottom:10px;" align = "center">' +
	'	<div style="float:left; width:500px; clear:left;padding-left:3px; padding-right:10px;font-size:13px;">';
	
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
	
	html +='</div>' + 
	'</div>'
	;	
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
	'<div style="overflow:auto; padding:5px;">' +
	'	<div style="float:left; width:220px;font-size:13px;"><a href="/' + company.type + '/view/' + company.companyId + '" style="font-size:13px;text-decoration:none;">'+ company.companyName +'</a><br><b>Type:</b> '+ company.type + '</div>' +
	'	<div style="float:left; width:60px;font-size:13px;"><b>Address: </b></div><div style="float:left; width:240px;font-size:13px;">';
	
	$.each(company.addresses, function(j, address) {
		if (j == 0) {
			html += address.displayAddress;
		} else {
			html += "<br /><br />" + address.displayAddress;
		}
	});
	
	
	html += '</div>';
	html +=
	'</div><div style="font-size:13px;height:5px;">&nbsp;</div>'
	;
	
	return html;
}

function addMenuResult(menu, count) {
	var html = '';
	
	html +=	'<div class="menuitem">';
	//html +=	'	<div class="menuitemimg"><img src="/img/img1.jpg" width="132" height="107" alt="receipe" />';
	
	html +=	'	<div class="menuitemimg">';
	if (menu.image) {
		html +=	'<img src="' + menu.image + '" width="132" height="107" alt="receipe" />';
	}
	
	html += '	</div>';
	html +=	'	<div class="menuitemname">' + menu.productName + '</div>';
	html +=	'	<div class="menuitemdetails">' + menu.ingredient + '</div>';
	html +=	'</div>';
	
	return html;
}
