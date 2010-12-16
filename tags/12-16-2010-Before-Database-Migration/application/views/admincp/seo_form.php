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
	$("#seoForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#seoForm").submit(function() {
		
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
			
			if ($('#seoPageId').val() != '' ) {
				var formAction = '/admincp/seo/save_update';
				postArray = {
							  page:$('#page').val(),
							  titleTag:$('#titleTag').val(),
							  metaDescription:$('#metaDescription').val(),
							  metaKeywords:$('#metaKeywords').val(),
							  h1:$('#h1').val(),
							  url:$('#url').val(),
							 
							  seoPageId: $('#seoPageId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/seo/save_add';
				postArray = { 
							  page:$('#page').val(),
							  titleTag:$('#titleTag').val(),
							  metaDescription:$('#metaDescription').val(),
							  metaKeywords:$('#metaKeywords').val(),
							  h1:$('#h1').val(),
							  url:$('#url').val()
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
								document.location='/admincp/seo';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/seo';
							});
						}

					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Page...').addClass('messageboxerror').fadeTo(900,1);
						
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
<?php echo anchor('admincp/seo', 'SEO'); ?><br /><br />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="seoForm" method="post" <?php echo (isset($SEO)) ? 'action="/admincp/seo/save_update"' : 'action="/admincp/seo/save_add"' ?>>
<table class="formTable">
	
	<tr>
		<td width = "25%" nowrap>Page</td>
		<td width = "75%">
			<input value="<?php echo (isset($SEO) ? $SEO->page : '') ?>" class="validate[required]" size = "66" type="text" name="page" id="page"/><br />
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Title Tag</td>
		<td width = "75%">
			<textarea name="titleTag" id="titleTag" class="validate[required]" rows = "5" cols = "50"><?php echo (isset($SEO) ? $SEO->titleTag : '') ?></textarea>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Meta Description</td>
		<td width = "75%">
			<textarea name="metaDescription" id="metaDescription" class="validate[required]" rows = "5" cols = "50"><?php echo (isset($SEO) ? $SEO->metaDescription : '') ?></textarea>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Meta Keywords</td>
		<td width = "75%">
			<textarea name="metaKeywords" id="metaKeywords" class="validate[required]" rows = "5" cols = "50"><?php echo (isset($SEO) ? $SEO->metaKeywords : '') ?></textarea>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>H1</td>
		<td width = "75%">
			<textarea name="h1" id="h1" class="validate[required]" rows = "5" cols = "50"><?php echo (isset($SEO) ? $SEO->h1 : '') ?></textarea>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>URL</td>
		<td width = "75%">
			<input value="<?php echo (isset($SEO) ? $SEO->url : '') ?>" class="validate[optional]" size = "66" type="text" name="url" id="url"/>
		</td>
	</tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($SEO)) ? 'Update SEO Page' : 'Add SEO Page' ?>">
			<input type = "hidden" name = "seoPageId" id = "seoPageId" value = "<?php echo (isset($SEO) ? $SEO->seoPageId : '') ?>">
		</td>
	</tr>
</table>
</form>

