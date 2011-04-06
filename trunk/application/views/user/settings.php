<?php
/*
 * Created on Jul 16, 2010
 *
 * Author: Deepak Kumar
 */
?>
<script type="text/javascript" src="<?php echo base_url() ?>js/admin/city_search_admin.js"></script>

<script type="text/javascript">

formValidated = true;

$(document).ready(function() {
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#frmAccount").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});

        $("#cityAjax").autocomplete("/city/get_cities_for_user_settings", {
		width: 260,
		selectFirst: false,
		cacheLength:0
	}).result(function(event,data){
           if(data) {
               $('#cityId').attr('value', data[1]);
           }
        });
	
	$("#frmAccount").submit(function() {
		
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
			
			var formAction = '/user/updateSettings';
			postArray = {
                          email:$('#email').val(),
                          firstName:$('#first_name').val(),
                          zipcode:$('#zipcode').val(),
                          defaultcity:$('#cityId').val()
                        };
		
			$.post(formAction, postArray,function(data) {
				
				if(data=='yes') {
					//start fading the messagebox
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
							//redirect to secure page
							document.location='/user/settings';
						});
					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Email...').addClass('messageboxerror').fadeTo(900,1);
					});
				} else {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('User settings not updated...').addClass('messageboxerror').fadeTo(900,1);
					});
				}	
			});
		}
		
		return false; //not to post the  form physically
		
	});

});
	
		
</script>

<div>
	
<strong><?php echo $this->session->userdata('email'); ?>'s Settings</strong>
<hr size="1">

<div style="font-size:13px;text-decoration:none;float:left;"><strong>Account</strong> | <?php echo anchor('user/password', 'Password', 'style="font-size:13px;text-decoration:none;"'); ?></div>
<br><br>
<div align = "left"><div id="msgbox" style="display:none"></div></div><br />

<?php

$attributes = array('name' => 'frmAccount', 'id' => 'frmAccount');
echo form_open('user/updateSettings', $attributes);

?>
<table cellpadding="10" cellspacing="0" border="0" width="600" id="settings">
	<tr>
		<td width="150" style="font-size:13px;text-decoration:none;">
			Email
		</td>
		<td width="450">
			<input type="text" value="<?php echo (isset($USER) ? $USER->email : '') ?>" id = "email" class="validate[required,custom[email]]" maxlength="100">
		</td>
	</tr>
	<tr>
		<td width="150" style="font-size:13px;text-decoration:none;">
			Userame
		</td>
		<td width="450">
			<?php echo (isset($USER) ? $USER->username : '') ?>
		</td>
	</tr>

	<tr>
		<td width="150" style="font-size:13px;text-decoration:none;">
			First Name
		</td>
		<td width="450">
			<input type="text" value="<?php echo (isset($USER) ? $USER->firstName : '') ?>" id = "first_name" class="validate[required]" maxlength="100">
		</td>
	</tr>
	<tr>
		<td width="150" style="font-size:13px;text-decoration:none;">
			Zip Code
		</td>
		<td width="450">
			<input type="text" value="<?php echo (isset($USER) ? $USER->zipcode : '') ?>" id = "zipcode" class="validate[required]" size="5" maxlength="6"><br>
			<span style="font-size:11px">Providing your zip code will allow us to show you results near you by default</span>
		</td>
	</tr>

    <tr>
		<td width="150">
            Default City
		</td>
		<td width="450">
			<input type="text" value="<?php echo ($DEFAULT_CITY ? $DEFAULT_CITY : '' )?>" id="cityAjax" class="validate[required]"><br>
                        <input type="hidden" value="<?php echo (isset($USER) ? $USER->defaultCity : '') ?>" id="cityId" />
		</td>
	</tr>
    
	<tr>
		<td width="150">

		</td>
		<td width="450">
			<?php echo form_submit('submit', 'Save'); ?>
		</td>
	</tr>
</table>
</form>

<br>
<br>


</div>