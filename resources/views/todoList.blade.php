@include('layouts.app')


<div class="container">
    <div class="row justify-content-center">
        <div class="card col-md-10">

            <div class="card-body text-center list-group">

                @foreach($data as $row => $key)

                    {{--                            @foreach($key as $elem => $each)--}}
                    {{--                            <a href="{{route('done', ['id' => $key['id']])}}" class="task task{{$key['id']}}"> {{$key['description']}} </a>--}}
                    <a href="#" class="task task{{$key['id']}} list-group-item
                                    @if($key['done'] === 1) done @endif
                            " data-id="{{$key['id']}}"> {{$key['description']}}
                        <button type="button" class="close" aria-label="Close" data-id="{{$key['id']}}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </a><br/>
                    {{--                            @endforeach--}}
                @endforeach


                <div class="form-group col-md-12">
                    {{ Form::open(['route' => 'todoAdd']) }}
                    {{ Form::text('description','', ['class' => 'col-md-12 form-control', 'id' => 'taskName']) }}
                    <br/>
                    {{Form::submit('Add', ['class' => 'btn btn-outline-secondary btn-block'])}}
                    {{ Form::close() }}
                </div>


            </div>
        </div>
    </div>

</div>

<script>

    $('.task').click(function () {
        let id = $(this).data('id');
        let elClass = $(this).attr('class');

        checkClass(elClass);

        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'todo/done',
            data: {id: id},
            success:
                () => {
                    // $(this).addClass('done');
                }
        });
    });


    $('.close').click(function () {
        let id = $(this).data('id');

        console.log(id);

        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'todo/delete',
            data: {id: id},
            success:
                () => {
                    location.reload();
                }
        });
    });

    function checkClass(element)
    {
        // console.log(element.indexOf("done"));

        if(element.indexOf("done") < 0)
        {
            $(element).addClass('done');
            location.reload();
        }
        else {
            $(element).removeClass('done');
            location.reload();
        }


    }
</script>