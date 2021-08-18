@extends('layouts.app')

@section('title', $last_match ? $market->name . ' – ' . number_format($last_match->trading_price_normalized, 8) . ' ' . $market->quoteAsset->display_name : $market->name)
@section('description', $market->name . ' Price Chart, Order Book &amp; Match History.')

@section('content')
    <div class="row">
        <div class="col-md-6">
            @include('markets.partials.title')
        </div>
        <div class="col-md-6">
            @include('markets.partials.table')
        </div>
    </div>
    <market-chart market="{{ $market->slug }}"
        base_asset="{{ $market->baseAsset->display_name }}"
        quote_asset="{{ $market->quoteAsset->display_name }}">
    </market-chart>
    <div class="row">
        <div class="col-md-6">
            <h2 class="mt-3 mb-3">{{ __('Buy Orders') }}</h2>
            <market-orders market="{{ $market->slug }}" side="buy"></market-orders>
        </div>
        <div class="col-md-6">
            <h2 class="mt-3 mb-3">{{ __('Sell Orders') }}</h2>
            <market-orders market="{{ $market->slug }}" side="sell"></market-orders>
        </div>
    </div>
    <market-depth market="{{ $market->slug }}"></market-depth>
    <div class="row">
        <div class="col">
            <h3 class="mt-4 mb-3">{{ __('All Matches') }}</h3>
            <market-order-matches market="{{ $market->slug }}"></market-order-matches>
        </div>
    </div>
@endsection
