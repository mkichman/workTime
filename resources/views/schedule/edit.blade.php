


@include('layouts.app')



<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">



{{--                    {{ Form::model($task,['method' => 'POST', 'action' => 'ScheduleController@update', 'id=' . $task->id] ) }}--}}
                    {{ Form::model($task, ['route' => ['schedule/update/', $task->id]] ) }}

                    {{ method_field('PATCH') }}


                    <div class="form-group">
                        {{ Form::label('taskName', 'Task name') }}
                        {{ Form::text('name',$task->name, ['class' => 'form-control', 'id' => 'taskName']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('taskDescription', 'Task description') }}
                        {{ Form::textArea('description', $task->description, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('datePicker', 'Start date') }}
                        {{   Form::date('startDate',\Carbon\Carbon::now())}}
                    </div>
                    <div class="form-group">
                        {{ Form::label('datePicker', 'End date') }}
                        {{   Form::date('endDate', \Carbon\Carbon::now())}}
                    </div>
                    {{Form::submit('Edit task', ['class' => 'btn btn-primary'])}}
                    <a href="{{route('calendar')}}" class="float-right">Back to calendar</a>
                    <a href="{{route('deleteTask', $task->id)}}" class="float-right">Delete task </a>
                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
</div>

