@extends('layouts.app')

@section('title', 'Counterparty DEX')

@section('content')
    <h1 class="mb-3">
        Counterparty DEX
    </h1>
    <hr />
    <div class="row justify-content-center">
        @foreach($features as $featured)
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    {{ $featured->market->trading_pair_base_asset }}
                </div>
                <div class="card-body">
                    <h3>{{ $featured->market->last_price }} {{ $featured->market->trading_pair_quote_asset }}</h3>
                    <a class="nav-link font-weight-normal" href="{{ route('markets.show', ['market' => $featured->market->slug]) }}">
                        {{ $featured->market->name }}
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Orders
                </div>
                <div class="card-body">
                    <h3>{{ $orders_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Order Matches
                </div>
                <div class="card-body">
                    <h3>{{ $trades_count }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
