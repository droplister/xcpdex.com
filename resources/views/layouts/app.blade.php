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
        <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="XCP DEX" class="mt-2 mr-1" /> XCP DEX
            </a>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-3 col-lg-2 pb-5 d-none d-md-block bg-light sidebar">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Counterparty</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="#">Assets</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Markets</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Matches</a></li>
                    </ul>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Blockchain</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="#">Blocks</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Mempool</a></li>
                    </ul>
                </nav>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                    @yield('content')
                    <hr class="mt-4 mb-4" />
                    <p class="text-center">
                        <i class="fa fa-envelope text-secondary"></i>
                        <a href="mailto:info@xcpdex.com" target="_blank">Contact</a>
                        <i class="fa fa-github ml-3 text-secondary d-none d-sm-inline"></i>
                        <a href="https://github.com/droplister/xcpdex.com" class="d-none d-sm-inline" target="_blank">Github</a>
                        <i class="fa fa-telegram ml-3 text-secondary"></i>
                        <a href="https://t.me/xcpdex" target="_blank">Telegram</a>
                        <i class="fa fa-twitter ml-3 text-secondary"></i>
                        <a href="https://twitter.com/xcpdex" target="_blank">Twitter</a>
                    </p>
                    <p class="text-center">
                        <a href="https://xcpdex.com/disclaimer">Disclaimer</a>
                        <a href="https://xcpdex.com/privacy" class="ml-3">Privacy Policy</a>
                        <a href="https://xcpdex.com/terms" class="ml-3">Terms of Use</a>
                    </p>
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
