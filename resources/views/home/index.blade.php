@extends('layouts.app')

@section('title', __('Counterparty DEX'))
@section('description', 'The Counterparty DEX is a decentralized exchange that allows anyone, anywhere in the world to trade tokenized assets on the Bitcoin blockchain.')

@section('content')
    <h1>{{ __('Counterparty DEX') }}</h1>
    <p class="lead">{{ __('Decentralized Exchange on Bitcoin') }}</p>
    <img src="{{ asset('images/how-it-works.png') }}" alt="XCP DEX" class="img-responsive my-2" width="100%" />
    <div class="row justify-content-center mb-2">
        <div class="col-12">
            <h2 class="mt-3 mb-3">{{ __('How to Trade') }}</h2>
            <p>The Counterparty DEX is a decentralized exchange that allows anyone, anywhere in the world to trade tokenized assets on the Bitcoin blockchain. <br class="d-block d-md-none" /> <br class="d-block d-md-none" /> Our website, XCPDEX.com, is a blockchain explorer dedicated to publishing data about how these assets trade, but XCPDEX.com itself is not an exchange. <br class="d-block d-md-none" /> <br class="d-block d-md-none" /> Confused? Join us on Telegram and ask a question. We've also written a brief tutorial on how to use Counterwallet software to access the DEX.</p>
            <br />
        </div>
        <div class="col-12 col-md-6">
            <a href="https://t.me/xcpdex" target="_blank" class="btn btn-lg btn-block btn-outline-primary mb-4">
                <i class="fa fa-telegram"></i> Join Our Telegram
            </a>
        </div>
        <div class="col-12 col-md-6">
            <a href="https://medium.com/@droplister/counterparty-dex-tutorial-b38dcab102e5" target="_blank" class="btn btn-lg btn-block btn-outline-primary mb-4">
                <i class="fa fa-medium"></i> Read This Tutorial
            </a>
        </div>
    </div>
    <div class="row justify-content-center mb-2">
        <div class="col-12">
            <a href="https://coinmarketcap.com/currencies/counterparty/#markets" class="btn btn-sm btn-outline-primary mt-3 float-right" target="_blank">
                Where to Buy
            </a>
            <h2 class="mt-3 mb-3">XCP Price</h2>
        </div>
        <div class="col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    Price USD
                </div>
                <div class="card-body">
                    <h3>{{ $price_data['price_usd'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    Price BTC
                </div>
                <div class="card-body">
                    <h3>{{ $price_data['price_btc'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    Market Cap
                </div>
                <div class="card-body">
                    <h3>{{ $price_data['market_cap'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    Volume 24h
                </div>
                <div class="card-body">
                    <h3>{{ $price_data['volume'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    CoinCap.io API Data
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
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary mt-3 float-right">
                <i aria-hidden="true" class="fa fa-book"></i>
                {{ __('All Orders') }}
            </a>
            <h2 class="mt-3 mb-3">Order History</h2>
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
        <div class="d-none d-sm-inline-block col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    Last 30 Days
                </div>
                <div class="card-body">
                    <h3>{{ number_format($order_counts['thirty']) }}</h3>
                </div>
            </div>
        </div>
        <div class="d-none d-sm-inline-block col-6 col-md-3">
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
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Counterparty DEX Chart
                </div>
                <chart title="DEX Orders (All-Time)" label="Total" cumulative="true"
                    source="{{ route('api.orders.chart') }}">
                </chart>
            </div>
        </div>
    </div>
@endsection