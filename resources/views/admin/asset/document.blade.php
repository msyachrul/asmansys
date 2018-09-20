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
                                    <!-- <a class="btn btn-secondary btn-edit" href="#"><i class="fa fa-edit"></i> Edit</a>
                                    &nbsp
                                    <a class="btn btn-secondary" href="#" onclick="removeItem();"><i class="fa fa-trash"></i> Remove</a>
                                    <form id="remove-form" action="#" method="post" style="display: none">
                                        @csrf
                                        @method('DELETE')
                                    </form> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name"><b>Name</b></label>
                                <input type="text" name="name" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" autocomplete="off" autofocus="on" placeholder="Asset Name" value="{{ $value->name }}" disabled>
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
                                            <th>Last Position</th>
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

                                            </td>
                                            <td>
                                                
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-link btn-show" style="color:grey" data-id="{{ $val->id }}">Show</button>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-secondary btn-edit" data-coa_id="{{ $val->id }}" data-certificate_id="{{ $val->certificate_id }}" data-number="{{ $val->number }}"><i class="fa fa-pencil"></i></button>
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
                                <button type="submit" class="btn btn-secondary">Save</button>&nbsp
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
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
                            <label>Attachment</label>
                            <input type="file" class="form-control" name="attachment[]" multiple>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('form-certificate').submit()">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extraScript')

    <script type="text/javascript">
        ( function($) {
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
                        $('.carousel-item:first').addClass('active');
                    }
                });
            });

            $(document).on('click','.btn-remove',function() {
                removeCertificate($(this).val(),"{{ $value->id }}");    
            });

            function removeCertificate(coa_id,asset_id) {
                let x = confirm('Are you sure want to delete this certificate?');

                if (x==true) {
                    let values = {
                        '_token': '{{ csrf_token() }}',
                        'coa_id' : coa_id,
                        'asset_id' : asset_id,
                    };
                    $.ajax({
                        url: "{{ route('asset.integrationDestroy')}}",
                        type: "post",
                        data: values,
                        success: function(response) {
                            alert(response.success);
                            document.location.href = "{{ url('menu/asset/document') }}/"+values.asset_id;
                            },
                    });
                }
            };

            $(document).on('click','.btn-add',function() {
                $('#certificateModal').modal('show');
                $('#certificateModalTittle').text('Add Certificate');
                $('#form-certificate').attr('action','{{ route("asset.integrationStore",$value->id)}}');
                $('#form-certificate input[name=_method]').remove();
                $('#form-certificate input[name=coa_id]').remove();
                $('#form-certificate select').prop('selectedIndex',0);
                $('#form-certificate input[name=number]').val('');
            });

            $(document).on('click','.btn-edit',function() {
                $('#certificateModal').modal('show');
                $('#certificateModalTittle').text('Edit Certificate');
                $('#form-certificate').attr('action','{{ route("asset.integrationUpdate",$value->id)}}');
                $('#form-certificate').append('@method("PUT")');
                $('#form-certificate').append('<input type="hidden" name="asset_id" value="{{ $value->id }}">');
                $('#form-certificate').append('<input type="hidden" name="coa_id" value="'+$(this).data("coa_id")+'">');
                $('#form-certificate select').val($(this).data('certificate_id'));
                $('#form-certificate input[type=text]').val($(this).data('number'));
            });
        })(jQuery);
        
    </script>
@endsection