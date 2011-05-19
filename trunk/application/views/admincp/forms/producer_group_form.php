<?php
/*
 * Created on Mar 1, 2010
 *
 * Author: Deepak Kumar
 */
?>
<script src="<?php echo base_url()?>js/jquery.autocomplete.frontend.js" type="text/javascript"></script>
<script>

formValidated = true;

$(document).ready(function() {
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#companyForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});

	$("#companyName").autocomplete("/admincp/producergroup/ajaxSearchConglomerate", {		 	
	  	mustMatch: true, 
	 	matchContains: true,
		autoFill: false
	}).result(function (evt, data) {
 	    $("#companyId").val(data[1]);;
 	});
	
	$("#producersSearch").autocomplete("/admincp/producergroup/ajaxSearchProducers", {		 	
		multiple: true,		 	
		mustMatch: true, 
		matchContains: true,
		autoFill: false
	}).result(function (evt, data, formatted) {
		if (data) 
		{
			$("#result")[0].add('<input type="hidden" id="producerId" name="producerId[]" value="+data+"/>');
		}
	});
	
	$("#companyForm").submit(function() {
		
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
			
			if ($('#producerGroupId').val() != '') {
				var formAction = '/admincp/producergroup/save_update';
				postArray = {
							  producerGroup: $('#producerGroupId').val(),
							  companyName:$('#companyName').val(),
							  companyId: $('#companyId').val(),
							  producerId: $('#producerId').val(),
							};
				act = 'update';		
			} else {
				formAction = '/admincp/producergroup/save_add';
				postArray = { 
							  companyName:$('#companyName').val(),
							  companyId: $('#companyId').val(),
							  producerId: $('#producerId').val(),
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
								document.location='/admincp/company';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/company';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Company...').addClass('messageboxerror').fadeTo(900,1);
						
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
		
		document.location='/producergroup';
	});

});
	
		
</script>
<?php echo anchor('admincp/producergroup', 'List Companies'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="companyForm" method="post" action="/admincp/producergroups/add_group">
<table class="formTable" style="width: 50%">
	<tr>
		<td width="32%" nowrap align="right">Select Company: </td>
		<td width="75%">
			<input value="" class="validate[required]" type="text" name="companyName" id="companyName" size="47"/><br />
			<input id="companyId" type="hidden" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">Select Producers:</td>
		<td>
			<textarea class="validate[required]" name="producers" id="producersSearch" cols="35"></textarea>
			<div id="result"></div>
		</td>
	</tr>	
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "Add Group">
			<input type = "hidden" name = "producerGroupId" id = "producerGroupId" value = "<?php echo (isset($producergroup) ? $producergroup->producer_group_id : '') ?>">			
		</td>
	</tr>
</table>
</form>

