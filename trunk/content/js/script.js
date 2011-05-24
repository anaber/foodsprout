function tagAte() {
    // apply fancybox to link
    $('.tagAte').fancybox({
        'scrolling':'no'
    });
    
    // apply slider
    $('#risk_slider_meter').slider({
        'value':15,
        'max':25,
        'disabled':true
    });
    
    $('#risk_slider_value').html('High Risk: ' + $('#risk_slider_meter').slider('value')
        + ' of ' + $('#risk_slider_meter').slider("option", 'max'));
}

function tagAteForm(){
    $('label[for*="rating_"]').hide();
    
    // apply rating 
    $('input.star2').rating({
        'required':true
    });
    
    // apply ajax form
    $('form#id_form_ate').ajaxForm({
        'success':removeProcessing,
        'error':handleAjaxErrors
    });
    
    // apply throbber
    $('form#id_form_ate').throbber('submit', {
        'image':'/js/throbber/throbber.gif',
        'wrap':'<div style="text-align:center;padding-top:20px;"></div>'
    });
}

function removeProcessing(response, status){
    console.log(response.status);
    $('form#id_form_ate').closest('ul').replaceWith('<p class="ajax_success" style="color:green; font-size:10px;">Submission is successful! This window will close in 5 seconds.');
    $.throbberHide();
    
    // set timeout
    setTimeout($.fancybox.close, 5000);
}

function handleAjaxErrors(xhr, status, error){
    $('form#id_form_ate').closest('ul').replaceWith('<p class="ajax_error" style="color:red; font-size:10px;">An error has occurred.Please try again later.</p>');
    $.throbberHide();
}