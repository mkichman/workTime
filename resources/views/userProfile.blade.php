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