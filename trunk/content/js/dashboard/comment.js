//addCommentResult
function addCommentResult(comment, count) {
	var html =
	'<div style="overflow:auto; padding-bottom:10px;">'; 
	
	html += 
	'	<div class = "listing-supplier-information">';
	
	html += comment.comment;
	/*
	if (producer.customUrl != '') {
		html += 
		'		<a href="/' + producer.type + '/' + producer.customUrl + '" style="font-size:13px;text-decoration:none;">'+ producer.producer +'</a>';
	} else {
		html += 
		'		<a href="/' + producer.type + '/view/' + producer.producerId + '" style="font-size:13px;text-decoration:none;">'+ producer.producer +'</a>';
	} 
	*/
	html += 
	'	</div>' +
	'	<div class = "listing-supplier-information">' + comment.addedOn + '</div>' +
	'	<div class = "listing-address-title">' + comment.status + '</div>' +
	'	<div class = "listing-address-title">&nbsp;</div>' +
	'	<div class = "listing-address-title">' + comment.ip + '</div>' +
	'	<div class = "clear"></div>';
	
	html +=
	'</div>' +
	'<div class = "clear"></div>'+
	'<hr size="1" class="listing-dash-line1">' +
	'<div class = "clear"></div>'
	;
	
	return html;
}