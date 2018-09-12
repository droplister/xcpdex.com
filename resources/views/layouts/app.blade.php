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
                <img src="{{ asset('images/logo.png') }}" alt="XCP DEX" class="mt-1 mr-1" /> XCP DEX
            </a>
            <div class="col-6 col-sm-8 col-md-4 col-lg-3 p-0">
                <auto-suggest></auto-suggest>
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
                </ul>
                <ul class="nav nav-pills d-md-none">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('markets.index') }}">
                            Markets
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">
                            Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('matches.index') }}">
                            Matches
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item mt-2">
                                <a class="nav-link" href="{{ route('markets.index') }}">
                                    <i class="fa fa-server float-right mt-1 text-secondary" aria-hidden="true"></i>
                                    DEX Markets
                                </a>
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-normal" href="{{ route('markets.show', ['market' => 'BITCORN_XCP']) }}">
                                            BITCORN/XCP
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-normal" href="{{ route('markets.show', ['market' => 'PEPECASH_XCP']) }}">
                                            PEPECASH/XCP
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-normal" href="{{ route('markets.show', ['market' => 'CROPS_XCP']) }}">
                                            CROPS/XCP
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-ite mt-2">
                                <a class="nav-link" href="{{ route('orders.index') }}">
                                    <i class="fa fa-book float-right mt-1 text-secondary" aria-hidden="true"></i>
                                    Order Books
                                </a>
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-normal" href="{{ route('orders.index', ['status' => 'ending-soon']) }}">
                                            Ending Soon
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-normal" href="{{ route('matches.index') }}">
                                            Filled Orders
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 py-3 px-4">
                    @yield('content')
                    <footer class="container text-center text-muted">
                        <hr />
                        <a href="{{ url('/') }}" class="mr-2">Home</a>
                        <a href="https://coinmarketcap.com/currencies/counterparty/" class="mr-2" target="_blank">XCP/USD</a>
                        <a href="https://github.com/droplister/xcpdex.com"  class="mr-2" target="_blank">GitHub</a>
                        <a href="https://medium.com/@droplister/counterparty-dex-tutorial-b38dcab102e5" class="mr-2" target="_blank">Tutorial</a>
                        <a href="https://t.me/xcpdex" target="_blank">Telegram</a>
                        <small class="d-block">
                            &copy; 2018
                            <a href="https://familymediallc.com/" class="text-muted mr-2" target="_blank">Family Media LLC</a>
                            <a href="{{ route('pages.disclaimer') }}" class="text-muted mr-1">Disclaimer</a>
                            <a href="{{ route('pages.privacy') }}" class="text-muted mr-1">Privacy</a>
                            <a href="{{ route('pages.terms') }}" class="text-muted">Terms</a>
                        </small>
                    </footer>
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
