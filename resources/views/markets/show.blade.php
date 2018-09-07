@extends('layouts.app')

@section('title', $market->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7">
            @include('markets.partials.title')
        </div>
        <div class="col-md-5">
            @include('markets.partials.table')
        </div>
    </div>
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
    <div class="row">
        <div class="col">
            <h3 class="mt-3 mb-3">Book Depth</h3>
            <market-depth market="{{ $market->slug }}"></market-depth>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h3 class="mt-3 mb-3">All Matches</h3>
            <order-matches market="{{ $market->slug }}"></order-matches>
        </div>
    </div>
</div>
@endsection
