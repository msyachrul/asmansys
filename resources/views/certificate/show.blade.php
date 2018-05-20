@extends('layout.layouts')

@section('title','Certificates')

@section('breadcrumb','Certificates')

@section('breadcrumbList')
    <li><a href="#">Data Reports</a></li>
    <li><a href="{{ route('certificate.userIndex') }}">Certificates</a></li>
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
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="update-form" style="max-width:70%;margin:auto">
                                <div class="form-group">
                                    <label for="name"><b>Name</b></label>
                                    <input type="text" class="form-control" value="{{ $value->name }}" readonly="on">
                                </div>
                                <div class="form-group">
                                    <label><b>Last Updated By</b></label>
                                    <input type="text" class="form-control" value="{{ $value->user }}" disabled>
                                </div>
                                <div class="form-group btn-process">
                                    <a href="{{ route('certificate.userIndex') }}" class="btn btn-secondary form-control">Close</a>
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
@endsection