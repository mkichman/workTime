{{--@include('partials.head')--}}

{{--@include('partials.body')--}}

{{--@include('partials.javascript')--}}

{{--@include('partials.footer')--}}



@include('layouts.app')
@include('partials.javascript')


<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

<div id='calendar'></div>

                </div>
            </div>
        </div>
    </div>
</div>




{{--<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />--}}




{{--<h3>Calendar</h3>--}}

{{--<a href="schedule/create">Add task</a>--}}



{{--<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>--}}
{{--<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>--}}
{{--<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>--}}


{{--<script>--}}
{{--    $(document).ready(function() {--}}
{{--        // page is now ready, initialize the calendar...--}}
{{--        $('#calendar').fullCalendar({--}}
{{--            // put your options and callbacks here--}}
{{--            events : [--}}
{{--                    @foreach($schedule as $task)--}}
{{--                {--}}
{{--                    title : '{{ $task->name }}',--}}
{{--                    start : '{{ $task->task_date }}',--}}
{{--                    url : '{{ route('schedule.edit', $task->id) }}'--}}
{{--                },--}}
{{--                @endforeach--}}
{{--            ]--}}
{{--        })--}}
{{--    });--}}
{{--</script>--}}


