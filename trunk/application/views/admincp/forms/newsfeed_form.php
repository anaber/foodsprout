<style type="text/css">
	.formTable td.header
	{
		text-align: right;
		vertical-align: top;
		width: 40%;
	}
</style>
<script src="<?php echo base_url()?>js/jquery.autocomplete.frontend.js" type="text/javascript"></script>
<script type="text/javascript">

formValidated = true;

$(document).ready(function() {
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#newsfeedForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});

	$("#producer").autocomplete("/admincp/producergroup/ajaxSearchProducers", {		 	
	  	mustMatch: true, 
	 	matchContains: true,
		autoFill: false
	}).result(function (evt, data) {
 	    $("#producerId").val(data[1]);
 	});
	
	$("#product").autocomplete("/admincp/product/ajaxSearchProducts", {		 	
		multiple: true,		 	
		mustMatch: true, 
		matchContains: true,
		autoFill: false
	}).result(function (evt, data, formatted) {
		$("#productId").val(data[1]);
	});

	$("#newsfeedForm").submit(function() {
		
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
			
			/*if ($('#companyId').val() != '') {
				var formAction = '/admincp/producergroup/save_update';
				postArray = {							  							
							  companyId: $('#companyId').val(),
							  producerId: $('#producerId').val(),
							};
				act = 'update';		
			} else {*/
				formAction = '/admincp/producergroup/save_add';
				var pId = document.getElementsByName('producerId[]');
				var pIds = '';
				for(i=0;i < pId.length; i++) {
					pIds = pId[i].value+'|'+pIds;
				}				
				postArray = { 							
							  companyId: $('#companyId').val(),
							  producerId: pIds,
							};
				act = 'add';
			//}
			
			$.post(formAction, postArray,function(data) {
				
				if(data=='yes') {
					//start fading the messagebox
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						if (act == 'add') {
							$(this).html('Added...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/producergroup';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/producergroup';
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
});	
</script>
<?php echo anchor('admincp/newsfeed', 'List News'); ?><br /><br />
<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="newsfeedForm" action="<?php echo current_url(); ?>" method="post">
	<table class="formTable">
		<tr>
			<td class="header">Title: </td>
			<td width="60%"><input class="validate[required]" type="text" name="title" id="title" size="45" /></td>			
		</tr>
		<tr>
			<td class="header">Content: </td>
			<td>
				<textarea class="validate[required]" name="content" rows="10" id="content" cols="52"></textarea>
			</td>
		</tr>
		<tr>
			<td class="header">Select Producer: </td>
			<td>
				<input type="text" class="validate[required]" name="producer" id="producer" size="45" />
				<input type="hidden" name="producer_id" id="producerId" />
			</td>
		</tr>
		<tr>
			<td class="header">Select Product: </td>
			<td>
				<input type="text" class="validate[required]" name="product" id="product" size="45" />
				<input type="hidden" name="product_id" id="productId" />
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2"><input type="submit" name="save" value="Save" /></td>
		</tr>
	</table>
</form>
<div id="popupContact">
			
</div>