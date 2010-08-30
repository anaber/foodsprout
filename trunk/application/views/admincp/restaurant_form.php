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
	
	
	<?php echo (isset($RESTAURANT) ? '' : "$('#companyId').val('');") ?>
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#restaurantForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#restaurantForm").submit(function(e) {
		e.preventDefault();
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
			
			if ($('#restaurantId').val() != '' ) {
				var formAction = '/admincp/restaurant/save_update';
				postArray = {
							  companyId:$('#companyId').val(),
							  restaurantChainId:$('#restaurantChainId').val(),
							  restaurantName:$('#restaurantName').val(),
							  customUrl:$('#customUrl').val(),
							  restaurantTypeId:$('#restaurantTypeId').val(),
							  cuisineId:selectedCuisines,
							  
							  phone:$('#phone').val(),
							  fax:$('#fax').val(),
							  email:$('#email').val(),
							  url:$('#website').val(),
							  
							  status:$('#status').val(),
							  
							  restaurantId: $('#restaurantId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/restaurant/save_add';
				postArray = { 
							  companyId:$('#companyId').val(),
							  restaurantChainId:$('#restaurantChainId').val(),
							  restaurantName:$('#restaurantName').val(),
							  customUrl:$('#customUrl').val(),
							  restaurantTypeId:$('#restaurantTypeId').val(),
							  cuisineId:selectedCuisines,
							  
							  phone:$('#phone').val(),
							  fax:$('#fax').val(),
							  email:$('#email').val(),
							  url:$('#website').val(),
							  
							  status:$('#status').val(),
							  address:$('#address').val(),
							  city: $('#city').val(),
							  stateId:$('#stateId').val(),
							  countryId:$('#countryId').val(),
							  zipcode:$('#zipcode').val()
							};
				act = 'add';
			}
			
			$.post(formAction, postArray,function(data) {
				//alert(data);
				//return false;
				if(data=='yes') {
					//start fading the messagebox
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						if (act == 'add') {
							$(this).html('Added...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/restaurant';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/restaurant';
							});
						}

					});
				} else if(data == 'no_name') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Either select company or enter resstaurant name...').addClass('messageboxerror').fadeTo(900,1);
						
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
						$(this).html('Duplicate Restaurant...').addClass('messageboxerror').fadeTo(900,1);
						
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


	$("#companyAjax").autocomplete(
		"/admincp/company/searchCompanies",
		{
			delay:10,
			minChars:3,
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:selectItem,
			onFindValue:findValue,
			formatItem:formatItem,
			autoFill:false
		}
	);
	
	$("#restaurantChainAjax").autocomplete(
		"/admincp/restaurantchain/searchRestaurantChains",
		{
			delay:10,
			minChars:3,
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:selectItemRestaurantChain,
			onFindValue:findValueRestaurantChain,
			formatItem:formatItem,
			autoFill:false
		}
	);

});

function findValue(li) {
	if( li == null ) return alert("No match!");
 
	// if coming from an AJAX call, let's use the CityId as the value
	if( !!li.extra ) var sValue = li.extra[0];
 
	// otherwise, let's just display the value in the text box
	else var sValue = li.selectValue;
 	
	//alert("The value you selected was: " + sValue);
	document.getElementById('companyId').value = sValue;	
}
 
function selectItem(li) {
	findValue(li);
}

function selectItemRestaurantChain(li) {
	findValueRestaurantChain(li);
}

function formatItem(row) {
	//return row[0] + " (id: " + row[1] + ")";
	return row[0];
}

function findValueRestaurantChain(li) {
	if( li == null ) return alert("No match!");
 
	// if coming from an AJAX call, let's use the CityId as the value
	if( !!li.extra ) var sValue = li.extra[0];
 
	// otherwise, let's just display the value in the text box
	else var sValue = li.selectValue;
 	
	//alert("The value you selected was: " + sValue);
	document.getElementById('restaurantChainId').value = sValue;	
}

</script>

<script src="<?php echo base_url()?>js/jquery.autocomplete.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url()?>css/jquery.autocomplete.css" type="text/css" />
<?php
	if (!isset($RESTAURANT)) {
?>
<?php echo anchor('admincp/restaurant', 'Restaurants'); ?><br /><br />
<?php
	}
?>

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="restaurantForm" method="post" <?php echo (isset($RESTAURANT)) ? 'action="/admincp/restaurant/save_update"' : 'action="/admincp/restaurant/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Company</td>
		<td width = "75%">
			<input type="text" id="companyAjax" value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->companyName : '') ?>" style="width: 200px;" /> 
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Restaurant Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantName : '') ?>" class="validate[optional]" type="text" name="restaurantName" id="restaurantName"/><br />
		</td>
	</tr>
	<tr>
		<td colspan = "2" style = "font-size:10px;">
			<ul>
				<li>Existing companies selected and name entered, restaurant will be treated as the subsidery of selected company but with overridden name.</li>
				<li>Existing companies selected and NO name entered, restaurant name will be considered as of company name.</li>
				<li>No company selected from the list above and name entered, new comapny and restaurant will be added.</li>
			</ul>
		</td>
	</tr>
	<tr>
		<td width = "25%">Restaurant Type</td>
		<td width = "75%">
			<select name="restaurantTypeId" id="restaurantTypeId"  class="validate[required]">
			<option value = ''>--Restaurant Type--</option>
			<?php
				foreach($RESTAURANT_TYPES as $key => $value) {
					echo '<option value="'.$value->restaurantTypeId.'"' . (  ( isset($RESTAURANT) && ( $value->restaurantTypeId == $RESTAURANT->restaurantTypeId )  ) ? ' SELECTED' : '' ) . '>'.$value->restaurantTypeName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Restaurant Chain</td>
		<td width = "75%">
			<input type="text" id="restaurantChainAjax" value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantChain : '') ?>" style="width: 200px;" /> 
		</td>
	</tr>
	<tr>
		<td width = "25%">Cuisine</td>
		<td width = "75%">
			<select name="cuisineId" id="cuisineId"  class="validate[required]" multiple size = "6">
			<option value = ''>--Cuisine--</option>
			<option value = "NULL">--Unknown--</option>
			<?php
				foreach($CUISINES as $key => $value) {
					echo '<option value="'.$value->cuisineId.'"' . (  ( isset($RESTAURANT) && in_array($value->cuisineId, $RESTAURANT->cuisines) ) ? ' SELECTED' : '' ) . '>'.$value->cuisineName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>	
	
	<tr>
		<td width = "25%" nowrap>Custom URL</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->customURL : '') ?>" class="validate[optional]" type="text" name="customUrl" id="customUrl"/>
		</td>
	</tr>
	
	<tr>
		<td width = "25%" nowrap>Phone</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->phone : '') ?>" class="validate[optional]" type="text" name="phone" id="phone"/>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Fax</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->fax : '') ?>" class="validate[optional]" type="text" name="fax" id="fax"/>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>E-Mail</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->email : '') ?>" class="validate[optional,custom[email]]" type="text" name="email" id="email"/>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Website</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantURL : '') ?>" class="validate[optional]" type="text" name="website" id="website"/>
		</td>
	</tr>
	
	<tr>
		<td width = "25%" nowrap>Status</td>
		<td width = "75%">
			<select name="status" id="status"  class="validate[required]">
				<option value="">--Choose Status--</option>
			<?php
				foreach($STATUS as $key => $value) {
					echo '<option value="'.$key.'"' . (  ( isset($RESTAURANT) && ( $key == $RESTAURANT->status )  ) ? ' SELECTED' : '' ) . '>'.$value.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
<?php
	if (!isset($RESTAURANT) ){
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
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->address : '') ?>" class="validate[required]" type="text" name="address" id="address"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%">City</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->city : '') ?>" class="validate[required]" type="text" name="city" id="city"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%">State</td>
		<td width = "75%">
			<select name="stateId" id="stateId"  class="validate[required]">
			<option value = ''>--State--</option>
			<?php
				foreach($STATES as $key => $value) {
					echo '<option value="'.$value->stateId.'"' . (  ( isset($RESTAURANT) && ( $value->stateId == $RESTAURANT->stateId )  ) ? ' SELECTED' : '' ) . '>'.$value->stateName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td width = "25%">Country</td>
		<td width = "75%">
			<select name="countryId" id="countryId"  class="validate[required]">
			<option value = ''>--Country--</option>
			<?php
				foreach($COUNTRIES as $key => $value) {
					echo '<option value="'.$value->countryId.'"' . (  ( isset($RESTAURANT) && ( $value->countryId == $RESTAURANT->countryId )  ) ? ' SELECTED' : '' ) . '>'.$value->countryName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td width = "25%">Zip</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANT) ? $RESTAURANT->zipcode : '') ?>" class="validate[required,length[1,6]]" type="text" name="zipcode" id="zipcode" /><br />
		</td>
	</tr>
<?php
	}
?>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($RESTAURANT)) ? 'Update Restaurant' : 'Add Restaurant' ?>">
			<input type = "hidden" name = "restaurantId" id = "restaurantId" value = "<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantId : '') ?>">
			<input type = "hidden" name = "restaurantChainId" id = "restaurantChainId" value = "<?php echo (isset($RESTAURANT) ? $RESTAURANT->restaurantChainId : '') ?>">
			<input type = "hidden" name = "companyId" id = "companyId" value = "<?php echo (isset($RESTAURANT) ? $RESTAURANT->companyId : '') ?>">
		</td>
	</tr>
</table>
</form>

