@extends('layout.layouts')

@section('title','Certificates')

@section('extraStyleSheet')
	<link rel="stylesheet" href="{{ asset('assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">
@endsection

@section('breadcrumb','Certificates')

@section('breadcrumbList')
	<li><a href="#">Data Reports</a></li>
	<li class="active">Certificates</li>
@endsection

@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row justify-content-end">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle form-control" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Certificate : {{ request('certificate_id') ? $selectedCertificate->name : "ALL"}}</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item {{ request('certificate_id') ? '' : 'active'}}" href="{{ route('certificate.userIndex')}}">ALL</a>
                                    @foreach($certificates as $key => $certificate)
                                    <a class="dropdown-item {{ $certificate->id==request('certificate_id') ? 'active' : ''}}" href="{{ route('certificate.userIndex','certificate_id='.$certificate->id)}}">{{$certificate->name}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                            	<strong style="font-size:24px">List of Certificates</strong>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                  <div class="table-responsive">
                                      <table id="table-certificate" class="table">
                                        <thead>
                                          <tr>
                                            <th width="1%">No</th>
                                            <th>Certificate</th>
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
          $('#table-certificate').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                bLengthChange: false,
                ajax: "{!! $apiUrl !!}",
                columns: [
                    {data: 'DT_RowIndex', name: 'certificate_id'},
                    {data: 'name', name: 'name', orderable: false},
                ],
            });
        } );
    </script>
@endsection