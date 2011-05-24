
$(document).ready(function() {
	
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
	
	$.post("/admincp/photos/ajaxSearchPhotos", { },
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
			
			$.post("/admincp/photos/ajaxSearchPhotos", { q:query },
			function(data){
				redrawContent(data);
	      	},
	      	"json");
      	}
      	
	});	
	
});

function postAndRedrawContent(page, perPage, s, o, query, selectedFilter, currentFilter) {
	
	$('#resultsContainer').hide();
	$('#messageContainer').show();
	$('#messageContainer').addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
		
	var formAction = '/admincp/photos/ajaxSearchPhotos';
	
	postArray = { p:page, pp:perPage, sort:s, order:o, q:query, filter:selectedFilter};
	
	$.post(formAction, postArray,function(data) {		
		redrawContent(data);
		$('#'+currentFilter).removeClass('filter-selected');
		$('#'+selectedFilter).addClass('filter-selected');
	},
	"json");
}


function reinitializeTableHeadingEvent(data) {	
	
	$("#date").click(function(e) {
		e.preventDefault();
		
		if ($(".filter-selected")[0] != undefined) {
			filter = $(".filter-selected")[0].id;			
		} else {
			filter = "all";
		}
		order = getOrder(data, 'added_on');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'added_on', order, data.param.q, filter, filter);
	});
	
	$("#uploader").click(function(e) {
		e.preventDefault();
		if ($(".filter-selected")[0] != undefined) {
			filter = $(".filter-selected")[0].id;			
		} else {
			filter = "all";
		}
		order = getOrder(data, 'first_name');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'first_name', order, data.param.q, filter, filter);
	});
	
	$("#all").click(function(e) {
		e.preventDefault();
		if ($(".filter-selected") !== undefined) {
			filter = "all";
		} else {			
			filter = $(".filter-selected")[0].id;		
		}
		order = getOrder(data, 'adden_on');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'added_on', order, data.param.q, $(this)[0].id, filter);
	});
	
	$("#live").click(function(e) {
		e.preventDefault();
		if ($(".filter-selected") !== undefined) {
			filter = "all";
		} else {			
			filter = $(".filter-selected")[0].id;		
		}
		order = getOrder(data, 'adden_on');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'added_on', order, data.param.q, $(this)[0].id, filter);
	});
	
	$("#queue").click(function(e) {
		e.preventDefault();		
		if ($(".filter-selected") !== undefined) {
			filter = "all";
		} else {			
			filter = $(".filter-selected")[0].id;		
		}
		order = getOrder(data, 'adden_on');
		postAndRedrawContent(data.param.firstPage, data.param.perPage, 'added_on', order, data.param.q, $(this)[0].id, filter);
	});
	
	$("input.delete").click(function(e){
		var parent = $(this).parent();
		e.preventDefault();		
		var r = confirm("Are you sure you want to delete this photo?");
		
		if (r) {
			var row = $('#photo-'+parent.attr('id'));
			$.ajax({
                type: 'post',
                url: '/admincp/photos/photoAction',
                data: 'photo=' + parent.attr('id')+'&action=delete',
                beforeSend: function() {
					row.addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
                },
                success: function() {
                	$.post("/admincp/photos/ajaxSearchPhotos", { },
                			function(data){
                				$('#suggestion_box').val('');			
                				redrawContent(data);
                			},
                			"json");
                }
            });
		}
	});
	
	$("input.approve").click(function(e) {
		var parent = $(this).parent();
		e.preventDefault();
		
		var r = confirm("Are you sure you want approve this photo?");
		
		if (r) {
			var row = $('#photo-'+parent.attr('id'));
			$.ajax({
                type: 'post',
                url: '/admincp/photos/photoAction',
                data: 'photo=' + parent.attr('id')+'&action=approve',
                beforeSend: function() {
					row.addClass('center').html('<img src="/img/loading_pink_bar.gif" />');
                },
                success: function() {
                	$.post("/admincp/photos/ajaxSearchPhotos", { },
                			function(data){
                				$('#suggestion_box').val('');			
                				redrawContent(data);
                			},
                			"json");
                }
            });
		}
		
	});
	
}

function addResult(photos, i) {
	var html =
	'<div id="photo-'+photos.photoId+'" class="img-container"> ' +
	'	<div class="img">' +
	' 		<a href="'+photos.photo+'" rel="lightbox" title="'+photos.description+'" style="text-decoration:none; color: transparent;">' +
	'			<img src="'+ photos.photo +'" height="120" width="120" />' +
	' 		</a>' +
	'	</div>' +
	'	<div class="desc">' +
	'		<div>By: '+ photos.firstName +'</div>' +
	'		<div>on '+ photos.addedOn +'</div>' +
	'		<div id="'+ photos.photoId +'"> ';
	if (photos.status == 'queue') 
	{
		html += '<span style="font-style: italic">pending</span>' +
		'<input type="image" src="/images/check.png" height="18" width="18" title="approve" class="approve" />' 
		;
	}
	html +=
	' 			<input type="image" src="/images/trash.png" height="18" width="18" title="delete" class="delete" />' +
	' 		</div>' +
	'	</div>' +
	'</div>';
	
	return html;
}

function getResultTableHeader() {
	var html = 
	'<div id="tbllist">' +
	'	<div class="gallery-header">' +
	'   <div class="filter">Filter:' +
	'		<a id="all" href="#">All</a>,' +
	'		<a id ="live" href="#">Live</a>,' +
	'		<a id="queue" href="#">Queue</a>' +	
	'	</div>' +
	'   <div class="sort">Sort By:' +
	'		<a id="date" href="#" >Added Date<a>,' +
	'		<a id="uploader" href="#">Uploader</a>' +
	'	</div>' +
	'	<div style="clear:both;"></div>' +
	'	</div>';
	

	return html;
}

