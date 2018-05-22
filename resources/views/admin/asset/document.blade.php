@extends('layout.layouts')

@section('title','Assets Management')

@section('extraStyleSheet')
    <link rel="stylesheet" href="{{ asset('assets/css/lib/select2/select2.min.css') }}">
@endsection

@section('breadcrumb','Assets Management')

@section('breadcrumbList')
    <li><a href="#">Manage Menu</a></li>
    <li><a href="{{ route('asset.index') }}">Assets Management</a></li>
    <li class="active">Integration</li>
@endsection

@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <span style="font-size:24px">Integration</span>
                                <div class="btn-group pull-right">
                                    <!-- <a class="btn btn-secondary btn-edit" href="#"><i class="fa fa-edit"></i> Edit</a>
                                    &nbsp
                                    <a class="btn btn-secondary" href="#" onclick="removeItem();"><i class="fa fa-trash"></i> Remove</a>
                                    <form id="remove-form" action="{{ route('asset.destroy',$value->id) }}" method="post" style="display: none">
                                        @csrf
                                        @method('DELETE')
                                    </form> -->
                                </div>
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="form-certificate" action="{{ route('asset.integrationStore',$value->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
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
                                            <tr>
                                                <th width="40%">Certificate</th>
                                                <th>Value</th>
                                                <th width="20%">Attachment</th>
                                                <th width="5%"><button type="button" class="btn btn-secondary btn-add"><i class="fa fa-plus"></i></button></th>
                                            </tr>
                                        </thead>
                                        <tbody class="add-certificate">
                                            @foreach($integration as $keys => $val)
                                            <tr>
                                                <td>
                                                    <select  class="form-control certificateSelect" name="certificate_id[{{ $keys }}]" disabled>
                                                        @foreach($certificates as $key => $v)
                                                         @if($v->id == $val->certificate_id)
                                                         <option value="{{ $v->id }}" selected hidden>&nbsp{{$v->id." - ".$v->name}}</option>
                                                         @else
                                                         <option value="{{ $v->id }}" >&nbsp{{$v->id." - ".$v->name}}</option>
                                                         @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="text-right">
                                                    <input type="number" class="form-control text-right" name="price[{{ $keys }}]" value="{{ $val->price }}" disabled>
                                                </td>
                                                <td>
                                                    @if(!empty($val->attachment))
                                                    <a href="{{ asset(Storage::url($val->attachment)) }}"><img src="{{ asset(Storage::url($val->attachment)) }}"></a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-secondary btn-remove" value="{{ $val->id }}"><i class="fa fa-minus"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        @if ($errors->any())
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-center"><strong>{{ $errors->first() }}</strong></td>
                                            </tr>    
                                        </tfoot>
                                        @endif
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
                            </form>
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
    <script src="{{ asset('assets/js/lib/select2/select2.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.certificateSelect').select2();
        });

        $(document).on('click','.btn-remove',function() {
            if ($(this).val()) {
                removeCertificate($(this).val());    
            }
            else {
                let i = $('tbody.add-certificate tr').length;
                document.getElementById('table-certificate').deleteRow(i);
            }
            
        });

        function removeCertificate(id) {
            let x = confirm('Are you sure want to delete this certificate?');

            if (x==true) {
                let values = {
                    '_token': '{{ csrf_token() }}',
                    'id' : id,
                };
                $.ajax({
                    url: "{{ route('asset.integrationDestroy')}}",
                    type: "post",
                    data: values,
                    success: function() {
                        alert('Certificate has been deleted');
                        },
                });
                location.reload(true);
            }
        };

        $(document).on('click','.btn-add',function() {
            let html = '';
            let i = $('tbody.add-certificate tr').length;
                html += '<tr>';
                html += '<td>';
                html += '<select id="'+i+'" class="form-control certificateSelect" data-placeholder="Ceritificate Name" name="certificate_id['+i+']">';
                html += '<option value=""></option>';
                <?php foreach ($certificates as $key => $v) : ?>
                    html += '<option value="{{$v->id}}">&nbsp{{$v->id." - ".$v->name}}</option>';
                <?php endforeach; ?>
                html += '</select>';
                html += '</td>';
                html += '<td>';
                html += '<input type="number" class="form-control" placeholder="Certificate Value" name="price['+i+']">';
                html += '</td>';
                html += '<td>';
                html += '<input type="file" class="form-control" name="attachment['+i+']">';
                html += '</td>'; 
                html += '<td>';
                html += '<button type="button" class="form-control btn-remove"><i class="fa fa-minus"></i></button>';
                html += '</td>';      
                html += '</tr>';

            $('tbody.add-certificate').append(html);
            $('.certificateSelect').select2();
            $('select#'+i).focus();
        });

    </script>
@endsection