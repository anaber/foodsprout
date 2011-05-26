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
	
	$("#restaurantForm").submit(function(e) {
		e.preventDefault();
		
		if ($("#restaurantForm").validationEngine('validate') ) {
			
			var formAction = '';
			var postArray = '';
			var act = '';
			
			//alert($('#companyId').val());
			
			var selectedCuisines = '';
			var j = 0;
		    $('#cuisineId' + ' :selected').each(function(i, selected){
			    if (j == 0) {
			    	selectedCuisines += $(selected).val();
			    } else {
			    	selectedCuisines += ',' + $(selected).val();
			    }
			    j++;
			});
			
			var cityId = $('#cityId').val();
			var cityName;
			
			if (isNaN( cityId ) ) {
				cityName = cityId;
				cityId = '';
			}
			
			if ($('#restaurantId').val() != '' ) {
				var formAction = '/restaurant/save_update';
				postArray = {
							  restaurantName:$('#restaurantName').val(),
							  customUrl:$('#customUrl').val(),
							  restaurantTypeId:$('#restaurantTypeId').val(),
							  cuisineId:selectedCuisines,
							  
							  phone:$('#phone').val(),
							  fax:$('#fax').val(),
							  email:$('#email').val(),
							  url:$('#website').val(),
							  facebook:$('#facebook').val(),
							  twitter:$('#twitter').val(),
							  
							  status:$('#status').val(),
							  
							  restaurantId: $('#restaurantId').val()
							};
				act = 'update';		
			} else {
				formAction = '/restaurant/save_add';
				postArray = { 
							  restaurantName:$('#restaurantName').val(),
							  restaurantTypeId:$('#restaurantTypeId').val(),
							  cuisineId:selectedCuisines,
							  
							  phone:$('#phone').val(),
							  fax:$('#fax').val(),
							  email:$('#email').val(),
							  url:$('#website').val(),
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
					message = 'Restaurant Addedd Successfully';
					displayProcessingMessage($alert, message);
					displaySuccessMessage($alert, message);
					hideMessage($alert, '/dashboard', '');
				} else if(data == 'duplicate') {
					message = 'Duplicate Restaurant';
					displayProcessingMessage($alert, message);
					displayFailedMessage($alert, message);
					hideMessage($alert, '', '');
				} else {
					message = 'Restaurant cound not be added';
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
		<div style="float:left;width:530px;"><h1>Add Restaurant</h1></div>
		<div class="clear"></div>
		<hr size="1">
		<div class="clear"></div>
	</div>
	<div class = "clear"></div>
	
	<div id="resultsContainer" style = "border-style:solid;border-width:0px;border-color:#FF0000;">
		
		
		
		
		
		
		<form id="restaurantForm" method="post" action = "">
		<table class="formTable" border = "0" width = "300">
			<tr>
				<td>
					<table class="formTable" border = "0" width = "300">
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Restaurant Name *</td>
							<td width = "25%">
								<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantName : '') ?>" class="validate[required]" type="text" name="restaurantName" id="restaurantName"/><br />
							</td>
						</tr>
						
						<tr>
							<td width = "25%" style = "font-size:13px;">Restaurant Type *</td>
							<td width = "75%">
								<select name="restaurantTypeId" id="restaurantTypeId"  class="validate[required]">
								<option value = "">--Restaurant Type--</option>
								<?php
								foreach($RESTAURANT_TYPES as $key => $value) {
									echo '<option value="'.$value->restaurantTypeId.'"' . (  ( isset($RESTAURANT) && ( $value->restaurantTypeId == $RESTAURANT->restaurantTypeId )  ) ? ' SELECTED' : '' ) . '>'.$value->restaurantTypeName.'</option>';
								}
								?>
								</select>
							</td>
						</tr>
						
						<tr>
							<td width = "25%" style = "font-size:13px;">Cuisine *</td>
							<td width = "75%">
								<select name="cuisineId" id="cuisineId"  class="validate[required]" multiple size = "4">
								<option value = "">--Cuisine--</option>
								<?php
								foreach($CUISINES as $key => $value) {
									echo '<option value="'.$value->cuisineId.'"' . (  ( isset($RESTAURANT) && in_array($value->cuisineId, $RESTAURANT->cuisines) ) ? ' SELECTED' : '' ) . '>'.$value->cuisineName.'</option>';
								}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Phone</td>
							<td width = "75%">
								<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->phone : '') ?>" class="validate[optional]" type="text" name="phone" id="phone"/>
							</td>
						</tr>
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Fax</td>
							<td width = "75%">
								<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->fax : '') ?>" class="validate[optional]" type="text" name="fax" id="fax"/>
							</td>
						</tr>
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">E-Mail</td>
							<td width = "75%">
								<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->email : '') ?>" class="validate[optional,custom[email]]" type="text" name="email" id="email"/>
							</td>
						</tr>
						
					</table>
				</td>
				<td valign = "top">
					<table class="formTable" border = "0" width = "300">
						<tr>
							<td width = "25%" style = "font-size:13px;">Address *</td>
							<td width = "25%">
								<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->address : '') ?>" class="validate[required]" type="text" name="address" id="address"/><br />
							</td>
						</tr>
					
						<tr>
							<td width = "25%" style = "font-size:13px;">State *</td>
							<td width = "25%">
								<select name="stateId" id="stateId"  class="validate[required]">
								<option value = "">--State--</option>
								<?php
								foreach($STATES as $key => $value) {
									echo '<option value="'.$value->stateId.'"' . (  ( isset($RESTAURANT) && ( $value->stateId == $RESTAURANT->stateId )  ) ? ' SELECTED' : '' ) . '>'.$value->stateName.'</option>';
								}
								?>
								</select>
							</td>
						</tr>
					
						<tr>
							<td width = "25%" style = "font-size:13px;">City *</td>
							<td width = "25%">
								<input type="text" id="cityAjax" value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->cityName : '') ?>" class="validate[required]" />
							</td>
						</tr>
						
						<tr>
							<td width = "25%" style = "font-size:13px;">Country *</td>
							<td width = "25%">
								<select name="countryId" id="countryId"  class="validate[required]">
								<option value = "">--Country--</option>
								<?php
									foreach($COUNTRIES as $key => $value) {
										echo '<option value="'.$value->countryId.'"' . (  ( isset($RESTAURANT) && ( $value->countryId == $RESTAURANT->countryId )  ) ? ' SELECTED' : '' ) . '>'.$value->countryName.'</option>';
									}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td width = "25%" style = "font-size:13px;">Zip *</td>
							<td width = "25%">
								<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->zipcode : '') ?>" class="validate[required,length[1,6]]" type="text" name="zipcode" id="zipcode" /><br />
							</td>
						</tr>
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Website</td>
							<td width = "25%">
								<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->url : '') ?>" class="validate[optional]" type="text" name="website" id="website"/>
							</td>
						</tr>
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Facebook</td>
							<td width = "25%">
								<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->facebook : '') ?>" class="validate[optional]" type="text" name="facebook" id="facebook"/>
							</td>
						</tr>
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Twitter</td>
							<td width = "25%">
								<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->twitter : '') ?>" class="validate[optional]" type="text" name="twitter" id="twitter"/>
							</td>
						</tr>
						
					</table>
				</td>
			</tr>
			<tr>
				<td colspan = "2" align = "right">
					<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "Add Restaurant">
				</td>
			</tr>
		</table>
		<input type = "hidden" name = "restaurantId" id = "restaurantId" value = "<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantId : '') ?>">
		<input type = "hidden" name = "cityId" id = "cityId" value = "">
		</form>
		
		
		
	</div>
<!-- end center tabs -->