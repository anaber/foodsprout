<script>

$(document).ready(function() {
	
	/* ----------------------------------------------------
	 * City
	 * ----------------------------------------------------*/
	function findValueCallbackCity(event, data, formatted) {
		document.getElementById('cityId').value = data[1];
	}
	
	$("#cityAjax").result(findValueCallbackCity).next().click(function() {
		$(this).prev().search();
	});
	
	$("#cityAjax").autocomplete("/city/get_cities_based_on_state", {
		width: 260,
		selectFirst: false,
		cacheLength:0,
		extraParams: {
	       stateId: function() { return $("#stateId").val(); }
	   	}
	});
	
	$("#cityAjax").result(function(event, data, formatted) {
		if (data)
			$(this).parent().next().find("input").val(data[1]);
	});
	
	$("#clear").click(function() {
		$(":input").unautocomplete();
	});
	
	$("#farmForm").submit(function(e) {
		e.preventDefault();
		
		if ($("#farmForm").validationEngine('validate') ) {
			
			var formAction = '';
			var postArray = '';
			var act = '';
			
			var selectedCertifications = '';
			var j = 0;
		    $('#certificationId' + ' :selected').each(function(i, selected){
			    if (j == 0) {
			    	selectedCertifications += $(selected).val();
			    } else {
			    	selectedCertifications += ',' + $(selected).val();
			    }
			    j++;
			});
			
			var cityId = $('#cityId').val();
			var cityName;
			
			if (isNaN( cityId ) ) {
				cityName = cityId;
				cityId = '';
			}
			
			if ($('#farmersMarketId').val() != '' ) {
				var formAction = '/farmersmarket/save_update';
				postArray = {
							  farmersMarketName:$('#farmersMarketName').val(),
							  customUrl:$('#customUrl').val(),
							  url:$('#url').val(),
							  status:$('#status').val(),
							  facebook:$('#facebook').val(),
							  twitter:$('#twitter').val(),

							  farmersMarketId: $('#farmersMarketId').val()
							};
				act = 'update';		
			} else {
				formAction = '/farmersmarket/save_add';
				postArray = { 
							  farmersMarketName:$('#farmersMarketName').val(),
							  customUrl:$('#customUrl').val(),
							  url:$('#url').val(),
							  status:$('#status').val(),
							  facebook:$('#facebook').val(),
							  twitter:$('#twitter').val(),
							  
							  address:$('#address').val(),
							  
							  cityId:cityId,
							  cityName:cityName,
							  
							  stateId:$('#stateId').val(),
							  countryId:$('#countryId').val(),
							  zipcode:$('#zipcode').val()
							};
				act = 'add';
			}
			
			$.post(formAction, postArray,function(data) {
				var $alert = $('#alert');
				
				if(data=='yes') {
					message = 'Market Addedd Successfully';
					displayProcessingMessage($alert, message);
					displaySuccessMessage($alert, message);
					hideMessage($alert, '/dashboard', '');
				} else if(data == 'duplicate') {
					message = 'Duplicate Market';
					displayProcessingMessage($alert, message);
					displayFailedMessage($alert, message);
					hideMessage($alert, '', '');
				} else {
					message = 'Market cound not be added';
					displayProcessingMessage($alert, message);
					displayFailedMessage($alert, message);
					hideMessage($alert, '', '');
				}
			});
		} else {
			return false;
		}
		
		return false; //not to post the  form physically
		
	});	

});

</script>

<div id="alert"></div>
<!-- center tabs -->

	<div>
		<div style="float:left;width:530px;"><h1>Add Farmer's Market</h1></div>
		<div class="clear"></div>
		<hr size="1">
		<div class="clear"></div>
	</div>
	<div class = "clear"></div>
	
	<div id="resultsContainer" style = "border-style:solid;border-width:0px;border-color:#FF0000;">
		
		
		<form id = "farmForm" name = "farmForm" method="post" action = "">
		<table class="formTable" border = "0" width = "300">
			<tr>
				<td>
					<table class="formTable" border = "0" width = "300">
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Farmer's Market Name *</td>
							<td width = "25%">
								<input value="<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->farmersMarketName : '') ?>" class="validate[required]" type="text" name="farmersMarketName" id="farmersMarketName"/><br />
							</td>
						</tr>
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Website</td>
							<td width = "25%">
								<input value="<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->url : '') ?>" class="validate[optional]" type="text" name="website" id="website"/>
							</td>
						</tr>
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Facebook</td>
							<td width = "25%">
								<input value="<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->facebook : '') ?>" class="validate[optional]" type="text" name="facebook" id="facebook"/>
							</td>
						</tr>
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Twitter</td>
							<td width = "25%">
								<input value="<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->twitter : '') ?>" class="validate[optional]" type="text" name="twitter" id="twitter"/>
							</td>
						</tr>
						
						
					</table>
				</td>
				<td valign = "top">
					<table class="formTable" border = "0" width = "300">
						<tr>
							<td width = "25%" style = "font-size:13px;">Address *</td>
							<td width = "25%">
								<input value="<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->address : '') ?>" class="validate[required]" type="text" name="address" id="address"/><br />
							</td>
						</tr>
					
						<tr>
							<td width = "25%" style = "font-size:13px;">State *</td>
							<td width = "25%">
								<select name="stateId" id="stateId"  class="validate[required]">
								<option value = "">--State--</option>
								<?php
								foreach($STATES as $key => $value) {
									echo '<option value="'.$value->stateId.'"' . (  ( isset($FARMERS_MARKET) && ( $value->stateId == $FARMERS_MARKET->stateId )  ) ? ' SELECTED' : '' ) . '>'.$value->stateName.'</option>';
								}
								?>
								</select>
							</td>
						</tr>
					
						<tr>
							<td width = "25%" style = "font-size:13px;">City *</td>
							<td width = "25%">
								<input type="text" id="cityAjax" value="<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->cityName : '') ?>" class="validate[required]" />
							</td>
						</tr>
						
						<tr>
							<td width = "25%" style = "font-size:13px;">Country *</td>
							<td width = "25%">
								<select name="countryId" id="countryId"  class="validate[required]">
								<option value = "">--Country--</option>
								<?php
									foreach($COUNTRIES as $key => $value) {
										echo '<option value="'.$value->countryId.'"' . (  ( isset($FARMERS_MARKET) && ( $value->countryId == $FARMERS_MARKET->countryId )  ) ? ' SELECTED' : '' ) . '>'.$value->countryName.'</option>';
									}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td width = "25%" style = "font-size:13px;">Zip *</td>
							<td width = "25%">
								<input value="<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->zipcode : '') ?>" class="validate[required,length[1,6]]" type="text" name="zipcode" id="zipcode" /><br />
							</td>
						</tr>
						
						
					</table>
				</td>
			</tr>
			<tr>
				<td colspan = "2" align = "right">
					<input type = "submit" name = "btnSubmit" id = "btnSubmit" value = "Add Market">
				</td>
			</tr>
		</table>
		<input type = "hidden" name = "farmersMarketId" id = "farmersMarketId" value = "<?php echo (isset($FARMERS_MARKET) ? $FARMERS_MARKET->farmersMarketId : '') ?>">
		<input type = "hidden" name = "cityId" id = "cityId" value = "">
		</form>
		
		
		
	</div>
<!-- end center tabs -->