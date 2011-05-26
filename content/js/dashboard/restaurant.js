function addRestaurantResult(producer, count) {
	var html =
	'<div style="overflow:auto; padding-bottom:10px;">'; 
	
	html += 
	'	<div class = "listing-supplier-information">';
	
	if (producer.customUrl != '') {
		html += 
		'		<a href="/' + producer.type + '/' + producer.customUrl + '" style="font-size:13px;text-decoration:none;">'+ producer.producer +'</a>';
	} else {
		html += 
		'		<a href="/' + producer.type + '/view/' + producer.producerId + '" style="font-size:13px;text-decoration:none;">'+ producer.producer +'</a>';
	} 
	
	html += 
	'	</div>' + 
	'	<div class = "listing-address-title">' + 
	'		<b>Address</b>'+
	'	</div>'+
	'	<div class = "listing-address">';
	 
	$.each(producer.addresses, function(j, address) {
		if (j == 0) {
			html += address.displayAddress ;
		} else {
			html += "<br /><br />" + address.displayAddress ;
		}
	});
	
	html +=
	'	</div>'+
	'	<div class = "listing-address-title">' + producer.status + '</div>' +
	'	<div class = "listing-address-title">&nbsp;</div>' +
	//'	<div class = "listing-address-title">' + producer.ip + '</div>' +
	'	<div class = "clear"></div>';
	
	html +=
	'</div>' +
	'<div class = "clear"></div>'
	;
	
	return html;
}