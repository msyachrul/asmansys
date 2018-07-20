@extends('layout.layouts')

@section('title','Assets')

@section('extraStyleSheet')
	<link rel="stylesheet" href="{{ asset('assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">
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
                                                    <a href="{{ route('asset.userShow',$value->id) }}">
                                                        <table class="table table-sm">
                                                            <tr>
                                                                <td colspan="3"><b>{{ $value->name }}</b></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="10%">Address</td>
                                                                <td width="1%">:</td>
                                                                <td>{{ $value->address }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Category</td>
                                                                <td>:</td>
                                                                <td>{{ $value->category }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Region</td>
                                                                <td>:</td>
                                                                <td>{{ $value->region }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Status</td>
                                                                <td>:</td>
                                                                <td><b>{{ $value->status == true ? "Available" : "Not Available" }}</b></td>
                                                            </tr>
                                                        </table>
                                                    </a>
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