var alerttimer;
function displayProcessingMessage($alert, message) {
	
	$alert.removeClass().addClass('alertSuccess').text(message).animate({height: $alert.css('line-height') || '100px', top:$(window).scrollTop()+"px" }, 500);
	alerttimer = window.setTimeout(function () {
		$alert.trigger('click');
	}, 1000);
	
	//scroll the message box to the top offset of browser's scrool bar
	$(window).scroll(function()
	{
	  $alert.animate({top:$(window).scrollTop()+"px" },{queue: false, duration: 350});
	});
}

function displayFailedMessage($alert, message) {
	$alert.click(function () {
		window.clearTimeout(alerttimer);
		//$alert.removeClass().addClass('alertError').text(message);
		$alert.removeClass().addClass('alertSuccess').text(message);
		
		alerttimer = window.setTimeout(function () {
			$alert.trigger('dblclick');
		}, 4000);
	});
}

function displaySuccessMessage($alert, message) {
	$alert.click(function () {
		window.clearTimeout(alerttimer);
		$alert.removeClass().addClass('alertSuccess').text(message);
		
		alerttimer = window.setTimeout(function () {
			$alert.trigger('dblclick');
		}, 4000);
		
	});
}

function hideMessage($alert, location, method) {
	$alert.dblclick(function () {
		//alert("Hide Event triggered");
		window.clearTimeout(alerttimer);
		//$alert.animate({height: '0'}, 500);
		
		alerttimer = window.setTimeout(function () {
			$alert.animate({height: '0'});
			if (location != '') {
				$alert.trigger('focusin');
			}
			
			if (method != '') {
				eval(method);
			}
			
		}, 500);
	});
	
	$alert.focusin(function () {
		window.clearTimeout(alerttimer);
		
		alerttimer = window.setTimeout(function () {
			$alert.trigger('mouseover');
		}, 200);
	});
	
	$alert.mouseover(function () {
		window.clearTimeout(alerttimer);
		if (location != '') {
			document.location = location;
		}
	});
	
}
