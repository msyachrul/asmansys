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
                            <div class="table-responsive">
                              <table id="table-asset" class="table table-striped table-bordered">
                                <thead>
                                  <tr>
                                    <th width="1%">No</th>
                                    <th>Assets Name</th>
                                    <th>Region</th>
                                    <th>Status</th>
                                    <!-- <th width="10%">Action</th> -->
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
                                                <div>
                                                    {{ $value->name }}        
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('asset.userShow',$value->id) }}">
                                                <div>
                                                    {{ $value->region }}        
                                                </div>
                                            </a>
                                        </td>
                                		<td>
                                            <a href="{{ route('asset.userShow',$value->id) }}">
                                                <div>
                                                    {{ $value->status == true ? "Available" : "Not Available" }}
                                                </div>
                                            </a>
                                        </td>
                                        <!-- <td class="btn-group">
                                            <a class="btn btn-secondary btn-detail" href="{{ route('asset.userShow',$value->id) }}">Detail</a>
                                		</td> -->
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