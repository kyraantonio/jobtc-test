(function( $ ){
    $.fn.numberOnly = function(option) {
        var defaults = {
            "wholeNumber": false,
            "isForContact": false,
            "alertSomething": true,
            "isPercentage": false,
            "maxVal": 100,
            "hasMaxChar": false,
            "enableDash": true,
            "maxCharLen": 0
        };
        // merge
        var options = $.extend({}, defaults, option);

        if(options.hasMaxChar){
            $(this).attr('maxLength', options.maxCharLen);
        }

        $(this).keydown(function(event) {
            // Allow: backspace, delete, tab, escape, and enter

            var code = (event.keyCode ? event.keyCode : event.which);
            console.log(code);
            if ( event.keyCode == 46 || event.keyCode == 40 ||
                    (event.ctrlKey === true && event.keyCode == 109) ||
                    // Allow copy, paste and cut
                    ((event.keyCode == 65 ||  event.keyCode == 86 || event.keyCode == 88 || event.keyCode == 67)
                        && (event.ctrlKey === true || event.keyCode == 17)) ||
                    // Allow "-"
                    (options.enableDash === true && event.keyCode == 109) ||
                    event.keyCode == 189 ||
                    event.keyCode == 8 || event.keyCode == 9 ||
                    event.keyCode == 27 || event.keyCode == 13 ||
                    event.keyCode == 61 || event.keyCode == 173 ||
                    event.keyCode == 32 || (event.shiftKey && (event.keyCode == 57 || event.keyCode == 48)) ||
                    // Allow: Ctrl+A
                    (event.keyCode == 65 && event.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (event.keyCode >= 35 && event.keyCode <= 39) ||
                    // Allow: decimal
                    (((event.keyCode == 110) || (event.keyCode == 190)) && options.wholeNumber == false) ||
                    //Allow: dash
                    (((options.enableDash === true && event.keyCode == 109) || (event.keyCode == 189) )&& options.isForContact == true)
                ) {
                    //Allow: decimal to fire once only
                    if((event.keyCode == 110 || event.keyCode == 190) && $(this).val().indexOf('.') != -1){
                        event.preventDefault();
                    }
                    // let it happen, don't do anything
                    return;
            }
            else {
                // Ensure that it is a number and stop the keypress
                if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                    event.preventDefault();
                }
            }
        })
        .keyup(function(e){
            if(options.isPercentage){
                if($(this).val() > options.maxVal){
                    $(this).val(options.maxVal);
                }
            }
        });
    };
})( jQuery );