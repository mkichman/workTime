@include('layouts.app')

{{--@section('content')--}}

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <a href="#" class="btn btn-success timer-start">Start</a>
                        <a href="#" class="btn btn-warning timer-pause">Pause</a>
                        <a href="{{route('stopTimer')}}" class="btn btn-danger timer-stop">Stop</a>
                        <a href="#" class="btn btn-primary timer-restart">Restart</a>

                        <div class="timer"> Timer</div>


                        <div class="startTime"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--@endsection--}}

{{--TODO--}}
{{--keep timer in session - displays start time and counter after page refresh--}}
{{--pause if counter is counting, restart button if timer is paused--}}
{{--confirm modal on stopping timer--}}
{{--pausing starts break counter--}}
{{--confirm modal on pause--}}

<script>
    var seconds = 0;
    var minutes = 0;
    var hours = 0;
    var t;
    var timeout;
    var h;
    var m;
    var s;

    $(".timer-start").click(timer);
    $(".timer-pause").click(pause);
    $(".timer-restart").click(countTime);
    $(".timer-stop").click(stop);

    window.onload = () => {
        let hour = sessionStorage.getItem('hour');
        if(hour)
        {
            hours = hour;
            minutes = sessionStorage.getItem('minute');
            seconds = sessionStorage.getItem('second');
            let timePassed = sessionStorage.getItem('counter');
            let startTime =  sessionStorage.getItem('startTime');
            $(".timer").html(hours + ':' + minutes + ':' + seconds);
            $('.startTime').html(startTime);

            countTime();
        }
    };





    function startTimer()
    {
        var today = new Date();
        h = today.getHours();
        m = today.getMinutes();
        s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        $('.startTime').html(h + ":" + m + ":" + s);

        sessionStorage.setItem('startTime', h + ":" + m + ":" + s);





        countTime();
    }

    function restartTimer()
    {
        countTime();
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }

    function add() {
        //console.log('qwer');
        seconds++;
        if (seconds >= 60) {
            seconds = 0;
            minutes++;
            if (minutes >= 60) {
                minutes = 0;
                hours++;
            }
        }
        $('.timer').html(hours + ':' + minutes + ':' + seconds);
        //console.log('hours: ' + hours + 'minutes ' + minutes + 'seconds ' + seconds);
       // sessionStorage.setItem('counter', hours + ':' + minutes + ':' + seconds);
        sessionStorage.setItem('hour', hours);
        sessionStorage.setItem('minute', minutes);
        sessionStorage.setItem('second', seconds);
        countTime();
    }

    function timer() {
        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'timer/start',
            success: () => {
                startTimer();
            }
        });
    }

    function countTime()
    {
        timeout = setTimeout(add, 1000);
    }

    function pause()
    {
       clearTimeout(timeout);
    }

    function stop()
    {
        sessionStorage.clear();
    }

</script>