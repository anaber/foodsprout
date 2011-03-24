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
	$("#manufactureForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#manufactureForm").submit(function() {
		
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
			
			var cityId = $('#cityId').val();
			var cityName;
			
			if (isNaN( cityId ) ) {
				cityName = cityId;
				cityId = '';
			}
			
			if ($('#manufactureId').val() != '' ) {
				var formAction = '/admincp/manufacture/save_update';
				postArray = {
							  companyId:$('#companyId').val(),
							  manufactureName:$('#manufactureName').val(),
							  customUrl:$('#customUrl').val(),
							  url:$('#url').val(),
							  manufactureTypeId:$('#manufactureTypeId').val(),
							  status:$('#status').val(),
							  facebook:$('#facebook').val(),
							  twitter:$('#twitter').val(),
							  							 
							  manufactureId: $('#manufactureId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/manufacture/save_add';
				postArray = { 
							  companyId:$('#companyId').val(),
							  manufactureName:$('#manufactureName').val(),
							  customUrl:$('#customUrl').val(),
							  url:$('#url').val(),
							  manufactureTypeId:$('#manufactureTypeId').val(),
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
								document.location='/admincp/manufacture';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/manufacture';
							});
						}

					});
				} else if(data == 'no_name') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Either select company or enter manufacture name...').addClass('messageboxerror').fadeTo(900,1);
						
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
						$(this).html('Duplicate Manufacture...').addClass('messageboxerror').fadeTo(900,1);
						
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
	if (!isset($MANUFACTURE)) {
?>
<?php echo anchor('admincp/manufacture', 'Manufactures'); ?><br /><br />
<?php
	}
?>

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="manufactureForm" method="post" <?php echo (isset($MANUFACTURE)) ? 'action="/admincp/manufacture/save_update"' : 'action="/admincp/manufacture/save_add"' ?>>
<table class="formTable">
<!--	<tr>
		<td width = "25%" nowrap>Company</td>
		<td width = "75%">
			<input type="text" id="companyAjax" value="<?php echo (isset($MANUFACTURE) ? $MANUFACTURE->companyName : '') ?>" style="width: 200px;" /> 
		</td>
	</tr>
-->
	<tr>
		<td width = "25%" nowrap>Manufacture Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($MANUFACTURE) ? $MANUFACTURE->manufactureName : '') ?>" class="validate[optional]" type="text" name="manufactureName" id="manufactureName"/><br />
		</td>
	</tr>
<!--	<tr>
		<td colspan = "2" style = "font-size:10px;">
			<ul>
				<li>Existing companies selected and name entered, manufacture will be treated as the subsidery of selected company but with overridden name.</li>
				<li>Existing companies selected and NO name entered, manufacture name will be considered as of company name.</li>
				<li>No company selected from the list above and name entered, new comapny and manufacture will be added.</li>
			</ul>
		</td>
	</tr>
-->
	<tr>
		<td width = "25%">Manufacture Type</td>
		<td width = "75%">
			<select name="manufactureTypeId" id="manufactureTypeId"  class="validate[required]">
			<option value = ''>--Manufacture Type--</option>
			<?php
				foreach($MANUFACTURE_TYPES as $key => $value) {
					echo '<option value="'.$value->manufactureTypeId.'"' . (  ( isset($MANUFACTURE) && ( $value->manufactureTypeId == $MANUFACTURE->manufactureTypeId )  ) ? ' SELECTED="SELECTED"' : '' ) . '>'.$value->manufactureType.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Custom URL</td>
		<td width = "75%">
			<input value="<?php echo (isset($MANUFACTURE) ? $MANUFACTURE->customUrl : '') ?>" class="validate[optional]" type="text" name="customUrl" id="customUrl"/>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Website</td>
		<td width = "75%">
			<input value="<?php echo (isset($MANUFACTURE) ? $MANUFACTURE->url : '') ?>" class="validate[optional]" type="text" name="url" id="url"/>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Facebook</td>
		<td width = "75%">
			<input value="<?php echo (isset($MANUFACTURE) ? $MANUFACTURE->facebook : '') ?>" class="validate[optional]" type="text" name="facebook" id="facebook"/>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Twitter</td>
		<td width = "75%">
			<input value="<?php echo (isset($MANUFACTURE) ? $MANUFACTURE->twitter : '') ?>" class="validate[optional]" type="text" name="twitter" id="twitter"/>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Status</td>
		<td width = "75%">
			<select name="status" id="status"  class="validate[required]">
				<option value="">--Choose Status--</option>
			<?php
				foreach($STATUS as $key => $value) {
					echo '<option value="'.$key.'"' . (  ( isset($MANUFACTURE) && ( $key == $MANUFACTURE->status )  ) ? ' SELECTED' : '' ) . '>'.$value.'</option>';
				}
			?></select>
		</td>
	</tr>
<?php
	if (!isset($MANUFACTURE) ){
?>
	<tr>
		<td colspan = "2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan = "2"><b>Address</b></td>
	</tr>
	<tr>
		<td width = "25%">Address</td>
		<td width = "75%">
			<input value="<?php echo (isset($MANUFACTURE) ? $MANUFACTURE->address : '') ?>" class="validate[required]" type="text" name="address" id="address"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%">State</td>
		<td width = "75%">
			<select name="stateId" id="stateId"  class="validate[required]">
			<option value = ''>--State--</option>
			<?php
				foreach($STATES as $key => $value) {
					echo '<option value="'.$value->stateId.'"' . (  ( isset($MANUFACTURE) && ( $value->stateId == $MANUFACTURE->stateId )  ) ? ' SELECTED' : '' ) . '>'.$value->stateName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	
	<tr>
		<td width = "25%">City</td>
		<td width = "75%">
			<input type="text" id="cityAjax" value="<?php echo (isset($MANUFACTURE) ? $MANUFACTURE->cityName : '') ?>" class="validate[required]" />
		</td>
	</tr>
	
	<tr>
		<td width = "25%">Country</td>
		<td width = "75%">
			<select name="countryId" id="countryId"  class="validate[required]">
			<option value = ''>--Country--</option>
			<?php
				foreach($COUNTRIES as $key => $value) {
					echo '<option value="'.$value->countryId.'"' . (  ( isset($MANUFACTURE) && ( $value->countryId == $MANUFACTURE->countryId )  ) ? ' SELECTED' : '' ) . '>'.$value->countryName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td width = "25%">Zip</td>
		<td width = "75%">
			<input value="<?php echo (isset($MANUFACTURE) ? $MANUFACTURE->zipcode : '') ?>" class="validate[required,length[1,6]]" type="text" name="zipcode" id="zipcode" /><br />
		</td>
	</tr>
<?php
	}
?>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($MANUFACTURE)) ? 'Update Manufacture' : 'Add Manufacture' ?>">
			<input type = "hidden" name = "manufactureId" id = "manufactureId" value = "<?php echo (isset($MANUFACTURE) ? $MANUFACTURE->manufactureId : '') ?>">
<!--			<input type = "hidden" name = "companyId" id = "companyId" value = "<?php echo (isset($MANUFACTURE) ? $MANUFACTURE->companyId : '') ?>">-->
			<input type = "hidden" name = "companyId" id = "cityId" value = "">
		</td>
	</tr>
</table>
</form>

