@include('layouts.app')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">

                {{ Form::open(['route' => 'export'], ['class' => 'form-inline']) }}
                <div class="form-inline col-md-12 p-3 text-center">
                <div class="form-group col-md-4 ">
                    {{Form::label('from', '', ['class' => 'pr-3']) }}
                    {{Form::date('startDate', '', ['class' => 'form-control '])}}
                </div>
                <div class="form-group col-md-4">
                    {{Form::label('to', '', ['class' => 'pr-3'] ) }}
                    {{ Form::date('endDate','', ['class' => 'form-control ' ])}}
                </div>

                {{Form::submit('Export User Data', ['class' => 'btn btn-outline-secondary mx-3'])}}
                </div>
                {{ Form::close() }}
            </div>

            <div class="card">

{{--                <a class="btn btn-warning" href="{{ route('export') }}">Export User Data</a>--}}
                <div class="card-header">Previous logs</div>

                <div class="card-body text-center">
                    <table id="table_id" class="display">
                        <thead>
                        <tr>
                            <th>Started At</th>
                            <th>Ended At</th>
                            <th>Date</th>
                            <th>Break Time</th>
                            <th>Work Time</th>
                        </tr>
                        </thead>
                        <tbody class="logsTable">
                            @foreach($data as $row => $key)
                                <tr>
                                    @foreach($key as $sth => $ss)
                                        <td> {{$ss}}</td>
                                    @endforeach
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Started At</th>
                            <th>Ended At</th>
                            <th>Date</th>
                            <th>Break Time</th>
                            <th>Work Time</th>
                        </tr>
                        </tfoot>
                    </table>

                </div>


            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready( function () {
        $('#table_id').DataTable({}
        );
    });

</script>