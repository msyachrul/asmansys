@extends('layout.layouts')

@section('title','Assets Management')

@section('extraStyleSheet')
    <link rel="stylesheet" href="{{ asset('assets/css/lib/select2/select2.min.css') }}">
@endsection

@section('breadcrumb','Assets Management')

@section('breadcrumbList')
    <li><a href="#">Manage Menu</a></li>
    <li><a href="{{ route('asset.index') }}">Assets Management</a></li>
    <li class="active">Create New</li>
@endsection

@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <span style="font-size:24px">Create New Assets</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('asset.store')}}" method="post" style="max-width:70%;margin:auto" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="name"><b>Name</b></label>
                                    <input type="text" name="name" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" autocomplete="off" autofocus="on" placeholder="Asset Name">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="address"><b>Address</b></label>
                                    <textarea name="address" id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" style="height:200px;resize:none" placeholder="Asset Address"></textarea>
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="description"><b>Description</b></label>
                                    <textarea name="description" id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" style="height:200px;resize:none" placeholder="Asset Description"></textarea>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="category"><b>Category</b></label>
                                    <select name="category_id" data-placeholder="Asset Category" class="form-control categorySelect">
                                        <option value=""></option>
                                        @foreach($category as $key => $value)
                                        <option value="{{ $value->id }}">&nbsp{{ $value->id." - ".$value->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="region"><b>Region</b></label>
                                    <select name="region_id" data-placeholder="Asset Region" class="form-control regionSelect">
                                        <option value=""></option>
                                        @foreach($region as $key => $value)
                                        <option value="{{ $value->id }}">&nbsp{{ $value->id." - ".$value->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('region'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('region') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="picture"><b>Picture</b></label>
                                    <input type="file" name="picture[]" id="picture" class="form-control{{ $errors->has('picture') ? ' is-invalid' : '' }}" multiple>
                                    @if ($errors->has('picture'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('picture') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-secondary form-control">Save</button>
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

    <script>
        $(document).ready(function() {
            $('.categorySelect').select2();
            $('.regionSelect').select2();
        });
    </script>
@endsection