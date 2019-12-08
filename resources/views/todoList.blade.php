@include('layouts.app')


<div class="container">
    <div class="row justify-content-center">
        <div class="card col-md-12">

            <div class="card-body text-center list-group">

                @foreach($data as $row => $key)

                    {{--                            @foreach($key as $elem => $each)--}}
                    {{--                            <a href="{{route('done', ['id' => $key['id']])}}" class="task task{{$key['id']}}"> {{$key['description']}} </a>--}}
                    <a href="#" class="task task{{$key->id}} list-group-item
                                    @if($key->done === 1) done @endif
                            " data-id="{{$key->id}}"> {{$key->description}}
                        <button type="button" class="close" aria-label="Close" data-id="{{$key->id}}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </a><br/>
                    {{--                            @endforeach--}}
                @endforeach



                    {{ Form::open(['route' => 'todoAdd']) }}
                    <div class="input-group">
                    {{Form::text('name', '', ['class' => 'form-control col-md-2', 'placeholder' => 'Short name'])}}

                    {{ Form::text('description','', ['class' => 'form-control col-md-8', 'id' => 'taskName', 'placeholder' => 'Description']) }}
                    {{Form::date('deadline', '' , ['class' => 'form-control col-md-2'])}}
                    </div>
                    <br/>
                    {{Form::submit('Add', ['class' => 'btn btn-outline-secondary btn-block'])}}

                    {{ Form::close() }}



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
                console.log('done');
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