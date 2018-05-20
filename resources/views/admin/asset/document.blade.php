@extends('layout.layouts')

@section('title','Assets Management')

@section('extraStyleSheet')
    <link rel="stylesheet" href="{{ asset('assets/css/lib/select2/select2.min.css') }}">
@endsection

@section('breadcrumb','Assets Management')

@section('breadcrumbList')
    <li><a href="#">Manage Menu</a></li>
    <li><a href="{{ route('asset.index') }}">Assets Management</a></li>
    <li class="active">Integration</li>
@endsection

@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <span style="font-size:24px">Integration</span>
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-secondary btn-add"><i class="fa fa-plus"></i></button>
                                    <!-- <a class="btn btn-secondary btn-edit" href="#"><i class="fa fa-edit"></i> Edit</a>
                                    &nbsp
                                    <a class="btn btn-secondary" href="#" onclick="removeItem();"><i class="fa fa-trash"></i> Remove</a>
                                    <form id="remove-form" action="{{ route('asset.destroy',$value->id) }}" method="post" style="display: none">
                                        @csrf
                                        @method('DELETE')
                                    </form> -->
                                </div>
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('asset.integrationStore',$value->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name"><b>Name</b></label>
                                    <input type="text" name="name" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" autocomplete="off" autofocus="on" placeholder="Asset Name" value="{{ $value->name }}" disabled>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="40%">Certificate</th>
                                                <th>Value</th>
                                                <th width="20%">Attachment</th>
                                            </tr>
                                        </thead>
                                        <tbody class="add-certificate">
                                            @foreach($integration as $key => $v)
                                            <tr>
                                                <td>{{ $v->name }}</td>
                                                <td class="text-right">Rp {{ number_format($v->price) }}</td>
                                                <td>
                                                    <a href="{{ asset(Storage::url($v->attachment)) }}"><img src="{{ asset(Storage::url($v->attachment)) }}"></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <label><b>Last Updated By</b></label>
                                    <input type="text" class="form-control" value="{{ $value->user }}" disabled>
                                </div>
                                <div class="form-group btn-group">
                                    <button type="submit" class="btn btn-secondary">Save</button>&nbsp
                                    <a href="{{ route('asset.index') }}" class="btn btn-secondary form-control">Close</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extraScript')
    <script src="{{ asset('assets/js/lib/data-table/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/data-table/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/data-table/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/select2/select2.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.certificateSelect').select2();
        });            

        $(document).on('click','.btn-add',function() {
            let html = '';
            let i = $('tbody.add-certificate tr').length;
                html += '<tr>';
                html += '<td>';
                html += '<select class="form-control certificateSelect" data-placeholder="Ceritificate Name" name="certificate_id['+i+']">';
                html += '<option value=""></option>';
                <?php foreach ($certificates as $key => $value) : ?>
                    html += '<option value="{{$value->id}}">&nbsp{{$value->id." - ".$value->name}}</option>';
                <?php endforeach; ?>
                html += '</select>';
                html += '</td>';
                html += '<td>';
                html += '<input type="number" class="form-control" placeholder="Certificate Value" name="price['+i+']">';
                html += '</td>';
                html += '<td>';
                html += '<input type="file" class="form-control" name="attachment['+i+']">';
                html += '</td>';                
                html += '</tr>';
            
            $('tbody.add-certificate').append(html);
            $('.certificateSelect').select2();
        });



    </script>
@endsection