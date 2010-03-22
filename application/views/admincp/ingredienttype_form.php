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
	$("#ingredienttypeForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#ingredienttypeForm").submit(function() {
		
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
			
			if ($('#ingredienttypeId').val() != '' ) {
				var formAction = '/admincp/ingredienttype/save_update';
				postArray = {
							  ingredienttypeName:$('#ingredienttypeName').val(),
							  ingredienttypeId: $('#ingredienttypeId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/ingredienttype/save_add';
				postArray = { 
							  ingredienttypeName:$('#ingredienttypeName').val()
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
								document.location='/admincp/ingredienttype';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/ingredienttype';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Fruit Type...').addClass('messageboxerror').fadeTo(900,1);
						
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


<?php echo anchor('admincp/ingredienttype', 'List Ingredient Types'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="ingredienttypeForm" method="post" <?php echo (isset($INGREDIENTTYPE)) ? 'action="/admincp/ingredienttype/save_update"' : 'action="/admincp/ingredienttype/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Ingredient Type</td>
		<td width = "75%">
			<input value="<?php echo (isset($INGREDIENTTYPE) ? $INGREDIENTTYPE->ingredienttypeName : '') ?>" class="validate[required]" type="text" name="ingredienttypeName" id="ingredienttypeName"/><br />
		</td>
	<tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($INGREDIENTTYPE)) ? 'Update Ingredient Type' : 'Add Ingredient Type' ?>">
			<input type = "hidden" name = "ingredienttypeId" id = "ingredienttypeId" value = "<?php echo (isset($INGREDIENTTYPE) ? $INGREDIENTTYPE->ingredienttypeId : '') ?>">
		</td>
	<tr>
</table>
</form>

