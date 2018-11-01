@extends('layout.layouts')

@section('title','Assets Management')

@section('extraStyleSheet')
    <link rel="stylesheet" href="{{ asset('assets/css/lib/select2/select2.min.css') }}">
@endsection

@section('breadcrumb','Assets Management')

@section('breadcrumbList')
    <li><a href="#">Manage Menu</a></li>
    <li><a href="{{ route('asset.index') }}">Assets Management</a></li>
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
                                <span style="font-size:24px">Asset Detail</span>
                                <div class="btn-group pull-right">
                                    <a class="btn btn-secondary btn-edit" href="#"><i class="fa fa-edit"></i> Edit</a>
                                    &nbsp
                                    <a class="btn btn-secondary" href="#" onclick="removeItem();"><i class="fa fa-trash"></i> Remove</a>
                                    <form id="remove-form" action="{{ route('asset.destroy',$data['asset']->id) }}" method="post" style="display: none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="update-form" action="{{ route('asset.update',$data['asset']->id) }}" method="post" style="max-width:70%;margin:auto" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name"><b>Name</b></label>
                                    <input type="text" name="name" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" autocomplete="off" autofocus="on" placeholder="Asset Name" value="{{ $data['asset']->name }}" readonly>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="nop"><b>NOP</b></label>
                                    <input type="text" name="nop" id="nop" class="form-control{{ $errors->has('nop') ? ' is-invalid' : '' }}" autocomplete="off" autofocus="on" placeholder="NOP" value="{{ $data['asset']->nop }}" readonly>
                                    @if ($errors->has('nop'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('nop') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="address"><b>Address</b></label>
                                    <textarea name="address" id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" style="height:200px;resize:none" placeholder="Asset Address" readonly>{{ $data['asset']->address }}</textarea>
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="description"><b>Description</b></label>
                                    <textarea name="description" id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" style="height:200px;resize:none" placeholder="Asset Description" readonly>{{ $data['asset']->description }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="category"><b>Category</b></label>
                                    <select name="category_id" data-placeholder="Asset Category" class="form-control categorySelect" disabled>
                                        <option value=""></option>
                                        @foreach($data['category'] as $key => $v)
                                        <option value="{{ $v->id }}" {{ $v->id == $data['asset']->category_id ? 'selected' : '' }}>&nbsp{{ $v->id." - ".$v->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('category_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="region"><b>Region</b></label>
                                    <select name="region_id" data-placeholder="Asset Region" class="form-control regionSelect" disabled>
                                        <option value=""></option>
                                        @foreach($data['region'] as $key => $v)
                                            <option value="{{ $v->id }}" {{ $v->id == $data['asset']->region_id ? 'selected' : '' }}>&nbsp{{ $v->id." - ".$v->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('region_id'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('region_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="picture"><b>Picture</b></label>
                                    <input type="file" name="picture[]" id="picture" class="form-control{{ $errors->has('picture') ? ' is-invalid' : '' }}" disabled multiple>
                                    <div class="form-control">
                                    @foreach($data['picts'] as $key => $v)
                                        <a target="_blank" href="{{ asset(Storage::url($v->path)) }}"><img src="{{ asset(Storage::url($v->path)) }}" width="200px"></a>
                                    @endforeach
                                    </div>
                                    @if ($errors->has('picture'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('picture') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label><b>Status</b></label>
                                    <select name="status" class="form-control statusSelect" disabled>
                                        <option></option>
                                        @if ($data['asset']->status == true)
                                            <option value="1" hidden selected>&nbspAvailable</option>
                                            <option value="0">&nbspNot Available</option>
                                        @else
                                            <option value="1">&nbspAvailable</option>
                                            <option value="0" hidden selected>&nbspNot Available</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><b>Note</b></label>
                                    <input type="text" class="form-control" name="note" value="{{ $data['asset']->note }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label><b>Last Updated By</b></label>
                                    <input type="text" class="form-control" value="{{ $data['asset']->user }}" disabled>
                                </div>
                                <div class="form-group btn-process">
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

        function removeItem() {
            let x = confirm('Are you sure want to delete this data?');

            if (x==true) {
                document.getElementById('remove-form').submit();
            }
        }
        
        $(document).on('click','.btn-edit', function () {
            $('.btn-edit').removeClass('btn-edit').addClass('btn-cancel').html('<i class="fa fa-close"></i> Cancel');
            $('input').removeAttr('readonly');
            $('input#name').focus();
            $('textarea').removeAttr('readonly');
            $('select').removeAttr('disabled');
            $('input[type=file]').removeAttr('disabled');
            $('.btn-process').html('<button type="submit" class="btn btn-secondary form-control">Update</button>');
        });
        $(document).on('click','.btn-cancel', function () {
            $('.btn-cancel').removeClass('btn-cancel').addClass('btn-edit').html('<i class="fa fa-edit"></i> Edit')
            $('input').attr('readonly','on');
            $('textarea').attr('readonly','on');
            $('select').attr('disabled','true');
            $('input[type=file]').attr('disabled','true');
            $('.btn-process').html('<a href="{{ route('asset.index') }}" class="btn btn-secondary form-control">Close</a>');
        });

        $(document).ready(function() {
            $('.categorySelect').select2();
            $('.regionSelect').select2();
            $('.statusSelect').select2({
                placeholder: "Please select the status",
            });
        });

    </script>
@endsection