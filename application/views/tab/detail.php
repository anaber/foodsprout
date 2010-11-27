<?php
// We may or may not have this data based on a $_GET or $_COOKIE based session.
//
// If we get a session here, it means we found a correctly signed session using
// the Application Secret only Facebook and the Application know. We dont know
// if it is still valid until we make an API call using the session. A session
// can become invalid if it has already expired (should not be getting the
// session back in this case) or if the user logged out of Facebook.
$session = $FACEBOOK->getSession();

$me = null;
// Session based API call.
if ($session) {
  try {
    $uid = $FACEBOOK->getUser();
    $me = $FACEBOOK->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
  }
}

// login or logout url will be needed depending on current user state.
if ($me) {
  $logoutUrl = $FACEBOOK->getLogoutUrl();
} else {
  $loginUrl = $FACEBOOK->getLoginUrl();
}

?>

    <!--
      We use the JS SDK to provide a richer user experience. For more info,
      look here: http://github.com/facebook/connect-js
    -->
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId   : '<?php echo $FACEBOOK->getAppId(); ?>',
          session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
          status  : true, // check login status
          cookie  : true, // enable cookies to allow the server to access the session
          xfbml   : true // parse XFBML
        });

        // whenever the user logs in, we refresh the page
        FB.Event.subscribe('auth.login', function() {
          window.location.reload();
        });
      };
      
      (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>

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

<div style = "font-size: 13px; text-decoration: none;"><a href = "#" id = "linkEnroll" style = "font-size: 13px; text-decoration: none;">Click here</a> to enter.  
	<?php if ($me) { ?>
	    <a href="<?php echo $logoutUrl; ?>">
	      <img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif" border = "0">
	    </a>
    <?php } else { ?>
	      Or <fb:login-button></fb:login-button> to enter. 
    <?php } ?>
<br /></div>


	
    <?php 
    	/*
    	if ($me) { 
    ?>
	    	<pre><?php print_r($session); ?></pre>
	    	<h3>You</h3>
	    	<img src="https://graph.facebook.com/<?php echo $uid; ?>/picture">
	    	<?php echo $me['name']; ?>
		    <h3>Your User Object</h3>
	    	<pre><?php print_r($me); ?></pre>
    <?php 
    	} else {
     		
    	}
    	*/
    ?>

<div style = "font-size: 13px; text-decoration: none;"><a href = "/tab" style = "font-size: 13px; text-decoration: none;">Go back</a> to previous screen.</div> 

<?php
	//print_r_pre($LOTTERY);
?>
