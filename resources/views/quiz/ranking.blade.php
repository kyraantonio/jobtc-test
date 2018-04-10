<table id="ranking-table" class="table table-condensed table-stripe">
    <thead>
        <tr>
            <td>Name</td>
            <td>Score</td>
            <td>Average</td>
        </tr>
    </thead>
    <tbody>
        @if(count($result) > 0)
            @foreach($result as $v)
            <tr>
                <td class="col-sm-3">{{ $v->name }}</td>
                <td class="col-sm-1">{{ $v->score . '/' . $total_score }}</td>
                <td class="col-sm-1">{{ number_format(($v->score/$total_score), 2)*100 }}%</td>
            </tr>
            @endforeach
        @else
        <tr>
            <td colspan="3">No data was found.</td>
        </tr>
        @endif
    </tbody>
</table>

{!!  HTML::style('assets/css/datatables/dataTables.bootstrap.css')  !!}
{!!  HTML::style('assets/css/datatables/dataTables.tableTools.css')  !!}
{!!  HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') !!}
{!!  HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js')  !!}
<script>
    $(function(e){
        $.fn.dataTableExt.sErrMode = 'throw';
        $('#ranking-table').DataTable({
              "pageLength": 5,
              "bLengthChange": false,
              "bFilter": false
        });
    });
</script>