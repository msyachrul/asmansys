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
        <div class="acategoryd fadeIn">
            <div class="row justify-content-end d-print-none">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle form-control" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Region : {{ request('region') ? $selectedRegion->name : "ALL"}}</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item {{ request('region') ? '' : 'active'}}" href="{{ route('asset.userIndex','category='.request('category'))}}">ALL</a>
                                    @foreach($regions as $key => $region)
                                    <a class="dropdown-item {{ $region->id==request('region') ? 'active' : ''}}" href="{{ route('asset.userIndex','region='.$region->id.'&category='.request('category')) }}">{{ $region->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle form-control" type="button" id="dropdownCategoryButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Category : {{ request('category') ? $selectedCategory->name : "ALL"}}</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownCategoryButton">
                                    <a class="dropdown-item {{ request('category') ? '' : 'active'}}" href="{{ route('asset.userIndex','region='.request('region'))}}">ALL</a>
                                    @foreach($categories as $key => $category)
                                    <a class="dropdown-item {{ $category->id==request('category') ? 'active' : ''}}" href="{{ route('asset.userIndex','region='.request('region').'&category='.$category->id) }}">{{ $category->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('asset.userIndex') }}" class="btn btn-secondary form-control">Reset</a>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-secondary form-control" onclick="window.print()">Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-print-none">
                            <div class="card-title">
                            	<strong style="font-size:24px">List of Assets</strong>	
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                      <table id="table-asset" class="table">
                                        <thead class="thead-light">
                                          <tr>
                                              <td></td>
                                              <td class="d-none d-print-block text-center"><b style="font-size:24px">List of Assets</b></td>
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
            const filter = "{!! $filter !!}";
            $('#table-asset').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: "{{ route('asset.userApi') }}?" + filter,
                columns: [
                    {data: 'DT_RowIndex', name: 'id'},
                    {data: 'name', name: 'name'},
                ]
            });
            $('#table-asset_wrapper .row:first, #table-asset_wrapper .row:last').addClass('d-print-none');
        });
    </script>
@endsection