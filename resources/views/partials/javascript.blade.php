{{--<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />--}}


{{--<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>--}}
{{--<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>--}}
{{--<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>--}}

<script>


$(document).ready(function() {
            // page is now ready, initialize the calendar...
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                events : [
                        @foreach($schedule as $task)
                    {
                        title : '{{ isset($task->name) ? $task->name : "Working hours: " . $task->workTime }}',
                        start : '{{ $task->startDate }}',
                        end : '{{ $task->endDate }}',
                        businessHours : true,
                        url : '{{ isset($task->name) ? route('schedule.edit', $task->id) : url('/editUnavailable') }}'
                    },
                    @endforeach
                ]
            })





        });

</script>