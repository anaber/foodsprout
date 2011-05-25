function addMenuResult(product, count) {
	var html = '';
	
	html +=	'<div class="menuitem">';
	//html +=	'	<div class="menuitemimg"><img src="/img/img1.jpg" width="132" height="107" alt="receipe" />';
	
	html +=	'	<div class="menuitemimg">';
	if (product.image) {
		html +=	'<img src="' + product.image + '" width="132" height="107" alt="receipe" />';
	}
	
	html += '	</div>';
	html +=	'	<div class="menuitemname">' + product.productName + '</div>';
	html +=	'	<div class="menuitemdetails">' + product.ingredient + '</div>';
	html +=	'	<div class="menuitemdetails">';
	html += '		<div style="float:left; width:270px;font-size:13px;border-style:solid;border-width:0px;border-color:#FF0000;">';
	if (product.producerType == 'restaurant') {
		html += '<b>Restaurant: </b>';
	} else if (product.producerType == 'chain') {
		html += '<b>Chain: </b>';
	} else if (product.producerType == 'manufacture') {
		html += '<b>Manufacture: </b>';
	}
	html += '			<a href = "/' + product.producerType + '/'+product.customUrl+'" style="font-size:13px;text-decoration:none;">' + product.producer + '</a>';
	
	html += '		</div>';
	html += '		<div style="float:left; width:270px;font-size:13px;border-style:solid;border-width:0px;border-color:#00FF00;"><b>Status: </b>' + product.status + '</div>';
	html += '	</div>';
	html +=	'</div>';
	
	return html;
}