var Example2 = new (function() {
    var $countdown,
    
        $form, // Form used to change the countdown time
        incrementTime = 70,
        currentTime = parseInt($('#example2form #stipTime').val());
        test_id = $('#example2form #testID').val();
        //currentTime = 30000,
        updateTimer = function() {
            $countdown.html(formatTime(currentTime));
            if (currentTime == 0) {
                Example2.Timer.stop();
                timerComplete();
                //Example2.resetCountdown();
                return;
            }
            currentTime -= incrementTime / 10;
            if (currentTime < 0) currentTime = 0;
	    $('#example2form #stipTime').val(currentTime);//test
	    setSessionTime(currentTime,test_id);
        },
        timerComplete = function() {
	    alert("Time is up!");
	    document.getElementById('sub_ans').click();
        },
        init = function() {
            $countdown = $('#countdown');
            Example2.Timer = $.timer(updateTimer, incrementTime, true);
/*            $form = $('#example2form');
            $form.bind('submit', function() {
                Example2.resetCountdown();
                return false;
            });*/
        };
    this.resetCountdown = function() {
        var newTime = parseInt($form.find('input[type=hidden]').val()) * 100;
        if (newTime > 0) {currentTime = newTime;}
        this.Timer.stop().once();
    };
    $(init);
});

// Common functions
function pad(number, length) {
    var str = '' + number;
    while (str.length < length) {str = '0' + str;}
    return str;
}

function formatTime(time) {
    var min = parseInt(time / 6000),
        sec = parseInt(time / 100) - (min * 60),
        hundredths = pad(time - (sec * 100) - (min * 6000), 2);
    return (min > 0 ? pad(min, 2) : "00") + ":" + pad(sec, 2) + ":" + hundredths;
}

function setSessionTime(current_time,test_id){
   // alert('ttt');
    $.get('session_time.php', {'current_time': current_time , 'test_id' : test_id}, function(rs){
//	alert(rs);
    });
}
