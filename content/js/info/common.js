var isSupplierFormVisible = false;
var isMenuFormVisible = false;
var isCommentFormVisible = false;
var isPhotoFormVisible = false;
	
function reinitializeTabs() {
	data = jsonData;
	$("#suppliers").click(function(e) {
		e.preventDefault();
		$.validationEngine.closePrompt('.formError',true);
		//$("#divAddMenu").hide( { duration: toggleDuration } );
		$('#divAddMenu').stop(true, false).fadeOut(200);
		isMenuFormVisible = false;
		if(window.resetMenuForm) {
			resetMenuForm();
		}
		
		//$("#divAddComment").hide( { duration: toggleDuration } );
		$('#divAddComment').stop(true, false).fadeOut(200);
		isCommentFormVisible = false;
		if(window.resetCommentForm) {
			resetCommentForm();
		}
		
		//$("#divAddPhoto").hide( { duration: toggleDuration } );
		$('#divAddPhoto').stop(true, false).fadeOut(200);
		isPhotoFormVisible = false;
		if(window.resetPhotoForm) {
			resetPhotoForm();
		}
		
		$('#divLoginMessage').stop(true, false).fadeOut(200);
		isLoginMessageVisible = false;
		
		$('#bottomPaging').hide();
		
		postAndRedrawContent(data.param.firstPage, data.param.perPage, '', '', data.param.q, data.param.filter, 'supplier');
	});
	
	$("#menu").click(function(e) {
		e.preventDefault();
		$.validationEngine.closePrompt('.formError',true);
		//$("#divAddSupplier").hide( { duration: toggleDuration } );
		$('#divAddSupplier').stop(true, false).fadeOut(200);
		isSupplierFormVisible = false;
		if(window.resetSupplierForm) {
			resetSupplierForm();
		}
		
		//$("#divAddComment").hide( { duration: toggleDuration } );
		$('#divAddComment').stop(true, false).fadeOut(200);
		isCommentFormVisible = false;
		if(window.resetCommentForm) {
			resetCommentForm();
		}
		
		//$("#divAddPhoto").hide( { duration: toggleDuration } );
		$('#divAddPhoto').stop(true, false).fadeOut(200);
		isPhotoFormVisible = false;
		if(window.resetPhotoForm) {
			resetPhotoForm();
		}
		
		$('#divLoginMessage').stop(true, false).fadeOut(200);
		isLoginMessageVisible = false;
		
		$('#bottomPaging').hide();
		
		postAndRedrawContent(data.param.firstPage, data.param.perPage, '', '', data.param.q, data.param.filter, 'menu');
	});
	
	
	$("#comments").click(function(e) {
		e.preventDefault();
		$.validationEngine.closePrompt('.formError',true);
		//$("#divAddSupplier").hide( { duration: toggleDuration } );
		$('#divAddSupplier').stop(true, false).fadeOut(200);
		isSupplierFormVisible = false;
		if(window.resetSupplierForm) {
			resetSupplierForm();
		}
		
		//$("#divAddMenu").hide( { duration: toggleDuration } );
		$('#divAddMenu').stop(true, false).fadeOut(200);
		isMenuFormVisible = false;
		if(window.resetMenuForm) {
			resetMenuForm();
		}
		
		//$("#divAddPhoto").hide( { duration: toggleDuration } );
		$('#divAddPhoto').stop(true, false).fadeOut(200);
		isPhotoFormVisible = false;
		if(window.resetPhotoForm) {
			resetPhotoForm();
		}
		
		$('#divLoginMessage').stop(true, false).fadeOut(200);
		isLoginMessageVisible = false;
		
		$('#bottomPaging').hide();
		
		postAndRedrawContent(data.param.firstPage, data.param.perPage, '', '', data.param.q, data.param.filter, 'comment');
	});
	
	$("#photos").click(function(e) {
		e.preventDefault();
		$.validationEngine.closePrompt('.formError',true);
		//$("#divAddSupplier").hide( { duration: toggleDuration } );
		$('#divAddSupplier').stop(true, false).fadeOut(200);
		isSupplierFormVisible = false;
		if(window.resetSupplierForm) {
			resetSupplierForm();
		}
		
		//$("#divAddMenu").hide( { duration: toggleDuration } );
		$('#divAddMenu').stop(true, false).fadeOut(200);
		isMenuFormVisible = false;
		if(window.resetMenuForm) {
			resetMenuForm();
		}
		
		//$("#divAddComment").hide( { duration: toggleDuration } );
		$('#divAddComment').stop(true, false).fadeOut(200);
		isCommentFormVisible = false;
		if(window.resetCommentForm) {
			resetCommentForm();
		}
		
		$('#divLoginMessage').stop(true, false).fadeOut(200);
		isLoginMessageVisible = false;
		
		$('#bottomPaging').hide();
		
		postAndRedrawContent(data.param.firstPage, data.param.perPage, '', '', data.param.q, data.param.filter, 'photo');
	});
	
}

function reinitializeAddItemEvent(data) {
	
	$("#addSupplier").click(function(e) {
		e.preventDefault();
		if (isAuthenticated == true) {
			if (isSupplierFormVisible == true) {
				$.validationEngine.closePrompt('.formError',true);
				$(this).removeClass('active');
				$('#divAddSupplier').stop(true, false).fadeOut(200);
				isSupplierFormVisible = false;
			} else if (isSupplierFormVisible == false) {
				$(this).addClass('active');
				$('#divAddSupplier').stop(true, false).fadeIn(200);
				isSupplierFormVisible = true;
			}
		} else {
			if (isLoginMessageVisible == true) {
				$(this).removeClass('active');
				$('#divLoginMessage').stop(true, false).fadeOut(200);
				isLoginMessageVisible = false;
			} else if (isLoginMessageVisible == false) {
				$(this).addClass('active');
				$('#divLoginMessage').stop(true, false).fadeIn(200);
				isLoginMessageVisible = true;
			}
		}
	});
	
	$("#addSupplier2").click(function(e) {
		e.preventDefault();
		if (isAuthenticated == true) {
			if (isSupplierFormVisible == true) {
				$.validationEngine.closePrompt('.formError',true);
				$("#addSupplier").removeClass('active');
				$('#divAddSupplier').stop(true, false).fadeOut(200);
				isSupplierFormVisible = false;
			} else if (isSupplierFormVisible == false) {
				$("#addSupplier").addClass('active');
				$('#divAddSupplier').stop(true, false).fadeIn(200);
				isSupplierFormVisible = true;
			}
		} else {
			if (isLoginMessageVisible == true) {
				$("#addSupplier").removeClass('active');
				$('#divLoginMessage').stop(true, false).fadeOut(200);
				isLoginMessageVisible = false;
			} else if (isLoginMessageVisible == false) {
				$("#addSupplier").addClass('active');
				$('#divLoginMessage').stop(true, false).fadeIn(200);
				isLoginMessageVisible = true;
			}
		}
	});
	
	$("#addMenu").click(function(e) {
		e.preventDefault();
		
		if (isAuthenticated == true) {
			if (isMenuFormVisible == true) {
				$.validationEngine.closePrompt('.formError',true);
				$(this).removeClass('active');
				$('#divAddMenu').stop(true, false).fadeOut(200);
				isMenuFormVisible = false;
			} else if (isMenuFormVisible == false) {
				$(this).addClass('active');
				$('#divAddMenu').stop(true, false).fadeIn(200);
				isMenuFormVisible = true;
			}
		} else {
			if (isLoginMessageVisible == true) {
				$(this).removeClass('active');
				$('#divLoginMessage').stop(true, false).fadeOut(200);
				isLoginMessageVisible = false;
			} else if (isLoginMessageVisible == false) {
				$(this).addClass('active');
				$('#divLoginMessage').stop(true, false).fadeIn(200);
				isLoginMessageVisible = true;
			}
		}
	});
	
	$("#addMenu2").click(function(e) {
		e.preventDefault();
		if (isAuthenticated == true) {
			if (isMenuFormVisible == true) {
				$.validationEngine.closePrompt('.formError',true);
				$("#addMenu").removeClass('active');
				$('#divAddMenu').stop(true, false).fadeOut(200);
				isMenuFormVisible = false;
				
			} else if (isMenuFormVisible == false) {
				$("#addMenu").addClass('active');
				$('#divAddMenu').stop(true, false).fadeIn(200);
				isMenuFormVisible = true;
			}
		} else {
			if (isLoginMessageVisible == true) {
				$("#addMenu").removeClass('active');
				$('#divLoginMessage').stop(true, false).fadeOut(200);
				isLoginMessageVisible = false;
			} else if (isLoginMessageVisible == false) {
				$("#addMenu").addClass('active');
				$('#divLoginMessage').stop(true, false).fadeIn(200);
				isLoginMessageVisible = true;
			}
		}
	});	
	
	$("#addPhoto").click(function(e) {
		e.preventDefault();
		if (isAuthenticated == true) {
			if (isPhotoFormVisible == true) {
				$.validationEngine.closePrompt('.formError',true);
				$(this).removeClass('active');
				$('#divAddPhoto').stop(true, false).fadeOut(200);
				isPhotoFormVisible = false;
			} else if (isPhotoFormVisible == false) {
				$(this).addClass('active');
				$('#divAddPhoto').stop(true, false).fadeIn(200);
				isPhotoFormVisible = true;
			}
		} else {
			if (isLoginMessageVisible == true) {
				$(this).removeClass('active');
				$('#divLoginMessage').stop(true, false).fadeOut(200);
				isLoginMessageVisible = false;
			} else if (isLoginMessageVisible == false) {
				$(this).addClass('active');
				$('#divLoginMessage').stop(true, false).fadeIn(200);
				isLoginMessageVisible = true;
			}
		}
	});
	
	$("#addPhoto2").click(function(e) {
		e.preventDefault();
		if (isAuthenticated == true) {
			if (isPhotoFormVisible == true) {
				$.validationEngine.closePrompt('.formError',true);
				$("#addPhoto").removeClass('active');
				$('#divAddPhoto').stop(true, false).fadeOut(200);
				isPhotoFormVisible = false;
			} else if (isPhotoFormVisible == false) {
				$("#addPhoto").addClass('active');
				$('#divAddPhoto').stop(true, false).fadeIn(200);
				isPhotoFormVisible = true;
			}
		} else {
			if (isLoginMessageVisible == true) {
				$("#addPhoto").removeClass('active');
				$('#divLoginMessage').stop(true, false).fadeOut(200);
				isLoginMessageVisible = false;
			} else if (isLoginMessageVisible == false) {
				$("#addPhoto").addClass('active');
				$('#divLoginMessage').stop(true, false).fadeIn(200);
				isLoginMessageVisible = true;
			}
		}
	});
}

function changeSelectedTab() {
	if (currentContent == 'supplier') {
		$("#suppliers").removeClass().addClass('selected');
		$("#menu").removeClass().addClass('non-selected');
		$("#comments").removeClass().addClass('non-selected');
		$("#photos").removeClass().addClass('non-selected');
	} else if (currentContent == 'menu') {
		$("#suppliers").removeClass().addClass('non-selected');
		$("#menu").removeClass().addClass('selected');
		$("#comments").removeClass().addClass('non-selected');
		$("#photos").removeClass().addClass('non-selected');
	} else if (currentContent == 'comment') {
		$("#suppliers").removeClass().addClass('non-selected');
		$("#menu").removeClass().addClass('non-selected');
		$("#comments").removeClass().addClass('selected');
		$("#photos").removeClass().addClass('non-selected');
	} else if (currentContent == 'photo') {
		$("#suppliers").removeClass().addClass('non-selected');
		$("#menu").removeClass().addClass('non-selected');
		$("#comments").removeClass().addClass('non-selected');
		$("#photos").removeClass().addClass('selected');
	}
	$("#add-item").removeClass().addClass('add-item');
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


function addCommentResult(comment, count) {
	var html =
	'	<div style="width:520px;font-size:13px;border: red 0px solid;padding:5px;" align = "justify"><strong>' + comment.firstName + ':</strong>&nbsp;'+comment.comment+'<br /><div style="font-size:11px;font-weight:bold;">On '+comment.addedOn+'</div></div>' +
	'<hr size = "1" style="width:530px;">';
	return html;
}

function addCommentForm() {
	var html = '';
	
	if (isAuthenticated == true) {
		html = '<form id="commentForm" method="post">' + 
				'	<div style="width:520px;font-size:13px;border: red 0px solid;padding:5px;">' +
				'		<textarea class="limited validate[required]" maxlength="300" style = "width:520px;height:40px;" id = "txtComment"></textarea>' +
				'	</div>' +
				'	<div style="width:320px;font-size:11px;border: red 0px solid;float:left;padding-left:7px;" align = "left" id = "charsRemaining">' +
				'		<div class="charsLeft" style = "float:left">300</div><div style = "float:left">&nbsp;characters remaining</div>' +
				'	</div>' +
				'	<div style="width:205px;font-size:13px;border: red 0px solid;float:left;" align = "right">' +
				'		<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "Post Comment" style = "width:140px;">' +
				'	</div>' +
				'	<input type = "hidden" name = "manufactureId" id = "manufactureId" value = "">' +
				'	<input type = "hidden" name = "farmId" id = "farmId" value = "">' +
				'	<input type = "hidden" name = "restaurantId" id = "restaurantId" value = "">' +
				'	<input type = "hidden" name = "distributorId" id = "distributorId" value = "">' +
				'	<input type = "hidden" name = "restaurantChainId" id = "restaurantChainId" value = "">' +
				'	<input type = "hidden" name = "farmersMarketId" id = "farmersMarketId" value = "">' +
				'</form>';
	} else {
		html = '<div style="width:520px;font-size:13px;border: red 0px solid;padding:5px;height:30px;"><div style="font-size:13px;border: #ccc 1px solid;width:520px;height:30px;padding-top:15px;float:left" align = "center">You are not logged in. Please <a href = "/login" style="font-size:13px;text-decoration:none;">sign-in</a> or <a href = "/login" style="font-size:13px;text-decoration:none;">register</a> to post comment.</div></div>';
	}
	return html;
}

function reinitializeCommentCharacterCount() {
	$('textarea.limited').maxlength({
		'feedback' : '.charsLeft' // note: looks within the current form
	});
}

function reinitializeSubmitCommentForm() {
	var formValidated = true;

	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#commentForm").validationEngine({
		scroll:false,
		unbindEngine:false,
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	$("#commentForm").submit(function() {
		
		if (formValidated == false) {
			// Don't post the form.
			//displayFailedMessage($alert, "Form validation failed...");
			//hideMessage($alert, '', '');
		} else {
			
			var $alert = $('#alert');
			displayProcessingMessage($alert, "Processing...");
			
			var formAction = '';
			var postArray = '';
			var act = '';
			
			if ($('#supplierId').val() != '' ) {
				var formAction = '/common/comment_save_update';
				postArray = {
							  comment: $('#txtComment').val(),
							  
							  manufactureId: $('#manufactureId').val(),
							  farmId: $('#farmId').val(),
							  restaurantId: $('#restaurantId').val(),
							  distributorId: $('#distributorId').val(),
							  restaurantChainId: $('#restaurantChainId').val(),
							  farmersMarketId: $('#farmersMarketId').val(),
							   
							  commentId: $('#commentId').val()
							};
				act = 'update';		
			} else {
				formAction = '/common/comment_save_add';
				postArray = { 
							  comment: $('#txtComment').val(),
							  
							  manufactureId: $('#manufactureId').val(),
							  farmId: $('#farmId').val(),
							  restaurantId: $('#restaurantId').val(),
							  distributorId: $('#distributorId').val(),
							  restaurantChainId: $('#restaurantChainId').val(),
							  farmersMarketId: $('#farmersMarketId').val()
							};
				act = 'add';
			}
			
			$.post(formAction, postArray,function(data) {
				
				if(data=='yes') {
					if (act == 'add') {
						displayFailedMessage($alert, "Comment added...");
					} else if (act == 'update') {
						displayFailedMessage($alert, "Comment updated...");
					}
					hideMessage($alert, '', '');
					$.validationEngine.closePrompt('.formError',true);
				} else if(data == 'duplicate') {
					displayFailedMessage($alert, "Duplicate Comment...");
					hideMessage($alert, '', '');
				} else {
					if (act == 'add') {
						displayFailedMessage($alert, "Not added...");
					} else if (act == 'update') {
						displayFailedMessage($alert, "Not updated...");
					}
					hideMessage($alert, '', '');
				}
			});
			
		}
		return false; //not to post the  form physically
	});
}
