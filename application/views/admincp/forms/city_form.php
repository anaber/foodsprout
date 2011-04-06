<?php
/*
 * Created on Sep 12, 2010
 *
 * Author: Deepak Kumar
 */
?>
<script>

formValidated = true;

$(document).ready(function() {
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#cityForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#cityForm").submit(function() {
		
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
			
			if ($('#cityId').val() != '' ) {
                            // parse checkboxes
                            var featuredLeftVal = $('#featured_left').is(':checked') ? $('#featured_left').val() : 0;
                            var mainCityVal = $('#main_city').is(':checked') ? $('#main_city').val() : 0;
                            
				var formAction = '/admincp/city/save_update';
				postArray = {
							  city:$('#city').val(),
							  stateId:$('#stateId').val(),
							  customUrl:$('#customUrl').val(),
							  cityId: $('#cityId').val(),
                                                          mainCity: mainCityVal,
                                                          featuredLeft: featuredLeftVal
							};
				act = 'update';		
			} else {
				formAction = '/admincp/city/save_add';
				postArray = { 
							  city:$('#city').val(),
							  stateId:$('#stateId').val(),
							  customUrl:$('#customUrl').val()

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
								document.location='/admincp/city';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/city';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate City...').addClass('messageboxerror').fadeTo(900,1);
						
					});
				} else if(data == 'duplicate_url') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Custom URL...').addClass('messageboxerror').fadeTo(900,1);
						
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
<?php echo anchor('admincp/city', 'CITY'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="cityForm" method="post" <?php echo (isset($CITY)) ? 'action="/admincp/city/save_update"' : 'action="/admincp/city/save_add"' ?>>
<table class="formTable">
	
	<tr>
		<td width = "25%" nowrap>City</td>
		<td width = "75%">
			<input value="<?php echo (isset($CITY) ? $CITY->city : '') ?>" class="validate[required]" size = "30" type="text" name="city" id="city"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%">State</td>
		<td width = "75%">
			<select name="stateId" id="stateId"  class="validate[required]">
			<option value = ''>--State--</option>
			<?php
				foreach($STATES as $key => $value) {
					echo '<option value="'.$value->stateId.'"' . (  ( isset($CITY) && ( $value->stateId == $CITY->stateId )  ) ? ' SELECTED' : '' ) . '>'.$value->stateName.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Custom URL</td>
		<td width = "75%">
			<input value="<?php echo (isset($CITY) ? $CITY->customUrl : '') ?>" class="validate[optional]" size = "30" type="text" name="customUrl" id="customUrl"/><br />
		</td>
	</tr>

        <tr>
            <td width="25%" nowrap>Main City?</td>
            <td width="75%">
                <input type="checkbox" name="main_city" id="main_city" value="1"
                       <?php echo (isset($CITY) && $CITY->mainCity) ? 'checked="checked"' : '' ?>/>
            <td>
        </tr>

        <tr>
            <td width="25%" nowrap>Left Featured?</td>
            <td width="75%">
                <input type="checkbox" name="featured_left" id="featured_left"value="1"
                       <?php echo (isset($CITY) && $CITY->featuredLeft) ? 'checked="checked"' : '' ?>/>
            <td>
        </tr>

	
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($CITY)) ? 'Update City' : 'Add City' ?>">
			<input type = "hidden" name = "seoPageId" id = "cityId" value = "<?php echo (isset($CITY) ? $CITY->cityId : '') ?>">
		</td>
	</tr>
</table>
</form>

