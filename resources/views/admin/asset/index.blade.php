@extends('layout.layouts')

@section('title','Assets Management')

@section('extraStyleSheet')
	<link rel="stylesheet" href="{{ asset('assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">
@endsection

@section('breadcrumb','Assets Management')

@section('breadcrumbList')
	<li><a href="#">Manage Menu</a></li>
	<li class="active">Assets Management</li>
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
                            	<a class="btn btn-secondary pull-right" href="{{ route('asset.create') }}"><i class="fa fa-plus"></i> Create New</a>	
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                              <table id="table-asset" class="table table-striped table-bordered">
                                <thead>
                                  <tr>
                                    <th width="1%">No</th>
                                    <th>Assets Name</th>
                                    <th>Category</th>
                                    <th width="10%">Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                	@foreach($data as $key => $value)
                                	<tr>
                                		<td>{{ $value->id }}</td>
                                		<td>{{ $value->name }}</td>
                                		<td>{{ $value->category }}</td>
                                        <td class="btn-group">
                                            <a class="btn btn-secondary btn-detail" href="{{ route('asset.show',$value->id) }}">Detail</a>&nbsp
                                            <a class="btn btn-secondary" href="{{ route('asset.integrationShow',$value->id)}}">Integration</a>
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