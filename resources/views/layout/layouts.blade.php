<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <meta name="description" content="{{ config('app.name') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="{{ asset('images/icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/icon.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/scss/style.css') }}">

    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' type='text/css'>

    @yield('extraStyleSheet')

</head>
<body>
    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel d-print-none">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="{{ route('dashboard.index') }}">{{ config('app.name')}}</a>
                <a class="navbar-brand hidden" href="{{ route('dashboard.index') }}">GA</a>
            </div>
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{ route('dashboard.index') }}"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                    </li>
                    <!-- menu title 1 -->
                    <h3 class="menu-title">Data Reports</h3>
                    <li>
                        <a href="{{ route('asset.userIndex') }}"> <i class="menu-icon fa fa-table"></i>Assets</a>
                    </li>
                    <li>
                        <a href="{{ route('certificate.userIndex') }}"> <i class="menu-icon fa fa-file"></i>Certificate</a>
                    </li>
                    <li>
                        <a href="{{ route('category.userIndex') }}"> <i class="menu-icon fa fa-tasks"></i>Categories</a>
                    </li>
                    <li>
                        <a href="{{ route('region.userIndex') }}"> <i class="menu-icon fa fa-map"></i>Regions</a>
                    </li>
                    <!-- menu title 2 -->
                    <h3 class="menu-title">Manage Menu</h3>
                    <li>
                        <a href="{{ route('asset.index') }}"> <i class="menu-icon fa fa-table"></i>Assets Management</a>
                    </li>
                    <li>
                        <a href="{{ route('certificate.index') }}"> <i class="menu-icon fa fa-file"></i>Certificate Management</a>
                    </li>
                    <li>
                        <a href="{{ route('category.index') }}"> <i class="menu-icon fa fa-tasks"></i>Categories Management</a>
                    </li>
                    <li>
                        <a href="{{ route('region.index') }}"> <i class="menu-icon fa fa-map"></i>Regions Management</a>
                    </li>
                    <li>
                        <a href="{{ route('user.index') }}"> <i class="menu-icon fa fa-user"></i> Users Management</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->
    <!-- /Left Panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">        
        <!-- Header-->
        <header id="header" class="header d-print-none">
            <div class="header-menu row">
                <div class="col ml-3">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
                    </div>
                </div>
                <div class="col">
                    <div class="dropdown pull-right">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fa fa-user"></i> My Profile</a>
                            <a class="dropdown-item" href="#" onclick="document.getElementById('logout-form').submit()"><i class="fa fa-power-off"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="post" style="display:none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content-->
        <div class="page-header d-print-none">
            <div class="page-title">
                <div class="row">
                    <div class="col">
                        <h1>@yield('breadcrumb')</h1>
                    </div>
                    <div class="col">
                        <ol class="breadcrumb pull-right">
                            @yield('breadcrumbList')
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <hr class="d-print-none">
        @yield('content')
        <!-- /Content -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->
    <script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @yield('extraScript')


</body>
</html>
