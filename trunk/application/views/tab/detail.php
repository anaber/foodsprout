<script src="<?php echo base_url()?>js/floating_messages.js" type="text/javascript"></script>

<script type="text/javascript">
<?php
	
	if ($this->session->userdata('isAuthenticated') == 1 ) {
		echo 'var isAuthenticated = true;';
	} else {
		echo 'var isAuthenticated = false;';
	}
?>
var lotteryId = <?php echo $LOTTERY->lotteryId;?>;

$(document).ready(function() {
	
	
	$("#linkEnroll").click(function(e) {
		e.preventDefault();
		
		if (isAuthenticated == true) {
			var $alert = $('#alert');
			displayProcessingMessage($alert, "Processing...");
			var formAction = '/tab/enroll';
			postArray = {
						  lotteryId:lotteryId
						};
			$.post(formAction, postArray,function(data) {
				
				if(data=='yes') {
					displayFailedMessage($alert, "Thanks! You have been enrolled for the lottery.");
					hideMessage($alert, '', '');
				} else if(data == 'already_enrolled') {
					displayFailedMessage($alert, "You have already enrolled once...");
					hideMessage($alert, '', '');
				} else {
					displayFailedMessage($alert, "Cannot be enrolled...");
					hideMessage($alert, '', '');
				}
			});
			
		} else {
			var returnUrl = '/tab/detail/' + lotteryId;
			document.location='/login?return=' + returnUrl;
		}
		
		return false; //not to post the  form physically
		
	});
	
});

</script>
<div id="alert"></div>
<div style = "font-size: 13px;">
<strong>This weeks deal</strong><br>
Restaurant Name: <?php echo $LOTTERY->restaurantName; ?><br />
City Name: <?php echo $LOTTERY->city; ?><br />
Start Date: <?php echo date('m-d-Y', strtotime($LOTTERY->startDate) ); ?><br />
End Date: <?php echo date('m-d-Y', strtotime($LOTTERY->endDate) ); ?><br />
Results come out on: <?php echo date('m-d-Y', strtotime($LOTTERY->resultDate) ); ?><br /><br />

Prizes:<br />
<?php
foreach ($LOTTERY->prizes as $key => $prize) {
	echo $prize->prize . " : $" . number_format($prize->dollarAmount, 2) . "<br />";
}
?>
</div>
<br>

<div style = "font-size: 13px; text-decoration: none;"><a href = "#" id = "linkEnroll" style = "font-size: 13px; text-decoration: none;">Click here</a> to enter.  <!--Or use Facebook to enter.--> <br /></a>


<div style = "font-size: 13px; text-decoration: none;"><a href = "/tab" style = "font-size: 13px; text-decoration: none;">Go back</a> to previous screen.</div> 

<?php
	//print_r_pre($LOTTERY);
?>
