<?php
/*
 * Created on Mar 1, 2010
 *
 * Author: Deepak Kumar
 */
?>
<script>

formValidated = true;

$(document).ready(function() {
	
	/* ----------------------------------------------------
	 * Company
	 * ----------------------------------------------------*/
	 
	function findValueCallbackCompany(event, data, formatted) {
		document.getElementById('companyId').value = data[1];
	}
	
	$("#companyAjax").result(findValueCallbackCompany).next().click(function() {
		$(this).prev().search();
	});
	
	$("#companyAjax").autocomplete("/admincp/company/searchCompanies", {
		width: 260,
		selectFirst: false,
		cacheLength:0,
		extraParams: {
	       stateId: function() { return $("#stateId").val(); }
	   	}
	});
	
	$("#companyAjax").result(function(event, data, formatted) {
		if (data)
			$(this).parent().next().find("input").val(data[1]);
	});
	
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
	
	
	$("#farmForm").submit(function() {
		
		$("#msgbox").removeClass().addClass('messagebox').text('Validating...').fadeIn(1000);
		
		if (formValidated == false) {
			// Don't post the form.
			$("#msgbox").fadeTo(200,0.1,function() {
				//add message and change the class of the box and start fading
				$(this).html('Form validation failed...').addClass('messageboxerror').fadeTo(900,1);
			});
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
				var formAction = '/admincp/farm/save_update';
				postArray = {
							  companyId:$('#companyId').val(),
							  farmName:$('#farmName').val(),
							  customUrl:$('#customUrl').val(),
							  url:$('#url').val(),
							  farmTypeId:$('#farmTypeId').val(),
							  farmCropId:$('#farmCropId').val(),
							  certificationId:selectedCertifications,
							  
							  status:$('#status').val(),
							  facebook:$('#facebook').val(),
							  twitter:$('#twitter').val(),
							  
							  farmId: $('#farmId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/farm/save_add';
				postArray = { 
							  companyId:$('#companyId').val(),
							  farmName:$('#farmName').val(),
							  customUrl:$('#customUrl').val(),
							  url:$('#url').val(),
							  farmTypeId:$('#farmTypeId').val(),
							  farmCropId:$('#farmCropId').val(),
							  certificationId:selectedCertifications,
							  
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
				if(data=='yes') {
					//start fading the messagebox
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						if (act == 'add') {
							$(this).html('Added...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/farm';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/farm';
							});
						}

					});
				} else if(data == 'no_name') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Either select company or enter farm name...').addClass('messageboxerror').fadeTo(900,1);
						
					});
				} else if(data == 'duplicate_company') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Company...').addClass('messageboxerror').fadeTo(900,1);
						
					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Farm...').addClass('messageboxerror').fadeTo(900,1);
						
					});
				} else {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						if (act == 'add') {
							$(this).html('Not added...').addClass('messageboxerror').fadeTo(900,1);
						} else if (act == 'update') {
							$(this).html('Not updated...').addClass('messageboxerror').fadeTo(900,1);
						}
					});
				}	
			});
		}
		
		return false; //not to post the  form physically
		
	});
	
});

</script>

<script src="<?php echo base_url()?>js/jquery.autocomplete.frontend.js" type="text/javascript"></script>

<?php
	if (!isset($FARM)) {
?>
<?php echo anchor('admincp/farm', 'Farms'); ?><br /><br />
<?php
	}
?>

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="farmForm" method="post" <?php echo (isset($FARM)) ? 'action="/admincp/farm/save_update"' : 'action="/admincp/farm/save_add"' ?>>
<table class="formTable">
<!--	<tr>
		<td width = "30%" nowrap>Company</td>
		<td width = "70%">
			<input type="text" id="companyAjax" value="<?php echo (isset($FARM) ? $FARM->companyName : '') ?>" style="width: 200px;" /> 
		</td>
	</tr>
-->
	<tr>
		<td width = "30%" nowrap>Farm Name</td>
		<td width = "70%">
			<input value="<?php echo (isset($FARM) ? $FARM->farmName : '') ?>" class="validate[optional]" type="text" name="farmName" id="farmName"/><br />
		</td>
	</tr>
<!--	<tr>
		<td colspan = "2" style = "font-size:10px;">
			<ul>
				<li>Existing companies selected and name entered, farm will be treated as the subsidery of selected company but with overridden name.</li>
				<li>Existing companies selected and NO name entered, farm name will be considered as of company name.</li>
				<li>No company selected from the list above and name entered, new comapny and farm will be added.</li>
			</ul>
		</td>
	</tr>
-->
	<tr>
		<td width = "30%" nowrap>Farm Livestock</td>
		<td width = "70%">
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
		<td width = "30%" nowrap>Certifications / Methods</td>
		<td width = "70%">
			
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
		<td width = "30%">Farm Crops</td>
		<td width = "70%">
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
	
<!--
	<tr>
		<td width = "30%">Farmer Type</td>
		<td width = "70%">
			<select name="farmerType" id="farmerType"  class="validate[optional]">
			<option value = ''>--Farmer Type--</option>
			<?php
				foreach($FARMER_TYPES as $key => $value) {
					echo '<option value="'.$key.'"' . (  ( isset($FARM) && ( $key == $FARM->farmerType )  ) ? ' SELECTED' : '' ) . '>'.$value.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
-->
	<tr>
		<td width = "30%" nowrap>Custom URL</td>
		<td width = "70%">
			<input value="<?php echo (isset($FARM) ? $FARM->customUrl : '') ?>" class="validate[optional]" type="text" name="customUrl" id="customUrl"/>
		</td>
	</tr>
	<tr>
		<td width = "30%" nowrap>Website</td>
		<td width = "70%">
			<input value="<?php echo (isset($FARM) ? $FARM->url : '') ?>" class="validate[optional]" type="text" name="url" id="url"/>
		</td>
	</tr>
	<tr>
		<td width = "30%" nowrap>Facebook</td>
		<td width = "70%">
			<input value="<?php echo (isset($FARM) ? $FARM->facebook : '') ?>" class="validate[optional]" type="text" name="facebook" id="facebook"/>
		</td>
	</tr>
	<tr>
		<td width = "30%" nowrap>Twitter</td>
		<td width = "70%">
			<input value="<?php echo (isset($FARM) ? $FARM->twitter : '') ?>" class="validate[optional]" type="text" name="twitter" id="twitter"/>
		</td>
	</tr>
	<tr>
		<td width = "30%" nowrap>Status</td>
		<td width = "70%">
			<select name="status" id="status"  class="validate[required]">
				<option value="">--Choose Status--</option>
			<?php
				foreach($STATUS as $key => $value) {
					echo '<option value="'.$key.'"' . (  ( isset($FARM) && ( $key == $FARM->status )  ) ? ' SELECTED' : '' ) . '>'.$value.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
<?php
	if (!isset($FARM) ){
?>
	<tr>
		<td colspan = "2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan = "2"><b>Address</b></td>
	</tr>
	<tr>
		<td width = "30%">Address</td>
		<td width = "70%">
			<input value="<?php echo (isset($FARM) ? $FARM->address : '') ?>" class="validate[required]" type="text" name="address" id="address"/><br />
		</td>
	</tr>
	
	<tr>
		<td width = "30%">State</td>
		<td width = "70%">
			<select name="stateId" id="stateId"  class="validate[required]">
			<option value = ''>--State--</option>
			<?php
				foreach($STATES as $key => $value) {
					echo '<option value="'.$value->stateId.'"' . (  ( isset($FARM) && ( $value->stateId == $FARM->stateId )  ) ? ' SELECTED' : '' ) . '>'.$value->stateName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	
	<tr>
		<td width = "30%">City</td>
		<td width = "70%">
			<input type="text" id="cityAjax" value="<?php echo (isset($FARM) ? $FARM->cityName : '') ?>" class="validate[required]" />
		</td>
	</tr>
	
	<tr>
		<td width = "30%">Country</td>
		<td width = "70%">
			<select name="countryId" id="countryId"  class="validate[required]">
			<option value = ''>--Country--</option>
			<?php
				foreach($COUNTRIES as $key => $value) {
					echo '<option value="'.$value->countryId.'"' . (  ( isset($FARM) && ( $value->countryId == $FARM->countryId )  ) ? ' SELECTED' : '' ) . '>'.$value->countryName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td width = "30%">Zip</td>
		<td width = "70%">
			<input value="<?php echo (isset($FARM) ? $FARM->zipcode : '') ?>" class="validate[required,length[1,6]]" type="text" name="zipcode" id="zipcode" /><br />
		</td>
	</tr>
<?php
	}
?>
	<tr>
		<td width = "30%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($FARM)) ? 'Update Farm' : 'Add Farm' ?>">
			<input type = "hidden" name = "farmId" id = "farmId" value = "<?php echo (isset($FARM) ? $FARM->farmId : '') ?>">
			<!--<input type = "hidden" name = "companyId" id = "companyId" value = "<?php echo (isset($FARM) ? $FARM->companyId : '') ?>">-->
			<input type = "hidden" name = "companyId" id = "cityId" value = "">
		</td>
	</tr>
</table>
</form>

