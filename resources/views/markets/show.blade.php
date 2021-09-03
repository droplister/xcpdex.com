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
            <strong class="d-none d-md-inline-block">No Recent Activity:</strong> Last order was created {{ $last_match->confirmed_at->toDateString() }}.
        </div>
    @endif
    <market-chart market="{{ $market->slug }}"
        base_asset="{{ $market->base_asset_display_name }}"
        quote_asset="{{ $market->quote_asset_display_name }}">
    </market-chart>
    @if($card)
        <div class="row">
            <div class="col-md-12">
                <div class="card flex-row mt-3 mb-2 box-shadow">
                    <img class="card-img-right flex-auto" alt="{{ $card['name'] }}" style="width: 100px;" src="{{ $card['img_url'] }}">
                    <div class="card-body d-flex flex-column align-items-start">
                        <a href="{{ $card['collection_url'] }}" target="_blank">{{ $card['collection'] }}</a>
                        <h4 class="card-title">{{ $card['name'] }} <small class="lead">{{ $card['meta'] }}</small></h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="{{ $card['url'] }}" type="button" class="btn btn-sm btn-outline-secondary mr-3" target="_blank">
                                  <i aria-hidden="true" class="fa fa-diamond text-highlight" style="color:#00ff21!important"></i>
                                  DIGIRARE
                                </a>
                            </div>
                            <small class="text-muted">{{ $card['date'] }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
