<?php
/*
 * Created on Mar 1, 2010
 *
 * Author: Deepak Kumar
 */
?>
<script>
var documentLocation = '';
documentLocation = '/admincp/lottery/add_prize/<?php echo $LOTTERY_ID; ?>';

formValidated = true;

$(document).ready(function() {
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#supplierForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	$("#prizeForm").submit(function() {
		
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
			
			if ($('#lotteryPrizeId').val() != '' ) {
				var formAction = '/admincp/lottery/prize_save_update';
				
				postArray = {
							  dollarAmount:$('#dollarAmount').val(),
							  prize:$('#prize').val(),
							  lotteryId:$('#lotteryId').val(),
							  
							  lotteryPrizeId: $('#lotteryPrizeId').val()
							};
				act = 'update';
			} else {
				formAction = '/admincp/lottery/prize_save_add';
				postArray = { 
							  dollarAmount:$('#dollarAmount').val(),
							  prize:$('#prize').val(),
							  lotteryId:$('#lotteryId').val()
							  
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
								document.location = documentLocation;
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location = documentLocation;
							});
						}
					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Prize...').addClass('messageboxerror').fadeTo(900,1);
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

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="prizeForm" method="post">
<table class="formTable">
	
	<tr>
		<td width = "25%" nowrap>Prize</td>
		<td width = "75%">
			<input value="<?php echo (isset($PRIZE) ? $PRIZE->prize : '') ?>" class="validate[required]" type="text" name="prize" id="prize"/><br />
		</td>
	</tr>
	
	<tr>
		<td width = "25%" nowrap>Dollar Amount</td>
		<td width = "75%">
			<input  value="<?php echo (isset($PRIZE) ? $PRIZE->dollarAmount : '') ?>" class="validate[required]"  type="text" name="dollarAmount" id="dollarAmount"/><br />
		</td>
	</tr>
	
	
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($PRIZE)) ? 'Update Prize' : 'Add Prize' ?>">
			<input type = "button" name = "btnReset" id = "btnReset" value = "Reset" class = "button">
			<input type = "hidden" name = "lotteryPrizeId" id = "lotteryPrizeId" value = "<?php echo (isset($PRIZE) ? $PRIZE->lotteryPrizeId : '') ?>">			
			<input type = "hidden" name = "lotteryId" id = "lotteryId" value = "<?php echo (isset($LOTTERY_ID) ? $LOTTERY_ID : '') ?>">
		</td>
	</tr>
</table>
</form>

<table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "50%">
	<tr>
		<th>Id</th>
		<th>Prize</th>
		<th>Amount</th>
		<th>Winner</th>
	</tr>
<?php
	
	$controller = $this->uri->segment(2);
	
	$i = 0;
	foreach($PRIZES as $prize) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('/admincp/lottery/update_prize/'.$prize->lotteryPrizeId, $prize->lotteryPrizeId).'</td>';
		echo '	<td>'.anchor('/admincp/lottery/update_prize/'.$prize->lotteryPrizeId, $prize->prize) .'</td>';
		echo '	<td>' . $prize->dollarAmount . '</td>';
		echo '	<td>--</td>';
		echo '</tr>';
 	endforeach;
 	
?>
</table>
