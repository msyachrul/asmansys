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
                <div class="col-lg-4 col-8">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-block" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Certificate : {{ request('certificate_id') ? $selectedCertificate->name : "ALL"}}</button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item {{ request('certificate_id') ? '' : 'active'}}" href="{{ route('certificate.userIndex')}}">ALL</a>
                            @foreach($certificates as $key => $certificate)
                            <a class="dropdown-item {{ $certificate->id==request('certificate_id') ? 'active' : ''}}" href="{{ route('certificate.userIndex','certificate_id='.$certificate->id)}}">{{$certificate->name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-4 text-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-secondary btn-prev" href="">Prev</button>
                        <button type="button" class="btn btn-outline-secondary btn-next" href="">Next</button>
                    </div>
                </div>
            </div>
            <div class="certificate-list row mt-4"></div>
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
        function showModal(data) {
            let concerned = data.concerned ? data.concerned : 'Unknown';

            return `<div class="col-lg-4 col-12"><div class="card"><div class="card-header"><h4 class="card-title">Certificate No.`+ data.number +`</h4></div><div class="card-body"><table class="table table-sm"><tr><td colspan="3">`+ data.asset +`</td></tr><tr><td>Certificate</td><td>:</td><td>`+ data.certificate +`</td></tr><tr><td>Concerned</td><td>:</td><td>`+ concerned +`</td></tr></table><a target="_blank" href="{{ url('/asset') }}/`+ data.id +`" class="btn btn-sm btn-secondary rounded">Show Detail</a></div></div></div>`;

        }

        function doAjax(href) {
            $('.certificate-list').empty();

            $.get(href, function (response) {
                let btnPrev = $('.btn-prev');
                let btnNext = $('.btn-next');

                btnPrev.removeAttr('disabled');
                btnNext.removeAttr('disabled');

                if (response.prev_page_url === null) {
                    btnPrev.attr('disabled', 'disabled');
                }

                if (response.next_page_url === null) {
                    btnNext.attr('disabled', 'disabled');
                }

                btnPrev.attr('href', response.prev_page_url);
                btnNext.attr('href', response.next_page_url);

                $.each(response.data, function(index, value) {
                    $('.certificate-list').append(showModal(value));
                });
            });
        }

        $(document).ready(function() {
            doAjax('{{ route("certificate.coaApi") }}');
        });

        $('.btn-prev, .btn-next').click(function() {
            doAjax($(this).attr('href'));
        });
    </script>
@endsection