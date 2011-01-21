<!-- Lottery section starts here -->
<?php
	$currentCity = '';
	$currentIndex = 0;
	$lotteryId = '';
	
	if ( $LOTTRIES['param']['numResults'] > 0 ) {
		$currentCity = $LOTTRIES['results'][0]->cityId;
		
		$id = $this->input->get('id');
	
		if ($id) {
			$i = 0;
			foreach ($LOTTRIES['results'] as $lottery) {
				if ($id == $lottery->lotteryId) {
					$currentIndex = $i;
					$lotteryId = $lottery->lotteryId;
				}
				$i++;
			}
		} else {
			$lotteryId = $LOTTRIES['results'][$currentIndex]->lotteryId;
		}
		
	}
	
	//print_r_pre($LOTTRIES);
	//print_r_pre($CITIES);
?>
<script src="<?php echo base_url()?>js/jquery.lightbox-0.5.js" type="text/javascript"></script>
<script>
$(function() {
	$('#gallery a').lightBox({fixedNavigation:true});
});
</script>
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
				//$("#linkEnrollFacebook2").click();
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
var lotteryId = "<?php echo $lotteryId; ?>";

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
			var returnUrl = '/tab?id=' + lotteryId;
			document.location='/login?return=' + returnUrl;
		}
		
		return false; //not to post the  form physically
		
	});
	
	$("#linkEnrollFacebook").click(function(e) {
		e.preventDefault();
		
		var $alert = $('#alert');
		displayProcessingMessage($alert, "Processing...");
		var formAction = '/tab/enroll';
		postArray = {
					  lotteryId:lotteryId,
					  fbUserId:$("#fbUserId").val(),
					  fbToken:$("#fbToken").val()
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
		
		return false; //not to post the  form physically
		
	});
});

</script>

<div id="alert"></div>

<div id="lottery">
<?php
	if ($lotteryId != "") {
?>
	
	<!-- Lottery header starts here -->
	<div>
		<h1 class="flt">Tab's on us in <span><?php echo $CITIES[$currentCity]->city . ', ' . $CITIES[$currentCity]->stateCode;?></span></h1>
		<div class="changecity flt">
			<a href="#" onclick="$('#listOfCities').show();">Change City</a> <img src="/img/city_arrow.png" alt="" width="11" height="7" />
			<ul id = "listOfCities" style = "display:none;">
				<?php
					foreach($CITIES as $city) {
						echo '<li><a href = "/tab?city='.$city->cityId.'">'.$city->city.', '.$city->stateCode.'</a></li>';
					}
				?>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<h2>Enter to dine at <?php echo $LOTTRIES['results'][$currentIndex]->producer; ?> and sample their sustainable food.</h2>
	<!-- Lottery header ends here -->
	
	<!-- Lottery content area starts here -->
	<div class="lottery_content_area">
		<!-- Lottery content area left starts here -->
		<div class="lottery_contentlt flt">
			<h3><?php echo $LOTTRIES['results'][$currentIndex]->producer; ?><br/><span><?php echo $LOTTRIES['results'][$currentIndex]->city . ', ' . $LOTTRIES['results'][$currentIndex]->stateCode; ?></span></h3>
			<a href="/restaurant/<?php echo $LOTTRIES['results'][$currentIndex]->customURL; ?>">View Restaurant Details</a><br>
			
			<?php
			
			//
			//  Check for session, if no, show login info
			//
			
			if ($this->session->userdata('isAuthenticated') == 1 ) {
			?>
				<div class="enternow">
				<div class="flt"><a title="click here to login" href="" id = "linkEnroll" class="button_img"><span>Enter Now</span></a></div>
				</div>
				<br /><br />
			<?php
			} else if ( $me ) {
			
			?>
				<div class="enternow">
					<div class="flt fbconnect">
				    	<a href="#" id = "linkEnrollFacebook"><img src="/img/fb-button-enter.gif" alt="Facebook Users" title="Facebook Users" border="0" /></a>
				    </div>
			    </div>
			    <?php
			    /*
			    ?>
			    <a href="<?php echo $logoutUrl; ?>">
			      <img src="<?php echo base_url();?>images/f_logout.png" border = "0">
			    </a>
			    <?php
			    */
			    ?>
			    <input type = "hidden" name = "fbUserId" id = "fbUserId" value = "<?php echo $session['uid']; ?>">
				<input type = "hidden" name = "fbToken" id = "fbToken" value = "<?php echo $session['access_token']; ?>">
				<br /><br />
			<?php	
			
			}
			else
			{
				
			?><br><br>
			To enter for a chance to win you will need to login.
			<div class="enternow">
				<div style="margin-bottom:4px;"><a title="click here to login" href="" id = "linkEnroll" class="button_img"><span>Login to Enter</span></a></div>
				
				<div>
					<span style="font-size:18px;vertical-align:bottom;">&nbsp;Or use:</span> <fb:login-button>Login</fb:login-button>
				</div>
				<a href="#" id = "linkEnrollFacebook2"></a>
				<div class="clear"></div>
			</div>
			<?php 
			}
			?>	
			<div class="clear"></div>
			<div class="prizedate">
				<ul>
					<li class="marginrt"><span>Ends on:</span> <?php echo $LOTTRIES['results'][$currentIndex]->endDate; ?></li>
					<li><span>Results: <?php echo $LOTTRIES['results'][$currentIndex]->resultDate; ?></span></li>
				</ul>
				<div class="clear"></div>
				<?php
					$prizeCount = count($LOTTRIES['results'][$currentIndex]->prizes);
					
					if ($prizeCount > 0) {
				?>
					<div class="prize">Prizes: Free Gift Certificate worth 
				<?php
						$i = 0;
						foreach ( $LOTTRIES['results'][$currentIndex]->prizes as $prize ) {
							if ($i == 0) {
								echo "$" . $prize->dollarAmount;
							} else {
								if ($i == ($prizeCount-1) ) {
									echo " and $" . $prize->dollarAmount;
								} else {
									echo ", $" . $prize->dollarAmount;
								}
							}
							$i++;
						}
				?>
					</div>
				<?php
					}
				?>
				
			</div>
			<p align = "justify"><?php echo nl2br($LOTTRIES['results'][$currentIndex]->info); ?></p>
		</div>
		<!-- Lottery content area left ends here -->
		  
		<!-- Lottery content area right starts here -->  
		<div class="lottery_contentrt frt"><img src="<?php echo $LOTTRIES['results'][$currentIndex]->photos[0]->photo; ?>" alt="<?php echo $LOTTRIES['results'][$currentIndex]->producer; ?>, <?php echo $LOTTRIES['results'][$currentIndex]->city . ', ' . $LOTTRIES['results'][$currentIndex]->stateCode; ?>" title="<?php echo $LOTTRIES['results'][$currentIndex]->producer; ?>, <?php echo $LOTTRIES['results'][$currentIndex]->city . ', ' . $LOTTRIES['results'][$currentIndex]->stateCode; ?>" width="500" height="337" /></div>
		<!-- Lottery content area right ends here --> 
		<div class="clear"></div>
	</div>
	<!-- Lottery content area ends here -->
<?php
	} else {
?>
	<!-- Lottery header starts here -->
	<div>
		<h1 class="flt">The Tab's on us</h1>
		<div class="clear"></div>
	</div>
	<h2>No deals available for this week in any of the cities.</h2>
	<!-- Lottery header ends here -->
<?php
	}
?>
	<?php
		if (count($LOTTRIES['results']) > 1) {
	?>
	<div>
		<h4>Other Deals in <?php echo $CITIES[$currentCity]->city;?> </h4>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				
				<td width="15%" class="deals_head">Photo</td>
				<td width="15%" class="deals_head">Enter</td>
				<td width="20%" class="deals_head">Restaurants</td>
				<td width="20%" class="deals_head">City</td>
				<td width="15%" class="deals_head">Prize</td>
				<td width="15%" class="deals_head">Ends On</td>
				
			</tr>
		<?php
			$i = 0;
			foreach ($LOTTRIES['results'] as $lottery) {
				if ($i == $currentIndex) {
					
				} else {
		?>
			<tr>
				<td class="deal_firstrow"><img src="<?php echo $lottery->photos[0]->thumbPhoto; ?>" alt="" width="100" height="67"class="deals_pic"/></td>
				<td class="deal_firstrow"><div class="flt"><a title="click here to grab it" href="/tab?id=<?php echo $lottery->lotteryId; ?>" class="button_img"><span>View Details</span></a></div></td>
				<td class="deal_firstrow"><a href="/restaurant/<?php echo $lottery->customURL; ?>"><?php echo $lottery->producer; ?></a></td>
				<td class="deal_firstrow"><?php echo $lottery->city . ', ' . $lottery->stateCode; ?></td>
				<td class="deal_firstrow black">
				<?php
					$j = 0;
					foreach ( $lottery->prizes as $prize ) {
						if ($j == 0) {
							echo "$" . $prize->dollarAmount;
						} else {
							echo "<br />$" . $prize->dollarAmount;
						}
						$j++;
					}
				?>
				</td>
				<td class="deal_firstrow"><?php echo $lottery->endDate; ?></td>
				
			</tr>
		<?php
				}
				$i++;
			}
		?>
			
		</table>
	</div>
	<?php
		}
	?>
	
</div>
<!-- Lottery section ends here -->
