
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/user/ajaxSearchUsers", { },
		function(data){
			$('#suggestion_box').val('');
			
			redrawContent(data);
		},
		"json");
		
	$("#suggestion_box").keyup(function() {
		var query = $("#suggestion_box").val();
		
		if ( query.length >= 3 || query.length == 0 ) {
			$('#resultsContainer').hide();
			$('#messageContainer').show();
			$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
			
			$.post("/admincp/user/ajaxSearchUsers", { q:query },
			function(data){
				redrawContent(data);
	      	},
	      	"json");
      	}
      	
	});

});

function postAndRedrawContent(page, perPage, s, o, query) {
	
	$('#resultsContainer').hide();
	$('#messageContainer').show();
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	var formAction = '/admincp/user/ajaxSearchUsers';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
	},
	"json");
}


function reinitializeTableHeadingEvent(data) {
	$("#heading_id").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'user_id');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'user_id', order, data.param.q);
	});
	
	$("#heading_email").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'email');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'email', order, data.param.q);
	});
	
	$("#heading_firstName").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'first_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'first_name', order, data.param.q);
	});
	
	$("#heading_zipcode").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'zipcode');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'zipcode', order, data.param.q);
	});
	
	$("#heading_join_date").click(function(e) {
		e.preventDefault();
		order = getOrder(data, 'join_date');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'join_date', order, data.param.q);
	});
}

function addResult(user, i) {
	var html =
	'<tr>' +
	'	<td valign="top"><a href="/admincp/user/update/'+ user.userId +'">'+ user.userId +'</a></td>' +
	'	<td valign="top"><a href="/admincp/user/update/'+ user.userId +'">'+ user.email +'</a></td>' +
	'	<td valign="top">'+ user.firstName +'</a></td>' +
	'	<td valign="top">'+ user.zipcode +'</a></td>' +
	'	<td valign="top">'+ user.joinDate +'</td>';
	
	html +=
	'</tr>';
	
	return html;
}

function getResultTableHeader() {
	var html =
	' <table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "99%">' +
	'	<thead>' +
	'	<tr>' +
	'		<th id = "heading_id"><a href = "#" style = "color:#FFFFFF">Id</a></th>' +
	'		<th id = "heading_user"><a href = "#" style = "color:#FFFFFF">Email</a></th>' +
	'		<th id = "heading_firstName"><a href = "#" style = "color:#FFFFFF">First Name</a></th>' +
	'		<th id = "heading_zipcode"><a href = "#" style = "color:#FFFFFF">Zipcode</a></th>' +
	'		<th id = "heading_user_type"><a href = "#" style = "color:#FFFFFF">Join Date</a></th>' +
	'	</tr>' +
	'	</thead>' +
	'	<tbody>';

	return html;
}

