@extends('layouts.app')


@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">


                        {{ Form::open(['route' => 'schedule.store']) }}

                        <div class="form-group">
                            {{ Form::label('taskName', 'Task name') }}
                            {{ Form::text('name','', ['class' => 'form-control', 'id' => 'taskName']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('taskDescription', 'Task description') }}
                            {{ Form::textArea('description', '', ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('datePicker', 'Start date') }}
                            {{   Form::date('startDate', \Carbon\Carbon::now())}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('datePicker', 'End date') }}
                            {{   Form::date('endDate', \Carbon\Carbon::now())}}
                        </div>
                        {{Form::submit('Add task', ['class' => 'btn btn-primary'])}}
                        <a href="{{route('calendar')}}" class="float-right">Back to calendar</a>
                        {{ Form::close() }}


                    </div>
                </div>
            </div>
        </div>
    </div>






@endsection


