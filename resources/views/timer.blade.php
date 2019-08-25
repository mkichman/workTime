@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <a href="timer/start" class="btn btn-success">Start</a>
                        <a href="#" class="btn btn-warning">Pause</a>
                        <a href="#" class="btn btn-danger">Stop</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
