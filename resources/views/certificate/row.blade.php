<table class="table table-sm">
    <tr>
        <td colspan="3"><b>{{ $model->certificate->name }}</b></td>
    </tr>
    <tr>
        <td width="10%">Number</td>
        <td width="1%">:</td>
        <td>{{ $model->number }}</td>
    </tr>
    <tr>
        <td>Concerned</td>
        <td width="1%">:</td>
        <td>{{ $model->concerned }}</td>
    </tr>
    <tr>
        <td>
            <a target="_blank" href="{{ $url }}" class="btn btn-sm btn-secondary rounded">Show Detail</a>
        </td>
    </tr>
</table>