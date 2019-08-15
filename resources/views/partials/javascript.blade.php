{{--<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />--}}


{{--<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>--}}
{{--<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>--}}
{{--<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>--}}

<script>

console.log("i work");

$(document).ready(function() {
            // page is now ready, initialize the calendar...
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                events : [
                        @foreach($schedule as $task)
                    {
                        title : '{{ $task->name }}',
                        start : '{{ $task->startDate }}',
                        end : '{{ $task->endDate }}',
                        url : '{{ route('schedule.edit', $task->id) }}'
                    },
                    @endforeach
                ]
            })
        });

</script>