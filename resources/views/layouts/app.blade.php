<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

@if(! empty($_GET))
    <meta name="robots" content="noindex,follow">
@endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
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
                    <li class="nav-item d-none d-md-inline-block">
                        <a class="nav-link px-2" href="#" target="_blank">
                            BTC = $49,236.08
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-inline-block">
                        <a class="nav-link px-2" href="#" target="_blank">
                            XCP = $7.11
                        </a>
                    </li>
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
                            {{ __('Markets') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">
                            {{ __('Orders') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('matches.index') }}">
                            {{ __('Trades') }}
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                    <div class="sidebar-sticky">
                        <h6 class="sidebar-heading align-items-center px-3 mt-4 mb-2">
                            <a class="d-flex justify-content-between text-muted text-decoration-none" href="{{ route('home.index') }}">
                                <span>Top Markets</span>
                                <i aria-hidden="true" class="fa fa-bar-chart text-secondary float-right" style="color: #999 !important"></i>
                            </a>
                        </h6>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link{{ Route::currentRouteName() === 'markets.index' && $quote_asset === 'XCP' ? ' active' : '' }}" href="{{ route('markets.index', ['quote_asset' => 'XCP']) }}">
                                    XCP
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Route::currentRouteName() === 'markets.index' && $quote_asset === 'BTC' ? ' active' : '' }}" href="{{ route('markets.index', ['quote_asset' => 'BTC']) }}">
                                    BTC
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Route::currentRouteName() === 'markets.index' && $quote_asset === 'PEPECASH' ? ' active' : '' }}" href="{{ route('markets.index', ['quote_asset' => 'PEPECASH']) }}">
                                    PEPECASH
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Route::currentRouteName() === 'markets.index' && $quote_asset === 'BITCORN' ? ' active' : '' }}" href="{{ route('markets.index', ['quote_asset' => 'BITCORN']) }}">
                                    BITCORN
                                </a>
                            </li>
                        </ul>
                        <h6 class="sidebar-heading align-items-center px-3 mt-4 mb-2">
                            <a class="d-flex justify-content-between text-muted text-decoration-none" href="{{ route('orders.index') }}">
                                <span>Order Book</span>
                                <i aria-hidden="true" class="fa fa-book text-secondary float-right" style="color: #999 !important"></i>
                            </a>
                        </h6>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link{{ Route::currentRouteName() === 'orders.index' ? ' active' : '' }}" href="{{ route('orders.index') }}">
                                    <i class="fa fa-edit mr-1 text-secondary" aria-hidden="true"></i>
                                    {{ __('Orders') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Route::currentRouteName() === 'matches.index' ? ' active' : '' }}" href="{{ route('matches.index') }}">
                                    <i class="fa fa-retweet mr-1 text-secondary" aria-hidden="true"></i>
                                    {{ __('Trades') }}
                                </a>
                            </li>
                        </ul>
                        <h6 class="sidebar-heading align-items-center px-3 mt-4 mb-2">
                            <a class="d-flex justify-content-between text-muted text-decoration-none" href="{{ route('blocks.index') }}">
                                <span>Blockchain</span>
                                <i aria-hidden="true" class="fa fa-chain text-secondary float-right" style="color: #999 !important"></i>
                            </a>
                        </h6>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link{{ Route::currentRouteName() === 'blocks.index' ? ' active' : '' }}" href="{{ route('blocks.index') }}">
                                    <i class="fa fa-cube mr-1 text-secondary" aria-hidden="true"></i>
                                    {{ __('Blocks') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Route::currentRouteName() === 'mempool.index' ? ' active' : '' }}" href="{{ route('mempool.index') }}">
                                    <i class="fa fa-clock-o mr-1 text-secondary" aria-hidden="true"></i>
                                    {{ __('Mempool') }}
                                </a>
                            </li>
                        </ul>
                         <h6 class="sidebar-heading align-items-center px-3 mt-4 mb-2">
                            <a class="d-flex justify-content-between text-muted text-decoration-none" href="{{ route('pages.stats') }}">
                                <span>Usage Data</span>
                                <i aria-hidden="true" class="fa fa-calculator text-secondary float-right" style="color: #999 !important"></i>
                            </a>
                        </h6>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link{{ Route::currentRouteName() === 'pages.stats' ? ' active' : '' }}" href="{{ route('pages.stats') }}">
                                    <i class="fa fa-area-chart mr-1 text-secondary" aria-hidden="true"></i>
                                    {{ __('Statistics') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 p-3">
                    @yield('content')
                    <footer class="text-center text-muted pt-3 pb-2">
                        <a href="{{ url('/') }}" class="mr-2">Home</a>
                        <a href="https://coinmarketcap.com/currencies/counterparty/" class="mr-2" target="_blank">XCP/USD</a>
                        <a href="https://github.com/droplister/xcpdex.com"  class="mr-2" target="_blank">GitHub</a>
                        <a href="https://medium.com/@droplister/counterparty-dex-tutorial-b38dcab102e5" class="mr-2" target="_blank">Tutorial</a>
                        <a href="https://t.me/xcpdex" target="_blank">Telegram</a>
                        <small class="d-block">
                            &copy; 2018
                            <a href="https://familymediallc.com/" class="text-muted mr-1" target="_blank">Family Media</a>
                            <a href="{{ config('xcpdex.analytics_url') }}" class="text-muted mr-1" target="_blank">Analytics</a>
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
<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('xcpdex.google_ua') }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{{ config('xcpdex.google_ua') }}');
</script>
</body>
</html>
