@include('layouts.app')

{{--@section('content')--}}


{{--{{ $data }}--}}


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body text-center">
                        <a href="#" class="btn btn-success timer-start">Start</a>
                        <a href="#" class="btn btn-warning timer-pause">Pause</a>
                        <a href="#" class="btn btn-danger timer-stop">Stop</a>
                        <a href="#" class="btn btn-primary timer-restart">Restart</a>


                    </div>
                </div>
                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body">


                        <div class="alert alert-info text-center break">
                            You are currently on break for:

                        </div>
                        <div class="alert alert-success text-center work">
                            Task timer:
                        </div>

                        <div class="alert alert-danger text-center stopConfirm">
                            <p>Confirm stopping timer</p>
                            <button class="btn btn-danger stopBtn">Confirm</button>
                        </div>

                        <div class="alert alert-warning text-center pauseConfirm">
                            <p>Confirm pausing timer</p>
                            <button class="btn btn-warning pauseBtn">Confirm</button>
                        </div>

                        <div class="alert alert-info text-center restartConfirm">
                            <p>Confirm restarting timer</p>
                            <button class="btn btn-info restartBtn">Confirm</button>
                        </div>


                        <div class="timer text-center"></div>
                        <div class="startTime"></div>



                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Previous logs
                    </div>
                    <div class="card-body">
                        <table id="table_id" class="display">
                            <thead>
                            <tr>
                                <th>Start time</th>
                                <th>End time</th>
                                <th>Start date</th>
                                <th>End date</th>
                            </tr>
                            </thead>
                            <tbody>
{{--                            @foreach($data as $row => $key)--}}
{{--                                <tr>--}}
{{--                                    @foreach($key as $sth => $ss)--}}
{{--                                        <td> {{$ss}}</td>--}}
{{--                                    @endforeach--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}

                            </tbody>
                        </table>
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
{{--throw exception if break is longer than 60 minutes --}}
{{--starts counting again when returns after break--}}


{{--keep break timer in session--}}



<script>
    var seconds = 0;
    var minutes = 0;
    var hours = 0;
    var t;
    var timeout;
    var h;
    var m;
    var s;
    var breakTimeout;

    $(".timer-start").click(timer);
    $(".timer-pause").click(pause);
    $(".timer-restart").click(restartTimer);
    $(".timer-stop").click(stop);
    $(".work").hide();
    $(".break").hide();
    $(".stopConfirm").hide();
    $(".pauseConfirm").hide();
    $(".restartConfirm").hide();

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
    $(document).ready( function () {
        $('#table_id').DataTable();
    } );




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
        $(".break").hide();
        $(".restartConfirm").show();

        $(".restartBtn").click(() => {
            $(".work").show();

            hours = sessionStorage.getItem('hour');
            minutes = sessionStorage.getItem('minute');
            seconds = sessionStorage.getItem('second');

            if(seconds > 5)
            {
                minutes++;
            }

            let breakTime = {
                minutes: minutes
            };

            $.ajax({
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: 'timer/pause',
                data: breakTime ,
                success: () => {
                    $(".restartConfirm").hide();
                    $(".btn").removeClass("disabled");
                }
            });

            //todo start counting
        });






    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }

    function add() {
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
        sessionStorage.setItem('hour', hours);
        sessionStorage.setItem('minute', minutes);
        sessionStorage.setItem('second', seconds);
        countTime();
    }

    function timer() {
        $(".work").show();

        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'timer/start',
            success: (data) => {
                isValid(data);
                //startTimer();
            }
        });
    }

    function isValid(data) {
        if(data)
        {
            startTimer();
        } else {
            alert('Stop the timer first');
        }
    }

    function countTime()
    {
        timeout = setTimeout(add, 1000);
    }
    //
    // function countBreak()
    // {
    //     breakTimeout = setTimeout(add, 1000);
    // }

    function pause()
    {

        $(".work").hide();
        $(".stopConfirm").hide();
        $(".restartConfirm").hide();
        $(".pauseConfirm").show();
        $(".timer").html('');
        clearTimeout(timeout);


        $(".pauseBtn").click(() => {

            $(".break").show();
            $(".pauseConfirm").hide();

            $(".timer-start").addClass("disabled");
            $(".timer-stop").addClass("disabled");
            $(".timer-pause").addClass("disabled");


            sessionStorage.clear();
            seconds = 0;
            minutes = 0;
            hours = 0;
            countTime();
        });



    }

    function stop()
    {
        $(".work").hide();
        $(".stopConfirm").show();
        $(".timer").html('');

        sessionStorage.clear();
        clearTimeout(timeout);

       $(".stopBtn").click( () => {
           $.ajax({
               type: 'POST',
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               url: 'timer/stop',
               success: () => {
                   $(".stopConfirm").hide();
               }
           });
       });
    }



</script>