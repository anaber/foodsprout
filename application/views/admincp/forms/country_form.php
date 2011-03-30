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
	$("#countryForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#countryForm").submit(function() {
		
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
			
			if ($('#countryId').val() != '' ) {
				var formAction = '/admincp/country/save_edit';
				postArray = {
							  country_name:$('#country_name').val(),
							  
							  countryId: $('#countryId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/country/save_add';
				postArray = { 
							  country_name:$('#country_name').val()
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
								document.location='/admincp/country';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/country';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Country...').addClass('messageboxerror').fadeTo(900,1);
						
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

<?php echo anchor('admincp/country', 'COUNTRIES'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />
    <form id="countryForm" method="post" <?php echo (isset($COUNTRY)) ? 'action="/admincp/country/save_edit"' : 'action="/admincp/country/save_add"' ?>>
    <table class="formTable">
        
        <tr>
            <td width = "25%" nowrap>Country Name:</td>
            <td width = "75%">
                <input type="text" id="country_name" name="country_name" value="<?php echo (isset($COUNTRY)) ? $COUNTRY->countryName : '' ?>" class="validate[required]"/>
            </td>
        </tr>	
        <tr>
            <td width = "25%" colspan = "2">
                <input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($COUNTRY)) ? 'Update Country' : 'Add Country' ?>">
                <input type = "hidden" name = "countryId" id = "countryId" value = "<?php echo (isset($COUNTRY) ? $COUNTRY->countryId : '') ?>">
            </td>
        </tr>
    </table>
	</form>
</div>