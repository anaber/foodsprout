
function postAndRedrawContent(page, perPage, s, o, query, filter, type) {
	var formAction;
	if (type == 'menu') {
		formAction = '/chain/ajaxSearchRestaurantChainMenus';
	} else if (type == 'supplier') {
		formAction = '/chain/ajaxSearchRestaurantChainSuppliers';
	} else if (type == 'comment') {
		formAction = '/chain/ajaxSearchRestaurantChainComments';
	}
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:restaurantChainId, f:filter };
	
	$.post(formAction, postArray,function(data) {		
		jsonData = data;
		currentContent = type;
		
		redrawContent(data, type);
	},
	"json");
}

function reinitializeTabs() {
	data = jsonData;
	$("#suppliers").click(function(e) {
		e.preventDefault();
		$.validationEngine.closePrompt('.formError',true);
		$("#divAddMenu").hide( { duration: toggleDuration } );
		isMenuFormVisible = false;
		resetMenuForm();
		
		$("#divAddComment").hide( { duration: toggleDuration } );
		isCommentFormVisible = false;
		//resetCommentForm();
		
		$('#bottomPaging').hide();
		
		if (isSupplierFormVisible || isMenuFormVisible || isCommentFormVisible) {
			$("#addItem").removeClass().addClass('add-item-selected');
		} else {
			$("#addItem").removeClass().addClass('add-item');
		}
		
		postAndRedrawContent(data.param.firstPage, data.param.perPage, '', '', data.param.q, data.param.filter, 'supplier');
	});
	
	$("#menu").click(function(e) {
		e.preventDefault();
		$.validationEngine.closePrompt('.formError',true);
		$("#divAddSupplier").hide( { duration: toggleDuration } );
		isSupplierFormVisible = false;
		resetSupplierForm();
		
		$("#divAddComment").hide( { duration: toggleDuration } );
		isCommentFormVisible = false;
		//resetCommentForm();
		
		
		$('#bottomPaging').hide();
		
		if (isSupplierFormVisible || isMenuFormVisible || isCommentFormVisible) {
			$("#addItem").removeClass().addClass('add-item-selected');
		} else {
			$("#addItem").removeClass().addClass('add-item');
		}
		
		postAndRedrawContent(data.param.firstPage, data.param.perPage, '', '', data.param.q, data.param.filter, 'menu');
	});
	
	
	$("#comments").click(function(e) {
		e.preventDefault();
		$.validationEngine.closePrompt('.formError',true);
		$("#divAddSupplier").hide( { duration: toggleDuration } );
		isSupplierFormVisible = false;
		resetSupplierForm();
		
		$("#divAddMenu").hide( { duration: toggleDuration } );
		isMenuFormVisible = false;
		resetMenuForm();
		
		$('#bottomPaging').hide();
		
		if (isSupplierFormVisible || isMenuFormVisible || isCommentFormVisible) {
			$("#addItem").removeClass().addClass('add-item-selected');
		} else {
			$("#addItem").removeClass().addClass('add-item');
		}
		
		postAndRedrawContent(data.param.firstPage, data.param.perPage, '', '', data.param.q, data.param.filter, 'comment');
	});
	
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
	}
	
	html += ' for "' + name + '". All viewers of the site may also update data like Wikipedia. Feel free to do add ';
	
	if (type == 'supplier') {
		html += '<a href="#" id = "addSupplier2" style="font-size:13px;text-decoration:none;">suppliers</a>';
	} else if (type == 'menu') {
		html += '<a href="#" id = "addMenu2" style="font-size:13px;text-decoration:none;">products</a>';
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
		}
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
	
	//disablePopupFadeIn();
}

function drawAddItem() {
	html = "";
	if (currentContent == 'supplier') {
		html += '<a href="#"><div id = "addSupplier">+ Supplier</div></a>';
	} else if (currentContent == 'menu') {
		html += '<a href="#"><div id = "addMenu">+ Menu</div></a>';
	} else if (currentContent == 'comment') {
		html += '<a href="#"><div id = "addComment">+ Comment</div></a>';
	}
	return html;
}

function reinitializeAddItemEvent(data) {
	
	$("#addSupplier").click(function(e) {
		e.preventDefault();
		
		if (isSupplierFormVisible == true) {
			$.validationEngine.closePrompt('.formError',true);
			$("#divAddSupplier").hide( toggleDuration, function() {
				$("#addItem").removeClass().addClass('add-item');	
			} );
			isSupplierFormVisible = false;
			
		} else if (isSupplierFormVisible == false) {
			
			$("#divAddSupplier").show( toggleDuration, function() {
				$("#addItem").removeClass().addClass('add-item-selected');
			});
			isSupplierFormVisible = true;
		}
	});
	
	$("#addSupplier2").click(function(e) {
		e.preventDefault();
		
		if (isSupplierFormVisible == true) {
			$.validationEngine.closePrompt('.formError',true);
			$("#divAddSupplier").hide( toggleDuration, function() {
				$("#addItem").removeClass().addClass('add-item');	
			} );
			isSupplierFormVisible = false;
			
		} else if (isSupplierFormVisible == false) {
			
			$("#divAddSupplier").show( toggleDuration, function() {
				$("#addItem").removeClass().addClass('add-item-selected');
			});
			isSupplierFormVisible = true;
		}
	});	
	
	$("#addMenu").click(function(e) {
		e.preventDefault();
		if (isMenuFormVisible == true) {
			$.validationEngine.closePrompt('.formError',true);
			$("#divAddMenu").hide( toggleDuration, function() {
				$("#addItem").removeClass().addClass('add-item');
			} );
			isMenuFormVisible = false;
			
		} else if (isMenuFormVisible == false) {
			
			$("#divAddMenu").show( toggleDuration, function() {
				$("#addItem").removeClass().addClass('add-item-selected');
			} );
			isMenuFormVisible = true;
		}
	});	
	
	$("#addMenu2").click(function(e) {
		e.preventDefault();
		if (isMenuFormVisible == true) {
			$.validationEngine.closePrompt('.formError',true);
			$("#divAddMenu").hide( toggleDuration, function() {
				$("#addItem").removeClass().addClass('add-item');
			} );
			isMenuFormVisible = false;
			
		} else if (isMenuFormVisible == false) {
			
			$("#divAddMenu").show( toggleDuration, function() {
				$("#addItem").removeClass().addClass('add-item-selected');
			} );
			isMenuFormVisible = true;
		}
	});	
	
	
	$("#addComment").click(function(e) {
		e.preventDefault();
		//$("#divAddComment").animate({"height": "toggle"}, { duration: toggleDuration });
		if (isCommentFormVisible == true) {
			$.validationEngine.closePrompt('.formError',true);
			$("#divAddComment").hide( toggleDuration, function() {
				$("#addItem").removeClass().addClass('add-item');
			} );
			isCommentFormVisible = false;
			
		} else if (isCommentFormVisible == false) {
			
			$("#divAddComment").show( toggleDuration, function() {
				$("#addItem").removeClass().addClass('add-item-selected');
			} );
			isCommentFormVisible = true;
		}
	});
	
}

function changeSelectedTab() {
	if (currentContent == 'supplier') {
		$("#suppliers").removeClass().addClass('selected');
		$("#menu").removeClass().addClass('non-selected');
		//$("#comments").removeClass().addClass('non-selected');
	} else if (currentContent == 'menu') {
		$("#suppliers").removeClass().addClass('non-selected');
		$("#menu").removeClass().addClass('selected');
		//$("#comments").removeClass().addClass('non-selected');
	} else if (currentContent == 'comment') {
		$("#suppliers").removeClass().addClass('non-selected');
		$("#menu").removeClass().addClass('non-selected');
		$("#comments").removeClass().addClass('selected');
	}
	$("#add-item").removeClass().addClass('add-item');
}

function addSupplierResult(supplier, count) {
	/*
	var html = '';
	html +=	'<div class="menuitem">';
	
	supplierType = supplier.supplierType
	supplierType = supplierType.substring(0, 1);

	html +=	'	<div class="menuitemname">' + supplier.supplierName + ' (' + supplierType.toUpperCase() + ')' + '</div>';
	html +=	'</div>';
	
	*/
	
	var html =
	'<div style="overflow:auto; padding:5px;">' +
	'	<div style="float:left; width:220px;font-size:13px;"><a href="/' + supplier.supplierType + '/view/' + supplier.supplierReferenceId + '" style="font-size:13px;text-decoration:none;">'+ supplier.supplierName +'</a><br><b>Type:</b> '+ supplier.supplierType + '</div>' +
	'	<div style="float:left;width:60px;font-size:13px;"><b>Address:</b></div><div style="float:left;width:240px;font-size:13px;">';
	
	$.each(supplier.addresses, function(j, address) {
		if (j == 0) {
			html += '<em>' + address.displayAddress + '</em>';
		} else {
			html += "<br /><br />" + '<em>' + address.displayAddress + '</em>';
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

function drawRecordsPerPage2(params) {
	str = '';
	str +=  'Items per page: ';
	
	if (params.perPage == 10) {
		str += '<strong>10</strong> | ';
	} else {
		str += '<a href="#" id = "10PerPage2">10</a> | ';
	}
	
	if (params.perPage == 20) {
		str += '<strong>20</strong> | ';
	} else {
		str += '<a href="#" id = "20PerPage2">20</a> | ';
	}
	
	if (params.perPage == 40) {
		str += '<strong>40</strong> | ';
	} else {
		str += '<a href="#" id = "40PerPage2">40</a> | ';
	}
	
	if (params.perPage == 50) {
		str += '<strong>50</strong>';
	} else {
		str += '<a href="#" id = "50PerPage2">50</a>';
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

function drawPagingLinks2(params) {
	str = '';
	str += '<a href="#" id = "imgFirst2">First</a> &nbsp;&nbsp;';
	str += '<a href="#" id = "imgPrevious2">Previous</a> ';
	str += '&nbsp;&nbsp;&nbsp; Page ' + (parseInt(params.page)+1) + ' of ' + params.totalPages + '&nbsp;&nbsp;&nbsp;';
	str += '<a href="#" id = "imgNext2">Next</a> &nbsp;&nbsp;';
	str += '<a href="#" id = "imgLast2">Last</a>';
	
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

function reinitializePagingEvent(data) {
	$("#imgFirst").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#imgPrevious").click(function(e) {
		e.preventDefault();
		previousPage = parseInt(data.param.page)-1;
		if (previousPage <= 0) {
			previousPage = data.param.firstPage;
		}
		//loadPopupFadeIn();
		postAndRedrawContent(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#imgNext").click(function(e) {
		e.preventDefault();
		nextPage = parseInt(data.param.page)+1;
		if (nextPage >= data.param.totalPages) {
			nextPage = data.param.lastPage;
		}
		//loadPopupFadeIn();
		postAndRedrawContent(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#imgLast").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
}

function reinitializePageCountEvent(data) {
	$("#10PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 10, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#20PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 20, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#40PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 40, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#50PerPage").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 50, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
}

function reinitializePagingEvent2(data) {
	$("#imgFirst2").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#imgPrevious2").click(function(e) {
		e.preventDefault();
		previousPage = parseInt(data.param.page)-1;
		if (previousPage <= 0) {
			previousPage = data.param.firstPage;
		}
		//loadPopupFadeIn();
		postAndRedrawContent(previousPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#imgNext2").click(function(e) {
		e.preventDefault();
		nextPage = parseInt(data.param.page)+1;
		if (nextPage >= data.param.totalPages) {
			nextPage = data.param.lastPage;
		}
		//loadPopupFadeIn();
		postAndRedrawContent(nextPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#imgLast2").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.lastPage, data.param.perPage, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
}

function reinitializePageCountEvent2(data) {
	$("#10PerPage2").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 10, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#20PerPage2").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 20, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#40PerPage2").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 40, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
	
	$("#50PerPage2").click(function(e) {
		e.preventDefault();
		//loadPopupFadeIn();
		postAndRedrawContent(data.param.firstPage, 50, data.param.sort, data.param.order, data.param.q, data.param.filter, currentContent);
	});
}
