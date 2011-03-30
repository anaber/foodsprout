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
	$("#manufacturetypeForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#manufacturetypeForm").submit(function() {
		
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
			
			if ($('#producerCategoryId').val() != '' ) {
				var formAction = '/admincp/producercategory/save_update';
				postArray = {
							  producerCategory:$('#producerCategory').val(),
							  producerCategoryId:$('#producerCategoryId').val(),
							  producerCategoryGroup:$('#producerCategoryGroup').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/producercategory/save_add';
				postArray = {
							  producerCategory:$('#producerCategory').val(),
							  producerCategoryGroup:$('#producerCategoryGroup').val()
							};
				act = 'add';
			}
			
			$.post(formAction, postArray,function(data) {
				//alert(data);
				if(data=='yes') {
					//start fading the messagebox
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						if (act == 'add') {
							$(this).html('Added...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/producercategory';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/producercategory';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Producer Category...').addClass('messageboxerror').fadeTo(900,1);
						
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


<?php echo anchor('admincp/producercategory', 'List Producer Categories'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="manufacturetypeForm" method="post" <?php echo (isset($PRODUCER_CATEGORY)) ? 'action="/admincp/producercategory/save_update"' : 'action="/admincp/producercategory/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Producer Category Group</td>
		<td width = "75%">
			<select name="producerCategoryGroup" id="producerCategoryGroup">
            	<?php foreach($PRODUCER_CATEGORY_GROUPS as $g): ?>
					<option value="<?php echo $g->producerCategoryGroupId; ?>" <?php echo @$PRODUCER_CATEGORY->producerCategoryGroupId == $g->producerCategoryGroupId ? 'selected="selected"' : "" ?>><?php echo $g->producerCategoryGroup; ?></option>
                <?php endforeach; ?>
            </select>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Producer Category</td>
		<td width = "75%">
			<input value="<?php echo (isset($PRODUCER_CATEGORY) ? $PRODUCER_CATEGORY->producerCategory : '') ?>" class="validate[required]" type="text" name="producerCategory" id="producerCategory"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($PRODUCER_CATEGORY)) ? 'Update Producer Category' : 'Add Producer Category' ?>">
			<input type = "hidden" name = "producerCategoryId" id = "producerCategoryId" value = "<?php echo (isset($PRODUCER_CATEGORY) ? $PRODUCER_CATEGORY->producerCategoryId : '') ?>">
		</td>
	</tr>
</table>
</form>

