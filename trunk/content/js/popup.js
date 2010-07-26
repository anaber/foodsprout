/***************************/
//@Author: Adrian "yEnS" Mato Gondelle
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

//SETTING UP OUR POPUP
//0 means disabled; 1 means enabled;
var popupStatus = 0;

//loading popup with jQuery magic!
function loadPopup(){
	//loads popup only if it is disabled
	if(popupStatus==0){
		
		$("#backgroundWhitePopup").css({
			"opacity": "0.7"
		});
		//$("#backgroundWhitePopup").fadeIn("slow");
		$("#backgroundWhitePopup").show();
		//$("#popupContact").fadeIn("fast");
		$("#popupContact").show();
		popupStatus = 1;
	}
}

//disabling popup with jQuery magic!
function disablePopup(){
	//disables popup only if it is enabled
	if(popupStatus==1){
		//$("#backgroundWhitePopup").fadeOut("slow");
		$("#backgroundWhitePopup").hide();
		//$("#popupContact").fadeOut("slow");
		$("#popupContact").hide();
		popupStatus = 0;
	}
}

//centering popup
function centerPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popupContact").height();
	var popupWidth = $("#popupContact").width();
	//centering
	$("#popupContact").css({
		"position": "absolute",
		"top": windowHeight/2-popupHeight/2,
		"left": windowWidth/2-popupWidth/2
	});
	//only need force for IE6
	
	$("#backgroundPopup").css({
		"height": windowHeight
	});
}

function loadPopupFadeIn(){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$('#popupProcessing').center();
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		
		$("#backgroundPopup").fadeIn("fast");
		$("#popupProcessing").fadeIn("fast");
		popupStatus = 1;
	}
}

function disablePopupFadeIn(){
	//disables popup only if it is enabled
	if(popupStatus==1){
		$("#backgroundPopup").fadeOut("fast");
		$("#popupProcessing").fadeOut("fast");
		popupStatus = 0;
	}
}

