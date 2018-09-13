@extends('layouts.app')

@section('title', 'Counterparty DEX')

@section('content')
    <h1 class="mb-3">
        Counterparty DEX
    </h1>
    <hr />
    <p>The Counterparty DEX is a decentralized exchange that allows anyone, anywhere to trade Counterparty assets on top of the Bitcoin blockchain. XCPDEX.com is a blockchain explorer dedicated to publishing Counterparty DEX data, like trading volume and prices, but it is not itself an exchange. Join us on Telegram!</p>
    <div class="row justify-content-center mb-2">
        <div class="col-12">
            <a href="#" role="button" data-toggle="modal" data-target="#howToModal" class="btn btn-sm btn-primary mt-3 float-right">
                Get Featured
            </a>
            <h2 class="mt-3 mb-3">Featured</h2>
        </div>
        @foreach($features as $featured)
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header font-weight-bold">
                    <a href="{{ route('markets.show', ['market' => $featured->market->slug]) }}">
                        {{ $featured->market->name }}
                    </a>
                </div>
                <div class="card-body">
                    <h4>{{ $featured->market->last_price }} {{ $featured->market->trading_pair_quote_asset }}</h4>
                    <p class="card-text">Last Trade: {{ $featured->market->lastMatch() ? $featured->market->lastMatch()->confirmed_at->diffForHumans() : 'N/A' }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row justify-content-center mb-2">
        <div class="col-12">
            <a href="https://coinmarketcap.com/currencies/counterparty/#markets" class="btn btn-sm btn-primary mt-3 float-right" target="_blank">
                Where to Buy
            </a>
            <h2 class="mt-3 mb-3">XCP Price</h2>
            <div class="card mb-4">
                <div class="card-header">
                    USD Price Data
                </div>
                <chart-price title="Counterparty (XCP) Price"
                    subtitle="Most DEX markets trade against XCP"
                    source="https://coincap.io/history/XCP">
                </chart-price>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-2">
        <div class="col-12">
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary mt-3 float-right">
                <i aria-hidden="true" class="fa fa-book"></i>
                All Orders
            </a>
            <h2 class="mt-3 mb-3">Order History</h2>
            <div class="card mb-4">
                <div class="card-header">
                    Counterparty DEX Chart
                </div>
                <chart title="DEX Orders (All-Time)" label="Total" cumulative="true"
                    source="{{ route('api.orders.chart') }}">
                </chart>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    Last 24 Hours
                </div>
                <div class="card-body">
                    <h3>{{ number_format($order_counts['recent']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    Last 30 Days
                </div>
                <div class="card-body">
                    <h3>{{ number_format($order_counts['thirty']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    Last 365 Days
                </div>
                <div class="card-body">
                    <h3>{{ number_format($order_counts['annual']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    All-Time
                </div>
                <div class="card-body">
                    <h3>{{ number_format($order_counts['all']) }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-2">
        <div class="col-12">
            <a href="{{ route('matches.index') }}" class="btn btn-sm btn-primary mt-3 float-right">
                <i aria-hidden="true" class="fa fa-book"></i>
                All Trades
            </a>
            <h2 class="mt-3 mb-3">Trade History</h2>
            <div class="card mb-4">
                <div class="card-header">
                    Counterparty DEX Chart
                </div>
                <chart title="DEX Trades (All-Time)" label="Total" cumulative="true"
                    source="{{ route('api.orderMatches.chart') }}">
                </chart>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    Last 24 Hours
                </div>
                <div class="card-body">
                    <h3>{{ number_format($trade_counts['recent']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    Last 30 Days
                </div>
                <div class="card-body">
                    <h3>{{ number_format($trade_counts['thirty']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    Last 365 Days
                </div>
                <div class="card-body">
                    <h3>{{ number_format($trade_counts['annual']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    All-Time
                </div>
                <div class="card-body">
                    <h3>{{ number_format($trade_counts['all']) }}</h3>
                </div>
            </div>
        </div>
    </div>
    @include('home.modals.how-to')
@endsection
