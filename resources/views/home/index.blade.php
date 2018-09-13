@extends('layouts.app')

@section('title', 'Counterparty DEX')

@section('content')
    <h1 class="mb-3">
        Counterparty DEX
    </h1>
    <hr />
    <h2 class="mt-3 mb-3">Featured</h2>
    <div class="row justify-content-center">
        @foreach($features as $featured)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header font-weight-bold">
                    <a href="{{ route('markets.show', ['market' => $featured->market->slug]) }}">
                        {{ $featured->market->trading_pair_base_asset }}
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
    <h2 class="mt-3 mb-3">Orders</h2>
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Last 24 Hours
                </div>
                <div class="card-body">
                    <h3>{{ $order_counts['recent'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Last 30 Days
                </div>
                <div class="card-body">
                    <h3>{{ $order_counts['thirty'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Last 365 Days
                </div>
                <div class="card-body">
                    <h3>{{ $order_counts['annual'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    All-Time
                </div>
                <div class="card-body">
                    <h3>{{ $order_counts['all'] }}</h3>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mt-3 mb-3">Trades</h2>
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Last 24 Hours
                </div>
                <div class="card-body">
                    <h3>{{ $trade_counts['recent'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Last 30 Days
                </div>
                <div class="card-body">
                    <h3>{{ $trade_counts['thirty'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Last 365 Days
                </div>
                <div class="card-body">
                    <h3>{{ $trade_counts['annual'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    All-Time
                </div>
                <div class="card-body">
                    <h3>{{ $trade_counts['all'] }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
