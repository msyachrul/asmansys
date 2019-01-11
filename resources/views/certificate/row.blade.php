<table class="table table-sm">
    <tr>
        <td colspan="3"><a href="{{ $url }}"><b>{{ $model->certificate->name }}</b></a></td>
    </tr>
    <tr>
        <td width="10%"><a href="{{ $url }}">Number</a></td>
        <td width="1%"><a href="{{ $url }}">:</a></td>
        <td><a href="{{ $url }}">{{ $model->number }}</a></td>
    </tr>
    <tr>
        <td><a href="{{ $url }}">Concerned</a></td>
        <td width="1%"><a href="{{ $url }}">:</a></td>
        <td><a href="{{ $url }}">{{ $model->concerned }}</a></td>
    </tr>
</table>