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
	$("#vegetabletypeForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#vegetabletypeForm").submit(function() {
		
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
			
			if ($('#vegetabletypeId').val() != '' ) {
				var formAction = '/admincp/vegetabletype/save_update';
				postArray = {
							  vegetabletypeName:$('#vegetabletypeName').val(),
							  vegetabletypeId:$('#vegetabletypeId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/vegetabletype/save_add';
				postArray = { 
							  vegetabletypeName:$('#vegetabletypeName').val()
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
								document.location='/admincp/vegetabletype';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/vegetabletype';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Vegetable Type...').addClass('messageboxerror').fadeTo(900,1);
						
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


<?php echo anchor('admincp/vegetabletype', 'List Vegetable Types'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="vegetabletypeForm" method="post" <?php echo (isset($VEGETABLETYPE)) ? 'action="/admincp/vegetabletype/save_update"' : 'action="/admincp/vegetabletype/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Vegetable Type</td>
		<td width = "75%">
			<input value="<?php echo (isset($VEGETABLETYPE) ? $VEGETABLETYPE->vegetabletypeName : '') ?>" class="validate[required]" type="text" name="vegetabletypeName" id="vegetabletypeName"/><br />
		</td>
	<tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($VEGETABLETYPE)) ? 'Update Vegetable Type' : 'Add Vegetable Type' ?>">
			<input type = "hidden" name = "vegetabletypeId" id = "vegetabletypeId" value = "<?php echo (isset($VEGETABLETYPE) ? $VEGETABLETYPE->vegetabletypeId : '') ?>">
		</td>
	<tr>
</table>
</form>

