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
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Certificate : {{ request('id') ? $selectedCertificate->name : "ALL"}}</button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item {{ request('id') ? '' : 'active'}}" href="{{ route('certificate.userIndex')}}">ALL</a>
                                            @foreach($certificates as $key => $certificate)
                                            <a class="dropdown-item {{ $certificate->id==request('id') ? 'active' : ''}}" href="{{ route('certificate.userIndex','id='.$certificate->id)}}">{{$certificate->name}}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
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
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach($data as $key => $value)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('asset.userShow',$value->asset_id) }}">{{ $i++ }}</a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('asset.userShow',$value->asset_id) }}">
                                                        <table class="table table-sm">
                                                            <tr>
                                                                <td colspan="3"><b>{{ $value->name }}</b></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="10%">Number</td>
                                                                <td width="1%">:</td>
                                                                <td>{{ $value->number }}</td>
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
          $('#table-certificate').DataTable(
            {
                pageLength: 10,
                bLengthChange: false,
            });
        } );
    </script>
@endsection