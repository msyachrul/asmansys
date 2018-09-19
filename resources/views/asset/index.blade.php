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
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                            	<strong style="font-size:24px">List of Assets</strong>	
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Region : {{ request('region') ? $selectedRegion->name : "ALL"}}</button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item {{ request('region') ? '' : 'active'}}" href="{{ route('asset.userIndex')}}">ALL</a>
                                            @foreach($regions as $key => $region)
                                            <a class="dropdown-item {{ $region->id==request('region') ? 'active' : ''}}" href="{{ route('asset.userIndex','region='.$region->id)}}">{{$region->name}}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                      <table id="table-asset" class="table">
                                        <thead class="thead-light">
                                          <tr>
                                            <th width="1%">No</th>
                                            <th>Assets</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach($data as $key => $value)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('asset.userShow',$value->id) }}">
                                                        <div>
                                                            {{ $i++ }}        
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <table class="table table-sm">
                                                        <tr>
                                                            <td colspan="3">
                                                                <a href="{{ route('asset.userShow',$value->id) }}"><b>{{ $value->name }}</b></a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="10%">
                                                                <a href="{{ route('asset.userShow',$value->id) }}">Category</a>
                                                            </td>
                                                            <td width="1%">
                                                                <a href="{{ route('asset.userShow',$value->id) }}">:</a>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('asset.userShow',$value->id) }}">{{ $value->category }}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="{{ route('asset.userShow',$value->id) }}">Region</a>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('asset.userShow',$value->id) }}">:</a>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('asset.userShow',$value->id) }}">{{ $value->region }}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="{{ route('asset.userShow',$value->id) }}">Status</a>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('asset.userShow',$value->id) }}">:</a>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('asset.userShow',$value->id) }}"><b>{{ $value->status ? "Available" : "Not Available" }}</b></a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            @endforeach
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
          $('#table-asset').DataTable(
            {
                pageLength: 10,
                bLengthChange: false,
            });
        } );
    </script>
@endsection