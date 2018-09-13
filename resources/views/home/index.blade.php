@extends('layouts.app')

@section('title', 'Counterparty DEX')

@section('content')
    <h1 class="mb-3">
        Counterparty DEX
    </h1>
    <hr />
    <a href="#" role="button" data-toggle="modal" data-target="#howToModal" class="btn btn-sm btn-primary mt-1 float-right">
        Sponsorship
    </a>
    <h2 class="mt-3 mb-3">Featured <span class="d-none d-md-inline-block">Markets</span></h2>
    <div class="row justify-content-center">
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
    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary mt-1 float-right">
        <i aria-hidden="true" class="fa fa-book"></i>
        All Orders
    </a>
    <h2 class="mt-3 mb-3">Orders</h2>
    <div class="row justify-content-center">
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
    <a href="{{ route('matches.index') }}" class="btn btn-sm btn-primary mt-1 float-right">
        <i aria-hidden="true" class="fa fa-book"></i>
        All Trades
    </a>
    <h2 class="mt-3 mb-3">Trades</h2>
    <div class="row justify-content-center">
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
