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
	$("#restauranttypeForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#restauranttypeForm").submit(function() {
		
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
			
			if ($('#restauranttypeId').val() != '' ) {
				var formAction = '/admincp/restauranttype/save_update';
				postArray = {
							  restauranttypeName:$('#restauranttypeName').val(),
							  restauranttypeId:$('#restauranttypeId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/restauranttype/save_add';
				postArray = { 
							  restauranttypeName:$('#restauranttypeName').val()
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
								document.location='/admincp/restauranttype';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/restauranttype';
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


<?php echo anchor('admincp/restauranttype', 'List Restaurant Types'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="restauranttypeForm" method="post" <?php echo (isset($RESTAURANTTYPE)) ? 'action="/admincp/restauranttype/save_update"' : 'action="/admincp/restauranttype/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Restaurant Type</td>
		<td width = "75%">
			<input value="<?php echo (isset($RESTAURANTTYPE) ? $RESTAURANTTYPE->restaurantType : '') ?>" class="validate[required]" type="text" name="restaurantType" id="restaurantType"/><br />
		</td>
	<tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($RESTAURANTTYPE)) ? 'Update Restaurant Type' : 'Add Restaurant Type' ?>">
			<input type = "hidden" name = "restaurantTypeId" id = "restaurantTypeId" value = "<?php echo (isset($RESTAURANTTYPE) ? $RESTAURANTTYPE->restaurantTypeId : '') ?>">
		</td>
	<tr>
</table>
</form>

