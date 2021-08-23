@extends('layouts.app')

@section('title', $last_match ? $market->base_asset_display_name . ' @ ' . str_replace('.00000000', '', number_format($last_match->trading_price_normalized, 8)) . ' ' . $market->quote_asset_display_name : $market->name . ' Exchange')
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
    @if($last_match && $last_match->confirmed_at->diffInDays(Carbon\Carbon::now()) > 365)
        <div class="alert alert-warning">
            <i aria-hidden="true" class="fa fa-exclamation-circle mr-1"></i>
            <strong class="d-none d-md-inline-block">No Recent Activity:</strong> The last order was created {{ $last_match->confirmed_at->toDateString() }}.
        </div>
    @endif
    <market-chart market="{{ $market->slug }}"
        base_asset="{{ $market->base_asset_display_name }}"
        quote_asset="{{ $market->quote_asset_display_name }}">
    </market-chart>
    <digirare asset="{{ $market->baseAsset->asset_name }}"></digirare>
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
