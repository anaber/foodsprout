<?php
/*
 * Created on Mar 1, 2010
 *
 * Author: Deepak Kumar
 */
?>
<script type="text/javascript" src="<?php echo base_url()?>js/uploadify/swfobject.js"></script> 
<script type="text/javascript" src="<?php echo base_url()?>js/uploadify/jquery.uploadify.v2.1.0.js"></script>

<script>

formValidated = true;

$(document).ready(function() {
	
	/* ----------------------------------------------------
	 * Company
	 * ----------------------------------------------------*/
	 
	function findValueCallbackCompany(event, data, formatted) {
		$("#producerId").val(data[1]);
	}
	
	$("#companyAjax").result(findValueCallbackCompany).next().click(function() {
		$(this).prev().search();
	});
	
	$("#companyAjax").autocomplete("/admincp/restaurant/searchRestaurants", {
		width: 260,
		selectFirst: false,
		cacheLength:0
	});
	
	$("#companyAjax").result(function(event, data, formatted) {
		if (data)
			$(this).parent().next().find("input").val(data[1]);
	});
	
	/* ----------------------------------------------------
	 * City
	 * ----------------------------------------------------*/
	 
	function findValueCallbackCity(event, data, formatted) {
		document.getElementById('cityId').value = data[1];
	}
	
	$("#cityAjax").result(findValueCallbackCity).next().click(function() {
		$(this).prev().search();
	});
	
	$("#cityAjax").autocomplete("/city/get_cities_based_on_restaurant", {
		width: 260,
		selectFirst: false,
		cacheLength:0,
		extraParams: {
	       producerId: function() { return $("#producerId").val(); }
	   	}
	});
	
	$("#cityAjax").result(function(event, data, formatted) {
		if (data)
			$(this).parent().next().find("input").val(data[1]);
	});
	
	$("#clear").click(function() {
		$(":input").unautocomplete();
	});
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#manufactureForm").validationEngine({
		inlineValidation: false,
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	
	$("#manufactureForm").submit(function() {
		
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
			
			var cityId = $('#cityId').val();
			var cityName;
			
			if (isNaN( cityId ) ) {
				cityName = cityId;
				cityId = '';
			}
			
			if ($('#lotteryId').val() != '' ) {
				var formAction = '/admincp/lottery/save_update';
				postArray = {
							  producerId:$('#producerId').val(),
							  lotteryName:$('#lotteryName').val(),
							  cityId:$('#cityId').val(),
							  info:$('#info').val(),
							  
							  startDate:$('#startDate').val(),
							  endDate:$('#endDate').val(),
							  drawDate:$('#drawDate').val(),
							  resultDate:$('#resultDate').val(),
							  					 
							  lotteryId: $('#lotteryId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/lottery/save_add';
				postArray = { 
							  producerId:$('#producerId').val(),
							  lotteryName:$('#lotteryName').val(),
							  cityId:$('#cityId').val(),
							  info:$('#info').val(),
							  
							  startDate:$('#startDate').val(),
							  endDate:$('#endDate').val(),
							  drawDate:$('#drawDate').val(),
							  resultDate:$('#resultDate').val(),
							  mainPhotoName:$('#mainPhotoName').val()
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
								document.location='/admincp/lottery';
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location='/admincp/lottery';
							});
						}
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
	
	var action;
	
	if ($('#photoId').val() != '' ) {
		var action = 'update';
	} else {
		var action = 'add';
	}
	
	$("#fileInput").uploadify({
		'uploader'       : '/js/uploadify/uploadify.swf',
		'script'         : '/common/lottery_photo_save',
		'cancelImg'      : '/images/cancel.png',
		'folder'         : '/uploads',
		'auto'           : true,
		'multi'          : false,
		'fileDesc'		 : '*.png;*.gif;*.jpg', //'Images',
		'fileExt'		 : '*.png;*.gif;*.jpg',
		'buttonText'	 : 'Upload Photos',
		'scriptData'	 : {
								lotteryId: $('#lotteryId').val(),
								photoId: $('#photoId').val()
							},
		'onError'		 : function(event, queueID, fileObj, errorObj) {
								//alert(errorObj.type + ' Error: ' + errorObj.info);
								//alert(errorObj.type);
								//alert(errorObj.info);
     						},
     	'onComplete'	 : function (event, queueID, fileObj, response, data) {
    							//alert(fileObj.filePath);
    							//alert(response);
    							var jsonObject = eval('(' + response + ')');
    							redrawPhotoTitleForm(jsonObject);
     						}
	});
	
});

$(function() {
	$( "#startDate" ).datepicker();
});

$(function() {
	$( "#endDate" ).datepicker();
});

$(function() {
	$( "#drawDate" ).datepicker();
});

$(function() {
	$( "#resultDate" ).datepicker();
});


function redrawPhotoTitleForm(response) {
	
	$('#photoTitleContent').empty();
	var html = '';
	html +=  '<br /><form id="photoForm" method="post">' +
		'	<table class="formTable2" border = "0" width = "100">' +
		'		<tr>' +
		'			<td align = "right" width = "100" >'+
		'				<div class="portfolio_sites"><div class="porffoilo_img">' +
		'	        		<img src="' + response.thumbPhoto + '" width="137" height="107" alt="" border = "0" /> ' +
		'				</div></div>' +
		'			</td>' +
		'		</tr>' +
		'	</table>' +
		'</form>';	
	
	$('#photoTitleContent').append(html);
	
	$('#photoId').val(response.photoId);
	$('#mainPhotoName').val(response.mainPhotoName);
}
</script>

<script src="<?php echo base_url()?>js/jquery.autocomplete.frontend.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?php echo base_url()?>css/jquery-ui/base/jquery.ui.all.css" type="text/css" />

<script src="<?php echo base_url()?>js/jquery-ui/jquery.ui.core.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery-ui/jquery.ui.widget.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery-ui/jquery.ui.datepicker.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?php echo base_url()?>css/jquery-ui/jquery.demo.css" type="text/css" />


<?php
	if (!isset($LOTTERY)) {
?>
<?php echo anchor('admincp/lottery', 'Lotteries'); ?><br /><br />
<?php
	}
?>
	
<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="manufactureForm" method="post" <?php echo (isset($LOTTERY)) ? 'action="/admincp/lottery/save_update"' : 'action="/admincp/lottery/save_add"' ?>>
<table class="formTable">
	
	<tr>
		<td width = "25%" nowrap>Lottery Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($LOTTERY) ? $LOTTERY->lotteryName : '') ?>" class="validate[required]" type="text" name="lotteryName" id="lotteryName"/><br />
		</td>
	</tr>
	
	<tr>
		<td width = "25%" nowrap>Restaurant</td>
		<td width = "75%">
			<input type="text" id="companyAjax" value="<?php echo (isset($LOTTERY) ? $LOTTERY->producer : '') ?>" style="width: 200px;" class="validate[required]" /> 
		</td>
	</tr>
	
	<tr>
		<td width = "25%">City</td>
		<td width = "75%">
			<input type="text" id="cityAjax" value="<?php echo (isset($LOTTERY) ? $LOTTERY->city : '') ?>" class="validate[required]" />
		</td>
	</tr>
	
	<tr>
		<td width = "25%">Info</td>
		<td width = "75%">
			<textarea name="info" id="info" class="validate[required]" rows = "8" cols = "40"><?php echo (isset($LOTTERY) ? $LOTTERY->info : '') ?></textarea><br />
		</td>
	</tr>
	
	<tr>
		<td width = "25%" nowrap>Start Date</td>
		<td width = "75%">
			<input value="<?php echo (isset($LOTTERY) ? $LOTTERY->startDate : '') ?>" class="validate[required]" type="text" name="startDate" id="startDate"/>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>End Date</td>
		<td width = "75%">
			<input value="<?php echo (isset($LOTTERY) ? $LOTTERY->endDate : '') ?>" class="validate[required]" type="text" name="endDate" id="endDate"/>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Draw Date</td>
		<td width = "75%">
			<input value="<?php echo ( (isset($LOTTERY) && !empty($LOTTERY->drawDate) ) ? $LOTTERY->drawDate : '') ?>" class="" type="text" name="drawDate" id="drawDate"/>
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>Result Date</td>
		<td width = "75%">
			<input value="<?php echo ( (isset($LOTTERY) && !empty($LOTTERY->resultDate) ) ? $LOTTERY->resultDate : '') ?>" class="" type="text" name="resultDate" id="resultDate"/>
		</td>
	</tr>
	
	<tr>
		<td width = "25%" nowrap>Photo</td>
		<td width = "75%">
			<div id="uploadContainer">
				<div class="demo">
				<input id="fileInput" name="fileInput" type="file" />
					<div id = "photoTitleContent">
					<?php
						if (isset($LOTTERY) ) {
							foreach($LOTTERY->photos as $photo) {
								$str = '<br /><form id="photoForm" method="post">' .
									'	<table class="formTable2" border = "0" width = "100">' .
									'		<tr>' .
									'			<td align = "right" width = "100" >'.
									'				<div class="portfolio_sites"><div class="porffoilo_img">' .
									'	        		<img src="' . $photo->thumbPhoto . '" width="137" height="107" alt="" border = "0" /> ' .
									'				</div></div>' .
									'			</td>' .
									'		</tr>' .
									'	</table>' .
									'</form>';
								echo $str;
							}
						}
					?>
					</div>
				</div>
			</div>
		</td>
	</tr>
	
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($LOTTERY)) ? 'Update Lottery' : 'Add Lottery' ?>">
			<input type = "hidden" name = "lotteryId" id = "lotteryId" value = "<?php echo (isset($LOTTERY) ? $LOTTERY->lotteryId : '') ?>">
			<input type = "hidden" name = "photoId" id = "photoId" value = "<?php echo ( (isset($LOTTERY) && isset($LOTTERY->photos[0]) ) ? $LOTTERY->photos[0]->photoId : '') ?>">
			<input type = "hidden" name = "mainPhotoName" id = "mainPhotoName" value = "">
			<input type = "hidden" name = "producerId" id = "producerId" value = "<?php echo (isset($LOTTERY) ? $LOTTERY->producerId : '') ?>">
			<input type = "hidden" name = "cityId" id = "cityId" value = "<?php echo (isset($LOTTERY) ? $LOTTERY->cityId : '') ?>">
		</td>
	</tr>
</table>
</form>

