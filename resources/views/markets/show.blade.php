@extends('layouts.app')

@section('title', $last_match ? $market->baseAsset->display_name . ' @ ' . str_replace('.00000000', '', number_format($last_match->trading_price_normalized, 8)) . ' ' . $market->quoteAsset->display_name : $market->name . ' Exchange')
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
        base_asset="{{ $market->baseAsset->display_name }}"
        quote_asset="{{ $market->quoteAsset->display_name }}">
    </market-chart>
    <div class="row">
            <div class="col-md-12">
              <div class="card flex-row mt-3 mb-2 box-shadow">
                <img class="card-img-right flex-auto" data-src="holder.js/200x250?theme=thumb" alt="Thumbnail [200x250]" style="width: 70px;" src="http://rarepepedirectory.com/wp-content/uploads/2017/08/RAIJINPEPE.png" data-holder-rendered="true"><div class="card-body d-flex flex-column align-items-start">
                  <a href="#">Rare Pepe</a>
                  <h4 class="card-title">PEPEMINING <small class="lead">Series 1</small></h4>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary mr-3"><i aria-hidden="true" class="fa fa-diamond text-highlight" style="color:#00ff21!important"></i> DIGIRARE</button>
                    </div>
                    <small class="text-muted">Mint: Sept 2016</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
