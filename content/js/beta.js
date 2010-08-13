jQuery(document).ready(function($){
	
	$('#show-login-button').click(function(event){
		event.preventDefault();
		if($(this).hasClass('active')){
			$(this).removeClass('active');
			$('#login-form').stop(true, false).fadeOut(200);		
		} else {
			$(this).addClass('active');
			$('#login-form').stop(true, false).fadeIn(200);
		}
	});
});