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
	$("#meattypeForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#meattypeForm").submit(function() {
		
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
			
			if ($('#meattypeId').val() != '' ) {
				var formAction = '/admincp/meattype/save_update';
				postArray = {
							  meattypeName:$('#meattypeName').val(),
							  meattypeId:$('#meattypeId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/meattype/save_add';
				postArray = { 
							  meattypeName:$('#meattypeName').val()
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
								document.location='/admincp/meattype';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/meattype';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Meat Type...').addClass('messageboxerror').fadeTo(900,1);
						
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


<?php echo anchor('admincp/meattype', 'List Meat Types'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="meattypeForm" method="post" <?php echo (isset($MEATTYPE)) ? 'action="/admincp/meattype/save_update"' : 'action="/admincp/meattype/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Meat Type</td>
		<td width = "75%">
			<input value="<?php echo (isset($MEATTYPE) ? $MEATTYPE->meattypeName : '') ?>" class="validate[required]" type="text" name="meattypeName" id="meattypeName"/><br />
		</td>
	<tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($MEATTYPE)) ? 'Update Meat Type' : 'Add Meat Type' ?>">
			<input type = "hidden" name = "meattypeId" id = "meattypeId" value = "<?php echo (isset($MEATTYPE) ? $MEATTYPE->meattypeId : '') ?>">
		</td>
	<tr>
</table>
</form>

