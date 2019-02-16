@extends('layout.layouts')

@section('title','Users Management')

@section('breadcrumb','Users Management')

@section('breadcrumbList')
    <li><a href="#">Manage Menu</a></li>
    <li><a href="{{ route('user.index') }}">Users Management</a></li>
    <li class="active">Detail</li>
@endsection

@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <span style="font-size:24px">Detail User</span>
                                <div class="btn-group pull-right">
                                    <a class="btn btn-secondary btn-edit rounded" href="#"><i class="fa fa-edit"></i> Edit</a>
                                    &nbsp
                                    <a class="btn btn-secondary rounded" href="#" onclick="removeItem();"><i class="fa fa-trash"></i> Remove</a>
                                    <form id="remove-form" action="{{ route('user.destroy',$user->id) }}" method="post" style="display: none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.update',$user->id)}}" method="post" style="max-width:70%;margin:auto">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name"><b>Name</b></label>
                                    <input type="text" name="name" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" autocomplete="off" placeholder="User Name" value="{{ $user->name }}" required readonly>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email"><b>Email Address</b></label>
                                    <input type="text" name="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" autocomplete="off" placeholder="Email Address" value="{{ $user->email }}" required readonly>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password"><b>Password</b></label>
                                    <input type="password" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" autocomplete="off" placeholder="**********" required readonly>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation"><b>Password Confirmation</b></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" autocomplete="off" placeholder="**********" required readonly>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group btn-process">
                                    <a href="{{ route('user.index') }}" class="btn btn-secondary form-control">Close</a>
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
    <script type="text/javascript">

        function removeItem() {
            let x = confirm('Are you sure want to delete this user?');

            if (x==true) {
                document.getElementById('remove-form').submit();
            }
        }
        
        $(document).on('click','.btn-edit', function () {
            $('.btn-edit').removeClass('btn-edit').addClass('btn-cancel').html('<i class="fa fa-close"></i> Cancel');
            $('input').removeAttr('readonly');
            $('.btn-process').html('<button type="submit" class="btn btn-secondary form-control">Update</button>');
        });
        $(document).on('click','.btn-cancel', function () {
            $('.btn-cancel').removeClass('btn-cancel').addClass('btn-edit').html('<i class="fa fa-edit"></i> Edit')
            $('input').attr('readonly','on');
            $('.btn-process').html('<a href="{{ route('user.index') }}" class="btn btn-secondary form-control">Close</a>');
        });

    </script>
@endsection