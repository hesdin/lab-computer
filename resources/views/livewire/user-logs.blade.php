<div>
    <table class="table table-hover">
        @if ($logs->count() > 0)
            @foreach ($logs as $log)
                <tr class="d-flex">
                    <td class="col-7">{{ $log->log }}</td>
                    <td class="col-5">{{ Carbon\Carbon::parse($log->waktu)->diffForHumans() }}</td>
                </tr>
            @endforeach
        @else
            <tr class="d-flex">
                <td class="col-12 text-center" colspan="2">
                    <div class="text-muted"><i>No Data</i></div>
                </td>
            </tr>
        @endif
    </table>
</div>
