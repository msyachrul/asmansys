@extends('layout.layouts')

@section('title','Certificates')

@section('breadcrumb','Certificates')

@section('breadcrumbList')
	<li><a href="#">Data Reports</a></li>
	<li class="active">Certificates</li>
@endsection

@section('content')
    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col text-right">
                    <a href="#form-filter" class="btn btn-outline-secondary rounded" data-toggle="collapse">Filter</a>
                </div>
            </div>
            <form id="form-filter" class="collapse" action="{{route('certificate.userIndex')}}" method="get">
                <div class="form-row">
                    <div class="form-group col-lg-4 col-12">
                        <label>Asset</label>
                        <select name="asset" class="form-control" onchange="document.getElementById('form-filter').submit()">
                            <option value="">-- No Filter --</option>
                            @foreach($assets as $item)
                            <option value="{{$item->id}}" {{$item->id==request('asset')?'selected':''}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-4 col-12">
                        <label>Certificate</label>
                        <select name="certificate" class="form-control" onchange="document.getElementById('form-filter').submit()">
                            <option value="">-- No Filter --</option>
                            @foreach($certificates as $item)
                            <option value="{{$item->id}}" {{$item->id==request('certificate')?'selected':''}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-4 col-12">
                        <label>&nbsp</label>
                        <a href="{{route('certificate.userIndex')}}" class="btn btn-outline-secondary btn-block rounded">Reset</a>
                    </div>
                </div>
            </form>
            <div class="row mt-4">
                @if(count($listCertificate) < 1)
                    <div class="col">
                        <h2 class="h2 text-center">Data Not Found</h2>
                    </div>
                @else
                    @foreach($listCertificate as $item)
                        <div class="col-lg-4 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Certificate No.{{$item->number}}</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <td colspan="3">{{$item->asset}}</td>
                                        </tr>
                                        <tr>
                                            <td>Certificate</td>
                                            <td>:</td>
                                            <td>{{$item->certificate}}</td>
                                        </tr>
                                        <tr>
                                            <td>Concerned</td>
                                            <td>:</td>
                                            <td>{{$item->concerned?$item->concerned:'Unknown'}}</td>
                                        </tr>
                                    </table>
                                    <a href="#" class="btn btn-sm btn-show btn-secondary rounded" data-id="{{$item->id}}" data-title="{{$item->asset}}">Show Detail</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="row mt-4">
                <div class="col">
                    <div class="pull-right">
                        {{$listCertificate->appends(['asset' => request('asset'), 'certificate' => request('certificate')])->links()}}
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
            </div>
        </div>
    </div>
@endsection

@section('extraScript')
    <script type="text/javascript">
        (function ($) {
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