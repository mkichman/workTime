@include('layouts.app')

{{--@section('content')--}}

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <a href="{{route('startTimer')}}" class="btn btn-success">Start</a>
                        <a href="#" class="btn btn-warning">Pause</a>
                        <a href="{{route('stopTimer')}}" class="btn btn-danger timer-stop">Stop</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--@endsection--}}


{{--<script>--}}
{{--    $(".timer-stop").on("click", function(){--}}
{{--        // console.log('ssssss');--}}

{{--        return confirm("Are you sure?");--}}
{{--    });--}}
{{--</script>--}}