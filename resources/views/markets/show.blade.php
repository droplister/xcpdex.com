@extends('layouts.app')

@section('title', $market->name)

@section('markets')
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link font-weight-normal py-2" href="{{ route('markets.show', ['market' => 'PEPECASH_XCP']) }}">
            PEPECASH/XCP
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link font-weight-normal py-2" href="{{ route('markets.show', ['market' => 'BITCORN_XCP']) }}">
            BITCORN/XCP
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link font-weight-normal py-2" href="{{ route('markets.show', ['market' => 'CROPS_XCP']) }}">
            CROPS/XCP
        </a>
    </li>
</ul>
@endsection

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
        <h2 class="mt-3 mb-3">Buy Orders</h2>
        <order-book market="{{ $market->slug }}" side="buy"></order-book>
    </div>
    <div class="col-md-6">
        <h2 class="mt-3 mb-3">Sell Orders</h2>
        <order-book market="{{ $market->slug }}" side="sell"></order-book>
    </div>
</div>
<market-depth market="{{ $market->slug }}"></market-depth>
<div class="row">
    <div class="col">
        <h3 class="mt-4 mb-3">All Matches</h3>
        <order-matches market="{{ $market->slug }}"></order-matches>
    </div>
</div>
@endsection
