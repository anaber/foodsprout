<script>

formValidated = true;

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
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#farmForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	$("#farmForm").submit(function(e) {
		e.preventDefault();
		
		
		if (formValidated == false) {
			
		} else {
			
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
			
			if ($('#farmId').val() != '' ) {
				var formAction = '/farm/save_update';
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
							  
							  farmId: $('#farmId').val()
							};
				act = 'update';		
			} else {
				formAction = '/farm/save_add';
				postArray = { 
							  farmName:$('#farmName').val(),
							  farmTypeId:$('#farmTypeId').val(),
							  farmCropId:$('#farmCropId').val(),
							  certificationId:selectedCertifications,
							  
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
					message = 'Farm Addedd Successfully';
					displayProcessingMessage($alert, message);
					displaySuccessMessage($alert, message);
					hideMessage($alert, '/dashboard', '');
				} else {
					message = 'Farm cound not be added';
					displayProcessingMessage($alert, message);
					displayFailedMessage($alert, message);
					hideMessage($alert, '', '');
				}
				
			});
		}
		
		return false; //not to post the  form physically
		
	});	

});

</script>

<div id="alert"></div>
<!-- center tabs -->

	<div>
		<div style="float:left;width:530px;"><h1>Add Farm</h1></div>
		<div class="clear"></div>
		<hr size="1">
		<div class="clear"></div>
	</div>
	<div class = "clear"></div>
	
	<div id="resultsContainer" style = "border-style:solid;border-width:0px;border-color:#FF0000;">
		
		
		<form id="farmForm" method="post" action = "">
		<table class="formTable" border = "0" width = "300">
			<tr>
				<td>
					<table class="formTable" border = "0" width = "300">
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Farm Name *</td>
							<td width = "25%">
								<input value="<?php echo (isset($FARM) ? $FARM->farmName : '') ?>" class="validate[required]" type="text" name="farmName" id="farmName"/><br />
							</td>
						</tr>
						
						<tr>
							<td width = "25%" style = "font-size:13px;">Farm Livestock</td>
							<td width = "75%">
								<select name="farmTypeId" id="farmTypeId"  class="validate[optional]">
								<option value = ''>--Farm Livestock--</option>
								<?php
									foreach($FARM_TYPES as $key => $value) {
										echo '<option value="'.$value->farmTypeId.'"' . (  ( isset($FARM) && ( $value->farmTypeId == $FARM->farmTypeId )  ) ? ' SELECTED' : '' ) . '>'.$value->farmType.'</option>';
									}
								?>
								</select>
							</td>
						</tr>
						
						<tr>
							<td width = "25%" style = "font-size:13px;">Certifications / Methods</td>
							<td width = "75%">
								<select name="certificationId" id="certificationId"  class="validate[optional]" multiple size = "6">
								<option value = ''>--Certifications / Methods--</option>
								<?php
									foreach($CERTIFICATIONS as $key => $value) {
										echo '<option value="'.$value->certificationId.'"' . (  ( isset($FARM) && in_array($value->certificationId, $FARM->certifications) ) ? ' SELECTED' : '' ) . '>'.$value->certification.'</option>';
									}
								?>
								</select>
							</td>
						</tr>
						
						<tr>
							<td width = "25%" style = "font-size:13px;">Farm Crops</td>
							<td width = "75%">
								<select name="farmCropId" id="farmCropId"  class="validate[optional]">
								<option value = ''>--Farm Crop--</option>
								<?php
									foreach($FARM_CROPS as $key => $value) {
										echo '<option value="'.$value->farmCropId.'"' . (  ( isset($FARM) && ( $value->farmCropId == $FARM->farmCropId )  ) ? ' SELECTED' : '' ) . '>'.$value->farmCrop.'</option>';
									}
								?>
								</select>
							</td>
						</tr>
						
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Phone</td>
							<td width = "75%">
								<input value="<?php echo (isset($FARM) ? $FARM->phone : '') ?>" class="validate[optional]" type="text" name="phone" id="phone"/>
							</td>
						</tr>
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Fax</td>
							<td width = "75%">
								<input value="<?php echo (isset($FARM) ? $FARM->fax : '') ?>" class="validate[optional]" type="text" name="fax" id="fax"/>
							</td>
						</tr>
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">E-Mail</td>
							<td width = "75%">
								<input value="<?php echo (isset($FARM) ? $FARM->email : '') ?>" class="validate[optional,custom[email]]" type="text" name="email" id="email"/>
							</td>
						</tr>
						
					</table>
				</td>
				<td valign = "top">
					<table class="formTable" border = "0" width = "300">
						<tr>
							<td width = "25%" style = "font-size:13px;">Address *</td>
							<td width = "25%">
								<input value="<?php echo (isset($FARM) ? $FARM->address : '') ?>" class="validate[required]" type="text" name="address" id="address"/><br />
							</td>
						</tr>
					
						<tr>
							<td width = "25%" style = "font-size:13px;">State *</td>
							<td width = "25%">
								<select name="stateId" id="stateId"  class="validate[required]">
								<option value = "">--State--</option>
								<?php
								foreach($STATES as $key => $value) {
									echo '<option value="'.$value->stateId.'"' . (  ( isset($FARM) && ( $value->stateId == $FARM->stateId )  ) ? ' SELECTED' : '' ) . '>'.$value->stateName.'</option>';
								}
								?>
								</select>
							</td>
						</tr>
					
						<tr>
							<td width = "25%" style = "font-size:13px;">City *</td>
							<td width = "25%">
								<input type="text" id="cityAjax" value="<?php echo (isset($FARM) ? $FARM->cityName : '') ?>" class="validate[required]" />
							</td>
						</tr>
						
						<tr>
							<td width = "25%" style = "font-size:13px;">Country *</td>
							<td width = "25%">
								<select name="countryId" id="countryId"  class="validate[required]">
								<option value = "">--Country--</option>
								<?php
									foreach($COUNTRIES as $key => $value) {
										echo '<option value="'.$value->countryId.'"' . (  ( isset($FARM) && ( $value->countryId == $FARM->countryId )  ) ? ' SELECTED' : '' ) . '>'.$value->countryName.'</option>';
									}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td width = "25%" style = "font-size:13px;">Zip *</td>
							<td width = "25%">
								<input value="<?php echo (isset($FARM) ? $FARM->zipcode : '') ?>" class="validate[required,length[1,6]]" type="text" name="zipcode" id="zipcode" /><br />
							</td>
						</tr>
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Website</td>
							<td width = "25%">
								<input value="<?php echo (isset($FARM) ? $FARM->url : '') ?>" class="validate[optional]" type="text" name="website" id="website"/>
							</td>
						</tr>
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Facebook</td>
							<td width = "25%">
								<input value="<?php echo (isset($FARM) ? $FARM->facebook : '') ?>" class="validate[optional]" type="text" name="facebook" id="facebook"/>
							</td>
						</tr>
						<tr>
							<td width = "25%" nowrap style = "font-size:13px;">Twitter</td>
							<td width = "25%">
								<input value="<?php echo (isset($FARM) ? $FARM->twitter : '') ?>" class="validate[optional]" type="text" name="twitter" id="twitter"/>
							</td>
						</tr>
						
					</table>
				</td>
			</tr>
			<tr>
				<td colspan = "2" align = "right">
					<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "Add Farm">
				</td>
			</tr>
		</table>
		<input type = "hidden" name = "farmId" id = "farmId" value = "<?php echo (isset($FARM) ? $FARM->farmId : '') ?>"></input>
		<input type = "hidden" name = "cityId" id = "cityId" value = "">
		</form>
		
		
		
	</div>
<!-- end center tabs -->