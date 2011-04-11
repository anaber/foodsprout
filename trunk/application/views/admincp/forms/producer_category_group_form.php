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
	$("#producerCategoryGroupForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#producerCategoryGroupForm").submit(function() {
		
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
			
			if ($('#producerCategoryGroupId').val() != '' ) {
				var formAction = '/admincp/producercategorygroup/save_update';
				postArray = {
							  producerCategoryGroup:$('#producerCategoryGroup').val(),
							  producerCategoryGroupId:$('#producerCategoryGroupId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/producercategorygroup/save_add';
				postArray = { 
							  producerCategoryGroup:$('#producerCategoryGroup').val()
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
								document.location='/admincp/producercategorygroup';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/producercategorygroup';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Category Group...').addClass('messageboxerror').fadeTo(900,1);
						
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


<?php echo anchor('admincp/producercategorygroup', 'List Producer Attributes Group'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="producerCategoryGroupForm" method="post" <?php echo (isset($PRODUCER_CATEGORY_GROUPS)) ? 'action="/admincp/producercategorygroup/save_update"' : 'action="/admincp/producercategorygroup/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Producer Category Group</td>
		<td width = "75%">
			<input value="<?php echo (isset($PRODUCER_CATEGORY_GROUPS) ? $PRODUCER_CATEGORY_GROUPS->producerCategoryGroup : '') ?>" class="validate[required]" type="text" name="producerCategoryGroup" id="producerCategoryGroup"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type="submit" name="btnSubmit" id="btnSubmit" value="<?php echo (isset($PRODUCER_CATEGORY_GROUPS)) ? 'Update Producer Category Group' : 'Add Producer Category Group' ?>">
			<input type="hidden" name="producerCategoryGroupId" id="producerCategoryGroupId" value="<?php echo (isset($PRODUCER_CATEGORY_GROUPS) ? $PRODUCER_CATEGORY_GROUPS->producerCategoryGroupId : '') ?>">
		</td>
	</tr>
</table>
</form>

