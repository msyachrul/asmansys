@extends('layout.layouts')

@section('title','Assets')

@section('extraStyleSheet')
    <link rel="stylesheet" href="{{ asset('assets/css/lib/select2/select2.min.css') }}">
@endsection

@section('breadcrumb','Assets')

@section('breadcrumbList')
    <li><a href="#">Data Reports</a></li>
    <li><a href="{{ route('asset.userIndex') }}">Assets</a></li>
    <li class="active">Detail</li>
@endsection

@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <span class="d-print-none" style="font-size:24px">Asset Detail - </span><span style="font-size:24px">{{ $data['asset']->name }}</span>
                                <div class="pull-right d-print-none">
                                    <button type="button" class="btn btn-secondary" onclick="window.print()">Print</button>
                                </div>            
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <td width="10%">Name</td>
                                    <td width="1%">:</td>
                                    <td>{{ $data['asset']->name }}</td>
                                </tr>
                                <tr>
                                    <td>NOP</td>
                                    <td>:</td>
                                    <td>{{ $data['asset']->nop }}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td>{{ $data['asset']->address }}</td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>:</td>
                                    <td>{{ $data['asset']->description }}</td>
                                </tr>
                                <tr>
                                    <td>Category</td>
                                    <td>:</td>
                                    <td>{{ $data['category']->name }}</td>
                                </tr>
                                <tr>
                                    <td>Region</td>
                                    <td>:</td>
                                    <td>{{ $data['region']->name }}</td>
                                </tr>
                                <tr>
                                    <td>Pictures</td>
                                    <td>:</td>
                                    <td>
                                        @foreach($data['picts'] as $key => $v)
                                            <a href="#" data-toggle="modal" data-target="#pictureModal"><img src="{{ asset(Storage::url($v->path)) }}" width="200px"></a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td>{{ $data['asset']->status ? "Available" : "Not Available"}}</td>
                                </tr>
                                <tr>
                                    <td>Certificates</td>
                                    <td>:</td>
                                    <td>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach($data['integration'] as $key => $v)   
                                        <button type="button" class="form-control text-left btn btn-link btn-show" style="color:grey" data-id="{{ $v->id }}">
                                            {{ $no++ }}. {{ $v->shortname }} - {{ $v->number }}
                                        </button>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>Note</td>
                                    <td>:</td>
                                    <td>{{ $data['asset']->note }}</td>
                                </tr>
                            </table>
                                <div class="form-group btn-process d-print-none">
                                    <a href="{{ route('asset.userIndex') }}" class="btn btn-secondary form-control">Close</a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extraScript')
    <script src="{{ asset('assets/js/lib/select2/select2.min.js') }}"></script>

    <script type="text/javascript">
        ( function ($) {
            $(document).ready(function() {
                $('.categorySelect').select2();
                $('.regionSelect').select2();
            });

            $(document).on('click','.btn-show',function () {
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