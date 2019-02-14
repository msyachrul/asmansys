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

    <div class="modal fade" id="attachmentModal" tabindex="-1" role="dialog" aria-labelledby="attachmentModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attachmentModalTittle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="imageCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicator -->
                        <ol class="carousel-indicators">
                        </ol>
                          <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                        </div>
                        <!-- Left and right controls -->
                        <a class="left carousel-control-prev" href="#imageCarousel" data-slide="prev">
                            <span class="fa fa-chevron-left"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control-next" href="#imageCarousel" data-slide="next">
                            <span class="fa fa-chevron-right"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraScript')
    <script type="text/javascript">
        function showCard(data) {
            let concerned = data.concerned ? data.concerned : 'Unknown';

            return `<div class="col-lg-4 col-12"><div class="card"><div class="card-header"><h4 class="card-title">Certificate No.`+ data.number +`</h4></div><div class="card-body"><table class="table table-sm"><tr><td colspan="3">`+ data.asset +`</td></tr><tr><td>Certificate</td><td>:</td><td>`+ data.certificate +`</td></tr><tr><td>Concerned</td><td>:</td><td>`+ concerned +`</td></tr></table><a href="#" class="btn btn-sm btn-show btn-secondary rounded" data-id="`+ data.id +`" data-title="`+ data.asset +`">Show Detail</a></div></div></div>`;

        }

        (function ($) {
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
                        $('.certificate-list').append(showCard(value));
                    });
                });
            }

            $(document).ready(function() {
                doAjax('{{ route("certificate.coaApi") }}');
            });

            $('.btn-prev, .btn-next').click(function() {
                doAjax($(this).attr('href'));
            });

            $('body').on('click','.btn-show', function () {
                let title = $(this).data('title');

                $('#attachmentModal').modal('show');
                let req = {
                    '_token': '{{ csrf_token() }}',
                    'coa_id': $(this).data('id'),
                };
                $.ajax({
                    url: "{{ route('asset.integrationAttachment') }}",
                    type: "post",
                    data: req,
                    success: function(response) {
                        $('.modal .modal-title').text(title);

                        let carousel = "";
                        let html = "";
                        for (var i = 0; i < response.length; i++) {

                            carousel += "<li data-target='#imageCarousel' data-slide-to='"+i+"'></li>"

                            html += "<div class='carousel-item'>";
                            html += "<img src='"+response[i]+"'/>";
                            html += "</div>";
                        }
                        $('.carousel-indicators').html(carousel);
                        $('.carousel-inner').html(html);
                        $('.carousel-indicators').addClass('active');
                        $('.carousel-item:first').addClass('active');
                    }
                });
            });
        })(jQuery);
    </script>
@endsection