@include('layouts.app')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Previous logs</div>

                <div class="card-body text-center">
                    <table id="table_id" class="display">
                        <thead>
                        <tr>
                            <th>Start time</th>
                            <th>End time</th>
                            <th>Start date</th>
                            <th>End date</th>
                        </tr>
                        </thead>
                        <tbody class="logsTable">
                        <tr></tr>
                            @foreach($data as $row => $key)
                                <tr>
                                    @foreach($key as $sth => $ss)
{{--                                        {{ $ss }}--}}
                                        <td> {{$ss}}</td>
                                    @endforeach
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>


            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready( function () {
        $('#table_id').DataTable();
    } );
</script>