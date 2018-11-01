@extends('layout.layouts')

@section('title','Assets Management')

@section('breadcrumb','Assets Management')

@section('breadcrumbList')
    <li><a href="#">Manage Menu</a></li>
    <li><a href="{{ route('asset.index') }}">Assets Management</a></li>
    <li class="active">Certificate</li>
@endsection

@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" style="font-size:24px">
                                <span>Certificate</span>
                                <div class="btn-group pull-right">
                                    {{ $value->name }}
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <table id="table-certificate" class="table table-bordered">
                                    <thead>
                                        @if ($errors->any())
                                        <tr>
                                            <td colspan="4" class="text-center"><strong>{{ $errors->first() }}</strong></td>
                                        </tr>  
                                        @endif
                                        <tr>
                                            <th>Certificate</th>
                                            <th>Number</th>
                                            <th>Concerned</th>
                                            <th width="5%">Attachment</th>
                                            <th width="5%" class="text-center"><button type="button" class="btn btn-secondary btn-add"><i class="fa fa-plus"></i></button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($integration as $keys => $val)
                                        <tr>
                                            <td>
                                                {{ $val->certificate_id." - ". $val->name }}
                                            </td>
                                            <td class="text-right">
                                                {{ $val->number }}
                                            </td>
                                            <td>
                                                {{ $val->concerned }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-link btn-attachment" style="color:grey" data-id="{{ $val->id }}">Show</button>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-secondary btn-show" data-coa_id="{{ $val->id }}" data-certificate_id="{{ $val->certificate_id }}" data-number="{{ $val->number }}" data-last_owner="{{ $val->last_owner }}" data-current_owner="{{ $val->current_owner }}" data-concerned="{{ $val->concerned }}"><i class="fa fa-eye"></i></button>
                                                    &nbsp
                                                    <button type="button" class="btn btn-secondary btn-remove" value="{{ $val->id }}"><i class="fa fa-minus"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <label><b>Last Updated By</b></label>
                                <input type="text" class="form-control" value="{{ $value->user }}" disabled>
                            </div>
                            <div class="form-group btn-group">
                                <a href="{{ route('asset.index') }}" class="btn btn-secondary form-control">Close</a>
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
    <div class="modal fade" id="certificateModal" tabindex="-1" role="dialog" aria-labelledby="certificateModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="certificateModalTittle"></h5>
                    <div class="pull-right">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    </div>
                </div>
                <div class="modal-body">
                    <form id="form-certificate" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control" name="certificate_id" required>
                                <option hidden>Please select a Certificate</option>
                            @foreach($certificates as $key => $v)
                                <option value="{{$v->id}}">&nbsp{{$v->id." - ".$v->name}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Number</label>
                            <input type="text" class="form-control" name="number" placeholder="Certificate number" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Concerned</label>
                            <input type="text" class="form-control" name="concerned" placeholder="Person or Place" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Last Owner</label>
                            <input type="text" class="form-control" name="last_owner" placeholder="Name of last owner" required>
                        </div>
                        <div class="form-group">
                            <label>Current Owner</label>
                            <input type="text" class="form-control" name="current_owner" placeholder="Name of current owner" required>
                        </div>
                        <div class="form-group">
                            <label>Attachment</label>
                            <input type="file" class="form-control" name="attachment[]" multiple>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-save" onclick="document.getElementById('form-certificate').submit()">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extraScript')

    <script type="text/javascript">
        ( function($) {
            $(document).on('click','.btn-attachment',function () {
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
                        $('.carousel-item:first').addClass('active');
                    }
                });
            });

            $(document).on('click','.btn-remove',function() {
                removeCertificate($(this).val());    
            });

            function removeCertificate(coa_id) {
                let x = confirm('Are you sure want to delete this certificate?');

                if (x==true) {
                    let values = {
                        '_token': '{{ csrf_token() }}',
                        'coa_id' : coa_id,
                        'asset_id' : {{ $value->id }},
                    };
                    $.ajax({
                        url: "{{ route('asset.integrationDestroy') }}",
                        type: "post",
                        data: values,
                        success: function(response) {
                            alert(response.success);
                            document.location.href = "{{ route('asset.integrationShow',$value->id) }}";
                            },
                    });
                }
            };

            $(document).on('click','.btn-add',function() {
                $('#certificateModal').modal('show');
                $('#certificateModalTittle').text('Add Certificate');
                $('#form-certificate').attr('action','{{ route("asset.integrationStore",$value->id)}}');
                $('.btn-edit, #form-certificate input[name=_method], #form-certificate input[name=coa_id], #form-certificate input[name=asset_id]').remove();
                $('#form-certificate select').prop('selectedIndex',0);
                $('#form-certificate input:not(input[name=_token])').val('');
                $('#form-certificate input, #form-certificate select').removeAttr('disabled');
                $('.btn-save').removeAttr('disabled');
            });

            $(document).on('click','.btn-show',function() {
                $('#certificateModal').modal('show');
                $('.btn-edit, #form-certificate input[name=_method], #form-certificate input[name=coa_id], #form-certificate input[name=asset_id]').remove();
                $('#certificateModal .modal-header .pull-right').append('<button type="button" class="btn btn-secondary btn-sm btn-edit">Edit</button>');
                $('#certificateModalTittle').text('Show Certificate');
                $('#form-certificate').attr('action','{{ route("asset.integrationUpdate",$value->id)}}');
                $('#form-certificate').append('@method("PUT")');
                $('#form-certificate').append('<input type="hidden" name="asset_id" value="{{ $value->id }}">');
                $('#form-certificate').append('<input type="hidden" name="coa_id" value="'+$(this).data("coa_id")+'">');
                $('#form-certificate select').val($(this).data('certificate_id'));
                $('#form-certificate input[name=number]').val($(this).data('number'));
                $('#form-certificate input[name=last_owner]').val($(this).data('last_owner'));
                $('#form-certificate input[name=current_owner]').val($(this).data('current_owner'));
                $('#form-certificate input[name=concerned]').val($(this).data('concerned'));
                $('#form-certificate input, #form-certificate select, .btn-save').attr('disabled','yes');
            });

            $(document).on('click','.btn-edit',function() {
                $('#certificateModalTittle').text('Edit Certificate');
                $('.btn-edit').remove();
                $('.btn-save, #form-certificate input, #form-certificate select').removeAttr('disabled');
            });
        })(jQuery);
        
    </script>
@endsection