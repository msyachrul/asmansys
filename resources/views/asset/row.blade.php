<table class="table table-sm asset-show" data-href="{{ $url }}">
    <tr>
        <td colspan="3">
            <b>{{ $model->name }}</b>
        </td>
    </tr>
    <tr>
        <td width="10%">
            Category
        </td>
        <td width="1%">
            :
        </td>
        <td>
            {{ $model->category->name }}
        </td>
    </tr>
    <tr>
        <td>
            Region
        </td>
        <td>
            :
        </td>
        <td>
            {{ $model->region->name }}
        </td>
    </tr>
    <tr>
        <td>
            Status
        </td>
        <td>
            :
        </td>
        <td>
            <b>{{ $model->status ? "Available" : "Not Available" }}</b>
        </td>
    </tr>
</table>