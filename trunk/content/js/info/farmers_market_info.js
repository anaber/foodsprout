
function postAndRedrawContent(page, perPage, s, o, query, filter, type) {
	var formAction;
	if (type == 'supplier') {
		formAction = '/farmersmarket/ajaxSearchFarmersMarketSuppliers';
	} else if (type == 'comment') {
		formAction = '/farmersmarket/ajaxSearchFarmersMarketComments';
	} else if (type == 'photo') {
		formAction = '/farmersmarket/ajaxSearchFarmersMarketPhotos';
	}
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:farmersMarketId, f:filter, addressId:addressId, producerUrl:uri };
	
	$.post(formAction, postArray,function(data) {		
		jsonData = data;
		currentContent = type;
		
		redrawContent(data, type);
		reinitializeMap(map, data, 8, true);
	},
	"json");
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
	
	changeSelectedTab();
	
	// Move scroll to top of window.
	//$('html, body').animate({scrollTop:0}, 'slow');
	$('html, body').scrollTop(0);
	
	$('#addItem').empty();
	addItemContent = drawAddItem();
	$('#addItem').append(addItemContent);
	
	reinitializePagingEvent(data);
	
	reinitializePageCountEvent(data);
	
	if (data) {
		if (data.param.numResults > 0) {
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
