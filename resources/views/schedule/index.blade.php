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
                <div class="card-header">

                    <a href="schedule/create" class="btn btn-primary float-right">Add task</a>



                </div>
                <div class="card-body">

                    <div id='calendar'></div>

                </div>
            </div>
        </div>
    </div>
</div>






