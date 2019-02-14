@extends('layout.layouts')

@section('title','Assets')

@section('extraStyleSheet')
	<link rel="stylesheet" href="{{ asset('assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">
    <style type="text/css">
        body {
            padding-right:0 !important;
        }
    </style>
@endsection

@section('breadcrumb','Assets')

@section('breadcrumbList')
	<li><a href="#">Data Reports</a></li>
	<li class="active">Assets</li>
@endsection

@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header d-print-none">
                    <div class="row">
                        <div class="col-sm">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-block dropdown-toggle rounded" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Region : {{ request('region') ? $selectedRegion->name : "ALL"}}</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item {{ request('region') ? '' : 'active'}}" href="{{ route('asset.userIndex','category='.request('category'))}}">ALL</a>
                                    @foreach($regions as $key => $region)
                                    <a class="dropdown-item {{ $region->id==request('region') ? 'active' : ''}}" href="{{ route('asset.userIndex','region='.$region->id.'&category='.request('category')) }}">{{ $region->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-block dropdown-toggle rounded" type="button" id="dropdownCategoryButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Category : {{ request('category') ? $selectedCategory->name : "ALL"}}</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownCategoryButton">
                                    <a class="dropdown-item {{ request('category') ? '' : 'active'}}" href="{{ route('asset.userIndex','region='.request('region'))}}">ALL</a>
                                    @foreach($categories as $key => $category)
                                    <a class="dropdown-item {{ $category->id==request('category') ? 'active' : ''}}" href="{{ route('asset.userIndex','region='.request('region').'&category='.$category->id) }}">{{ $category->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <a href="{{ route('asset.userIndex') }}" class="btn btn-outline-secondary btn-block rounded">Reset</a>
                        </div>
                        <div class="col-sm">
                            <a href="javascript:window.print()" class="btn btn-outline-secondary btn-block rounded">Print</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                      <table id="table-asset" class="table table-striped" width="100%">
                        <thead>
                          <tr>
                            <th colspan="2" class="text-center" style="font-size:24px">List of Assets</th>
                          </tr>
                          <tr>
                            <th width="1%">No</th>
                            <th>Assets</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
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
    <script src="{{ asset('assets/js/lib/data-table/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/data-table/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/data-table/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/data-table/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/lib/data-table/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/data-table/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/data-table/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/data-table/datatables-init.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table-asset').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: "{!! $apiUrl !!}",
                columns: [
                    {data: 'DT_RowIndex', name: 'id'},
                    {data: 'name', name: 'name'},
                ]
            });
            $('#table-asset_wrapper .row:first, #table-asset_wrapper .row:last').addClass('d-print-none');
        });
        // $('body').on('click', '.asset-show', function () {
        //     window.open($(this).data('href'), '_self');
        // });
    </script>
@endsection