@include('layouts.app')


<div class="container">
    <div class="row ">
        <div class="col-md-4">
            <div class="card">

                <div class="card-body text-center">
                    <a href="#" class="btn btn-success timer-start btn-lg">Start</a>
                    <a href="#" class="btn btn-warning timer-pause btn-lg">Pause</a>
                    <a href="#" class="btn btn-danger timer-stop btn-lg">Stop</a>
                </div>
            </div>
        </div>
            <div class="card col-md-8">

                <div class="card-body">


                    <div class="alert alert-info text-center break">
                        <a href="#" class="btn btn-primary timer-restart btn-lg">Start working</a>
                        <hr>
                        <p>You are currently on break for:</p>

                    </div>
                    <div class="alert alert-success text-center work">
                        Task timer:
                    </div>

                    <div class="alert alert-danger text-center stopConfirm">
                        <p>Confirm stopping timer</p>
                        <button class="btn btn-danger stopBtn btn-lg">Confirm</button>
                    </div>

                    <div class="alert alert-warning text-center pauseConfirm">
                        <p>Confirm pausing timer</p>
                        <button class="btn btn-warning pauseBtn btn-lg">Confirm</button>
                    </div>

                    <div class="alert alert-info text-center restartConfirm">
                        <p>Confirm restarting timer</p>
                        <button class="btn btn-info restartBtn btn-lg">Confirm</button>
                    </div>


                    <div class="timer text-center"></div>
                    <div class="startTime"></div>


                </div>
            </div>



    </div>
</div>



<script>
    var seconds = 0;
    var minutes = 0;
    var hours = 0;
    var timeout;
    var result;
    var sth;

    $(".timer-start").click(timer);
    $(".timer-pause").click(pause);
    $(".timer-restart").click(restartTimer);
    $(".timer-stop").click(stop);
    $(".work").hide();
    $(".break").hide();
    $(".stopConfirm").hide();
    $(".pauseConfirm").hide();
    $(".restartConfirm").hide();

    $(".timer-pause").addClass("disabled");


    window.onload = () => {

        $(".timer-restart").addClass("disabled");

        let hour = sessionStorage.getItem('hour');
        if (hour) {
            hours = hour;
            minutes = sessionStorage.getItem('minute');
            seconds = sessionStorage.getItem('second');
            $(".timer").html(hours + ':' + minutes + ':' + seconds);
            countTime();

            if (sessionStorage.getItem('pause')) {
                $(".break").show();
                $(".timer-start").addClass("disabled");
                $(".timer-stop").addClass("disabled");
                $(".timer-pause").addClass("disabled");
                $(".timer-restart").removeClass("disabled");
            } else {
                $(".work").show();
            }
        }
    };


    function restartTimer() {
        $(".break").hide();
        $(".restartConfirm").show();
        clearTimeout(timeout);
        $(".timer").html('');

        $(".restartBtn").click(() => {
            $(".work").show();

            sessionStorage.removeItem('pause');

            hours = sessionStorage.getItem('hour');
            minutes = sessionStorage.getItem('minute');
            seconds = sessionStorage.getItem('second');

            if (seconds > 5) {
                minutes++;
            }

            let breakTime = {
                minutes: minutes
            };

            $.ajax({
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: 'timer/pause',
                data: breakTime,
                success: () => {
                    $(".restartConfirm").hide();
                    $(".btn").removeClass("disabled");
                    sessionStorage.clear();
                    hours = 0;
                    minutes = 0;
                    seconds = 0;
                    countTime();
                }
            });
        });
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
        $(".timer-pause").removeClass("disabled");

        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'timer/start',
            success: (data) => {
                isValid(data);
            }
        });
    }

    function isValid(data) {
        if (data) {
            countTime();
        } else {
            alert('Stop the timer first');
        }
    }

    function countTime() {
        timeout = setTimeout(add, 1000);
    }

    function pause() {

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
            $(".timer-restart").removeClass("disabled");

            sessionStorage.clear();
            seconds = 0;
            minutes = 0;
            hours = 0;

            sessionStorage.setItem('pause', 'true');

            countTime();
        });
    }

    function stop() {
        $(".work").hide();
        $(".stopConfirm").show();
        $(".timer").html('');

        sessionStorage.clear();
        clearTimeout(timeout);
        hours = 0;
        minutes = 0;
        seconds = 0;


        $(".stopBtn").click(() => {
            $.ajax({
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: 'timer/stop'
            });
            $(".stopConfirm").hide();
            window.location.reload();
        });
    }


</script>