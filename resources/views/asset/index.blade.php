@extends('layout.layouts')

@section('title','Assets')

@section('breadcrumb','Assets')

@section('breadcrumbList')
	<li><a href="#">Data Reports</a></li>
	<li class="active">Assets</li>
@endsection

@section('content')
    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col text-right">
                    <a href="#form-filter" class="btn btn-outline-secondary rounded" data-toggle="collapse">Filter</a>
                </div>
            </div>
            <form id="form-filter" class="collapse" action="{{route('asset.userIndex')}}" method="get">
                <div class="form-row">
                    <div class="form-group col-lg-4 col-12">
                        <label>Region</label>
                        <select name="region" class="form-control" onchange="document.getElementById('form-filter').submit()">
                            <option value="">-- No Filter --</option>
                            @foreach($regions as $item)
                            <option value="{{$item->id}}" {{$item->id==request('region')?'selected':''}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-4 col-12">
                        <label>Category</label>
                        <select name="category" class="form-control" onchange="document.getElementById('form-filter').submit()">
                            <option value="">-- No Filter --</option>
                            @foreach($categories as $item)
                            <option value="{{$item->id}}" {{$item->id==request('category')?'selected':''}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-4 col-12">
                        <label>&nbsp</label>
                        <a href="{{route('asset.userIndex')}}" class="btn btn-outline-secondary btn-block">Reset</a>
                    </div>
                </div>
            </form>
            <div class="row mt-4">
                @if(count($listAsset) < 1)
                    <div class="col">
                        <h2 class="h2 text-center">Data Not Found</h2>
                    </div>
                @else
                    @foreach($listAsset as $item)
                        <div class="col-lg-4 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$item->asset}}</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <td>Category</td>
                                            <td>:</td>
                                            <td>{{$item->category}}</td>
                                        </tr><tr>
                                            <td>Region</td>
                                            <td>:</td>
                                            <td>{{$item->region}}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>:</td>
                                            <td>{{$item->status?'Availabe':'Not Available'}}</td>
                                        </tr>
                                    </table>
                                    <a target="_blank" href="{{route('asset.userShow',$item->id)}}" class="btn btn-sm btn-show btn-secondary rounded">Show Detail</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="row mt-4">
                <div class="col">
                    <div class="pull-right">
                        {{$listAsset->appends(['region' => request('region'), 'category' => request('category')])->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraScript')
    <script type="text/javascript">

    </script>
@endsection