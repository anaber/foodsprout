function addSupplierResult(supplier, count) {
	var html =
	'<div style="overflow:auto; padding-bottom:10px;">'; 
	
	html += 
	'	<div class = "listing-supplier-information">'+
	'		<a href="/' + supplier.supplierType + '/' + supplier.supplierCustomUrl + '" style="font-size:13px;text-decoration:none;">'+ supplier.supplierName +'</a><br><b>Type:</b> '+ supplier.supplierType + 
	'	</div>' + 
	'	<div class = "listing-address-title">' + 
	'		<b>Parent:</b><br /><b>Type:</b>'+
	'	</div>'+
	'	<div class = "listing-address">'+
	'		<a href="/' + supplier.parentType + '/' + supplier.supplieeCustomUrl + '" style="font-size:13px;text-decoration:none;">'+ supplier.parentName +'</a><br>'+ supplier.parentType + 
	'	</div>'+
	'	<div class = "listing-address-title">' + supplier.status + '</div>' +
	'	<div class = "listing-address-title">&nbsp;</div>' +
	'	<div class = "listing-address-title">' + supplier.ip + '</div>' +
	'	<div class = "clear"></div>';
	
	html +=
	'</div>' +
	'<div class = "clear"></div>'
	;
	
	return html;
}