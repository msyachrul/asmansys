@extends('layout.layouts')

@section('title','Certificates Management')

@section('breadcrumb','Certificates Management')

@section('breadcrumbList')
    <li><a href="#">Manage Menu</a></li>
    <li><a href="{{ route('certificate.index') }}">Certificates Management</a></li>
    <li class="active">Detail</li>
@endsection

@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <span style="font-size:24px">Certificate Detail</span>
                                <div class="btn-group pull-right">
                                    <a class="btn btn-secondary btn-edit" href="#"><i class="fa fa-edit"></i> Edit</a>
                                    &nbsp
                                    <a class="btn btn-secondary" href="#" onclick="removeItem();"><i class="fa fa-trash"></i> Remove</a>
                                    <form id="remove-form" action="{{ route('certificate.destroy',$value->id) }}" method="post" style="display: none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="update-form" action="{{ route('certificate.update',$value->id) }}" method="post" style="max-width:70%;margin:auto">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name"><b>Name</b></label>
                                    <input type="text" name="name" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" autocomplete="off" value="{{ $value->name }}" readonly="on">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label><b>Last Updated By</b></label>
                                    <input type="text" class="form-control" value="{{ $value->user }}" disabled>
                                </div>
                                <div class="form-group btn-process">
                                    <a href="{{ route('certificate.index') }}" class="btn btn-secondary form-control">Close</a>
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
    <script type="text/javascript">

        function removeItem() {
            let x = confirm('Are you sure want to delete this data?');

            if (x==true) {
                document.getElementById('remove-form').submit();
            }
        }
        
        $(document).on('click','.btn-edit', function () {
            $('.btn-edit').removeClass('btn-edit').addClass('btn-cancel').html('<i class="fa fa-close"></i> Cancel');
            $('input#name').removeAttr('readonly').focus();
            $('.btn-process').html('<button type="submit" class="btn btn-secondary form-control">Update</button>');
        });
        $(document).on('click','.btn-cancel', function () {
            $('.btn-cancel').removeClass('btn-cancel').addClass('btn-edit').html('<i class="fa fa-edit"></i> Edit')
            $('input#name').attr('readonly','on');
            $('.btn-process').html('<a href="{{ route('certificate.index') }}" class="btn btn-secondary form-control">Close</a>');
        });

    </script>
@endsection