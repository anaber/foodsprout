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
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#distributorForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#distributorForm").submit(function() {
		
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
			
			if ($('#distributorId').val() != '' ) {
				var formAction = '/admincp/distributor/save_update';
				postArray = {
							  companyId:$('#companyId').val(),
							  distributorName:$('#distributorName').val(),
							  customUrl:$('#customUrl').val(),
							  url:$('#url').val(),
							  isActive:$('#status').val(),
							  							 
							  distributorId: $('#distributorId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/distributor/save_add';
				postArray = { 
							  companyId:$('#companyId').val(),
							  distributorName:$('#distributorName').val(),
							  customUrl:$('#customUrl').val(),
							  url:$('#url').val(),
							  isActive:$('#status').val(),
							  address:$('#address').val(),
							  city: $('#city').val(),
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
								document.location='/admincp/distributor';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/distributor';
							});
						}

					});
				} else if(data == 'no_name') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Either select company or enter distributor name...').addClass('messageboxerror').fadeTo(900,1);
						
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
						$(this).html('Duplicate Distributor...').addClass('messageboxerror').fadeTo(900,1);
						
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

function formatItem(row) {
	//return row[0] + " (id: " + row[1] + ")";
	return row[0];
}

	
</script>

<script src="<?php echo base_url()?>js/jquery.autocomplete.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url()?>css/jquery.autocomplete.css" type="text/css" />
<?php
	if (!isset($DISTRIBUTOR)) {
?>
<?php echo anchor('admincp/distributor', 'Distributors'); ?><br /><br />
<?php
	}
?>
<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="distributorForm" method="post" <?php echo (isset($DISTRIBUTOR)) ? 'action="/admincp/distributor/save_update"' : 'action="/admincp/distributor/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Company</td>
		<td width = "75%">
			<input type="text" id="companyAjax" value="<?php echo (isset($DISTRIBUTOR) ? $DISTRIBUTOR->companyName : '') ?>" style="width: 200px;" />
		</td>
	<tr>
	<tr>
		<td width = "25%" nowrap>Distributor Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($DISTRIBUTOR) ? $DISTRIBUTOR->distributorName : '') ?>" class="validate[optional]" type="text" name="distributorName" id="distributorName"/><br />
		</td>
	<tr>
	<tr>
		<td colspan = "2" style = "font-size:10px;">
			<ul>
				<li>Existing companies selected and name entered, distributor will be treated as the subsidery of selected company but with overridden name.</li>
				<li>Existing companies selected and NO name entered, distributor name will be considered as of company name.</li>
				<li>No company selected from the list above and name entered, new comapny and distributor will be added.</li>
			</ul>
		</td>
	<tr>
	
	<tr>
		<td width = "25%" nowrap>Custom URL</td>
		<td width = "75%">
			<input value="<?php echo (isset($DISTRIBUTOR) ? $DISTRIBUTOR->customUrl : '') ?>" class="validate[optional]" type="text" name="customUrl" id="customUrl"/>
		</td>
	<tr>
	<tr>
		<td width = "25%" nowrap>Website</td>
		<td width = "75%">
			<input value="<?php echo (isset($DISTRIBUTOR) ? $DISTRIBUTOR->url : '') ?>" class="validate[optional]" type="text" name="url" id="url"/>
		</td>
	<tr>
	<tr>
		<td width = "25%" nowrap>Status</td>
		<td width = "75%">
			<select name="status" id="status"  class="validate[required]">
				<option value="">--Choose Status--</option>
				<option value="active"<?php echo ((isset($DISTRIBUTOR) && ($DISTRIBUTOR->isActive == 1)) ? ' SELECTED' : '')?>>Active</option>
				<option value="inactive"<?php echo ((isset($DISTRIBUTOR) && ($DISTRIBUTOR->isActive == 0)) ? ' SELECTED' : '')?>>In-active</option>
			</select>
		</td>
	<tr>
<?php
	if (!isset($DISTRIBUTOR) ){
?>
	<tr>
		<td colspan = "2">&nbsp;</td>
	<tr>
	<tr>
		<td colspan = "2"><b>Address</b></td>
	<tr>
	<tr>
		<td width = "25%">Address</td>
		<td width = "75%">
			<input value="<?php echo (isset($DISTRIBUTOR) ? $DISTRIBUTOR->address : '') ?>" class="validate[required]" type="text" name="address" id="address"/><br />
		</td>
	<tr>
	<tr>
		<td width = "25%">City</td>
		<td width = "75%">
			<input value="<?php echo (isset($DISTRIBUTOR) ? $DISTRIBUTOR->city : '') ?>" class="validate[required]" type="text" name="city" id="city"/><br />
		</td>
	<tr>
	<tr>
		<td width = "25%">State</td>
		<td width = "75%">
			<select name="stateId" id="stateId"  class="validate[required]">
			<option value = ''>--State--</option>
			<?php
				foreach($STATES as $key => $value) {
					echo '<option value="'.$value->stateId.'"' . (  ( isset($DISTRIBUTOR) && ( $value->stateId == $DISTRIBUTOR->stateId )  ) ? ' SELECTED' : '' ) . '>'.$value->stateName.'</option>';
				}
			?>
			</select>
		</td>
	<tr>
	<tr>
		<td width = "25%">Country</td>
		<td width = "75%">
			<select name="countryId" id="countryId"  class="validate[required]">
			<option value = ''>--Country--</option>
			<?php
				foreach($COUNTRIES as $key => $value) {
					echo '<option value="'.$value->countryId.'"' . (  ( isset($DISTRIBUTOR) && ( $value->countryId == $DISTRIBUTOR->countryId )  ) ? ' SELECTED' : '' ) . '>'.$value->countryName.'</option>';
				}
			?>
			</select>
		</td>
	<tr>
	<tr>
		<td width = "25%">Zip</td>
		<td width = "75%">
			<input value="<?php echo (isset($DISTRIBUTOR) ? $DISTRIBUTOR->zipcode : '') ?>" class="validate[required,length[1,6]]" type="text" name="zipcode" id="zipcode" /><br />
		</td>
	<tr>
<?php
	}
?>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($DISTRIBUTOR)) ? 'Update Distributor' : 'Add Distributor' ?>">
			<input type = "hidden" name = "distributorId" id = "distributorId" value = "<?php echo (isset($DISTRIBUTOR) ? $DISTRIBUTOR->distributorId : '') ?>">
			<input type = "hidden" name = "companyId" id = "companyId" value = "<?php echo (isset($DISTRIBUTOR) ? $DISTRIBUTOR->companyId : '') ?>">
		</td>
	<tr>
</table>
</form>

