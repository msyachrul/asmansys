<table class="table table-sm">
    <tr>
        <td colspan="3">
            <a href="{{ $url }}"><b>{{ $model->name }}</b></a>
        </td>
    </tr>
    <tr>
        <td width="10%">
            <a href="{{ $url }}">Category</a>
        </td>
        <td width="1%">
            <a href="{{ $url }}">:</a>
        </td>
        <td>
            <a href="{{ $url }}">{{ $model->category->name }}</a>
        </td>
    </tr>
    <tr>
        <td>
            <a href="{{ $url }}">Region</a>
        </td>
        <td>
            <a href="{{ $url }}">:</a>
        </td>
        <td>
            <a href="{{ $url }}">{{ $model->region->name }}</a>
        </td>
    </tr>
    <tr>
        <td>
            <a href="{{ $url }}">Status</a>
        </td>
        <td>
            <a href="{{ $url }}">:</a>
        </td>
        <td>
            <a href="{{ $url }}"><b>{{ $model->status ? "Available" : "Not Available" }}</b></a>
        </td>
    </tr>
</table>