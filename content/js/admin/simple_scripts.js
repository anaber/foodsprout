function disableButtonWhenProcessing(){
    $('.critical_form').submit(function(e){
        var button = 'input[type="submit"]';
        
        $(button).addClass('disabled_button');
        $(button).attr('value','Processing...');
        $(button).attr('disabled', 'true');
    });
}

$(function(){
    disableButtonWhenProcessing();
});