@extends('layout.layouts')

@section('title','Dashboard')

@section('breadcrumb','Dashboard')

@section('breadcrumbList')
	<li class="active">Dashboard</a></li>
@endsection

@section('content')
	<div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <a href="{{ route('asset.userIndex') }}">
                        	<div class="card-body">
	                            <div class="stat-widget-one">
		                            <div class="stat-icon dib"><i class="fa fa-table text-primary border-primary"></i></div>
		                            <div class="stat-content dib">
		                                <div class="stat-text">Assets</div>
		                                <div class="stat-digit">{{ $data->assets }}</div>
		                            </div>
		                        </div>
	                        </div>
	                    </a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                    	<a href="{{ route('certificate.userIndex') }}">
	                        <div class="card-body">
	                            <div class="stat-widget-one">
		                            <div class="stat-icon dib"><i class="fa fa-file text-success border-success"></i></div>
		                            <div class="stat-content dib">
		                                <div class="stat-text">Certificates</div>
		                                <div class="stat-digit">{{ $data->certificates }}</div>
		                            </div>
	                        	</div>
	                        </div>
	                    </a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                    	<a href="{{ route('category.userIndex') }}">
	                        <div class="card-body">
	                            <div class="stat-widget-one">
		                            <div class="stat-icon dib"><i class="fa fa-tasks text-warning border-warning"></i></div>
		                            <div class="stat-content dib">
		                                <div class="stat-text">Categories</div>
		                                <div class="stat-digit">{{ $data->categories }}</div>
		                            </div>
	                       		</div>
	                        </div>
	                    </a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                    	<a href="{{ route('region.userIndex') }}">
	                        <div class="card-body">
	                            <div class="stat-widget-one">
		                            <div class="stat-icon dib"><i class="fa fa-map text-danger border-danger"></i></div>
		                            <div class="stat-content dib">
		                                <div class="stat-text">Regions</div>
		                                <div class="stat-digit">{{ $data->regions }}</div>
		                            </div>
	                        	</div>
	                        </div>
	                    </a>
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="col-md-12">
            		<div class="card">
            			<div class="card-header">
            				<h3>Certificates</h3>
            			</div>
            			<div class="card-body">
            				{!! $certificateChart->container() !!}
            				{!! $certificateChart->script() !!}
            			</div>
            		</div>
            	</div>
            	<div class="col-md-12">
            		<div class="card">
            			<div class="card-header">
            				<h3>Categories</h3>
            			</div>
            			<div class="card-body">
            				{!! $categoryChart->container() !!}
            				{!! $categoryChart->script() !!}
            			</div>
            		</div>
            	</div>            
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Regions</h3>
                        </div>
                        <div class="card-body">
                            {!! $regionChart->container() !!}
                            {!! $regionChart->script() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraScript')
	<script src="{{ asset('/assets/js/chartjs.min.js') }}" charset=utf-8></script>
@endsection