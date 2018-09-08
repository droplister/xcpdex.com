<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') &ndash; {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="@yield('description')">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-6 col-sm-4 col-md-3 col-lg-2 mr-0" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="XCP DEX" class="mt-2 mr-1" /> XCP DEX
            </a>
            <div class="col-6 col-sm-8 col-md-4 col-lg-3 p-0">
            </div>
            <div class="col-md-5 col-lg-7">
                <ul class="nav nav-pills float-right">
                    <li class="nav-item">
                        <a class="nav-link px-2" href="https://t.me/xcpdex" target="_blank">
                            <i class="fa fa-telegram fa-lg text-primary"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="https://twitter.com/xcpdex" target="_blank">
                            <i class="fa fa-twitter fa-lg text-text"></i>
                        </a>
                    </li>
                    @if (Auth::check())
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-3 col-lg-2 pb-5 d-none d-md-block bg-light sidebar">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Counterparty</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="{{ route('markets.index') }}">DEX Markets</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">Open Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('matches.index') }}">Filled Orders</a></li>
                    </ul>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Blockchain</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="#">Blocks</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Mempool</a></li>
                    </ul>
                </nav>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 pb-5 px-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112477384-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-112477384-3');
</script>
</body>
</html>
