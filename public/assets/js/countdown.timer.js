var countdownInterval = [];
var currentSeconds = [];

jQuery.countDownTimer = function(element, option){
    var defaults = {
        name: 'ct',
        includeTimer: {
            hour: 0,
            minutes: 1,
            seconds: 1,
            type: 0
        },
        hours: 0,
        minutes: 5,
        seconds: 0,
        interval: 1000,
        isMilitaryTime: 0,
        isCountUp: 0,
        isRealTime: 0,
        txtInitial: "",
        txtEnd: "",
        callBack: function(e){

        }
    };
    // merge
    var options = $.extend({}, defaults, option);
    var hours = options.hours, minutes = options.minutes, seconds = options.seconds;
    var name = options.name ? options.name : "ct";
    if(!(name in currentSeconds)){
        currentSeconds[name] = 0;
    }

    if(!options.isCountUp){
        currentSeconds[name] += hours * 3600;
        currentSeconds[name] += minutes * 60;
        currentSeconds[name] += seconds;
    }
    var type = "";

    countdownInterval[name] = setInterval(function(e){
        if(options.isRealTime){
            var time = new Date();
            hours = options.isMilitaryTime ? (time.getHours() > 12 ? (time.getHours() - 12) : time.getHours()) : time.getHours();
            minutes = time.getMinutes();
            seconds = time.getSeconds();
            type = time.getHours() > 12 ? 'pm' : 'am';
        }
        else{
            var incVal = options.isCountUp ? 1 : -1;
            currentSeconds[name] += incVal;

            var nextSeconds = seconds + incVal;
            seconds = options.isCountUp ?
                (nextSeconds > 59 ? 0 : nextSeconds) :
                (nextSeconds < 0 ? 59 : nextSeconds);
            var nextMinute = minutes + incVal;
            minutes = options.isCountUp ?
                (nextSeconds > 59 ? (nextMinute > 59 ? 0 : nextMinute) : minutes) :
                (nextSeconds < 0 ? (nextMinute < 0 ? 59 : nextMinute) : minutes);
            var nextHour = hours + incVal;
            hours =
                options.isCountUp ?
                (nextMinute > 59 && nextSeconds > 59 ? nextHour : hours) :
                (nextHour > 0 && nextMinute < 0 && nextSeconds < 0 ? nextHour : hours);
            type = hours > 12 ? 'pm' : 'am';
        }

        var timerStr =
            options.txtInitial +
            (options.includeTimer.hour ? $.strPad(hours, 2) + ':' : '') +
            $.strPad(minutes, 2) + ':' + $.strPad(seconds, 2) +
            (options.includeTimer.type ? type : '') +
            options.txtEnd;
        if(element[0].value !== undefined) {
            element.val(timerStr);
        }
        else{
            element.html(timerStr);
        }

        if(!options.isCountUp && hours == 0 && minutes == 0 && seconds == 0){
            options.callBack();
            clearInterval(countdownInterval[name]);
        }
    }, options.interval);
};

jQuery.addCountDownTimer = function(option){
    var defaults = {
        name: 'ct',
        seconds: 0
    };
    var options = $.extend({}, defaults, option);
    var name = options.name ? options.name : "ct";

    if(!(name in currentSeconds)){
        currentSeconds[name] = 0;
    }
    currentSeconds[name] += options.seconds;
};

jQuery.stopCountDownTimer = function(option){
    var defaults = {
        name: 'ct',
        clear_time: 0
    };
    var options = $.extend({}, defaults, option);
    var name = options.name ? options.name : "ct";
    if(options.clear_time){
        currentSeconds[name] = 0;
    }
    clearInterval(countdownInterval[name]);
};

jQuery.getCurrentCountDownTime = function(option){
    var defaults = {
        format: '',
        name: 'ct',
        seconds: ''
    };
    var options = $.extend({}, defaults, option);

    var format = options.format;
    var name = options.name ? options.name : "ct";
    var cs = options.seconds ? options.seconds : currentSeconds[name];

    var $minutes = parseInt(cs/60);
    var $hoursValue = parseInt($minutes/60);
    var $minutesValue = $minutes - ($hoursValue * 60);
    var $secondsValue = cs - (($hoursValue * 3600) + ($minutesValue * 60));
    var type = $hoursValue > 12 ? 'pm' : 'am';

    var value = cs;
    switch (format){
        case 'A':
            value = $.strPad($hoursValue, 2) + ':' + $.strPad($minutesValue, 2) + ':' + $.strPad($secondsValue, 2) + ' ' + type;
            break;
        case 'H':
            value = $.strPad($hoursValue, 2) + ':' + $.strPad($minutesValue, 2) + ':' + $.strPad($secondsValue, 2);
            break;
        case 'a':
            $hoursValue = $hoursValue > 12 ? 12 : $hoursValue;
            value = $.strPad($hoursValue, 2) + ':' + $.strPad($minutesValue, 2) + ':' + $.strPad($secondsValue, 2) + ' ' + type;
            break;
        case 'h':
            $hoursValue = $hoursValue > 12 ? 12 : $hoursValue;
            value = $.strPad($hoursValue, 2) + ':' + $.strPad($minutesValue, 2) + ':' + $.strPad($secondsValue, 2);
            break;
        case 'm':
            value = $.strPad($minutesValue, 2) + ':' + $.strPad($secondsValue, 2);
            break;
        case 's':
            value = $.strPad($secondsValue, 2);
            break;
    }

    return value;
};
jQuery.strPad = function(i,l,s) {
    var o = i.toString();
    if (!s) { s = '0'; }
    while (o.length < l) {
        o = s + o;
    }
    return o;
};