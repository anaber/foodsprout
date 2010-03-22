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
	$("#facilitytypeForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#facilitytypeForm").submit(function() {
		
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
			
			if ($('#facilitytypeId').val() != '' ) {
				var formAction = '/admincp/facilitytype/save_update';
				postArray = {
							  facilitytypeName:$('#facilitytypeName').val(),
							  facilitytypeId:$('#facilitytypeId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/facilitytype/save_add';
				postArray = { 
							  facilitytypeName:$('#facilitytypeName').val()
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
								document.location='/admincp/facilitytype';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/facilitytype';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Facility Type...').addClass('messageboxerror').fadeTo(900,1);
						
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
	
	
	$("#btnCancel").click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		document.location='/programs';
	});

});
	
		
</script>


<?php echo anchor('admincp/facilitytype', 'List Processing Facility Types'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="facilitytypeForm" method="post" <?php echo (isset($FACILITYTYPE)) ? 'action="/admincp/facilitytype/save_update"' : 'action="/admincp/facilitytype/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Processing Facility Type</td>
		<td width = "75%">
			<input value="<?php echo (isset($FACILITYTYPE) ? $FACILITYTYPE->facilitytypeName : '') ?>" class="validate[required]" type="text" name="facilitytypeName" id="facilitytypeName"/><br />
		</td>
	<tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($FACILITYTYPE)) ? 'Update Processing Facility Type' : 'Add Processing Facility Type' ?>">
			<input type = "hidden" name = "facilitytypeId" id = "facilitytypeId" value = "<?php echo (isset($FACILITYTYPE) ? $FACILITYTYPE->facilitytypeId : '') ?>">
		</td>
	<tr>
</table>
</form>

