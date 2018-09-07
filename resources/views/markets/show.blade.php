@extends('layouts.app')

@section('content')
<div class="container">
    <h1>
        {{ $market->baseAsset->display_name }}
        <small class="lead d-none d-sm-inline">{{ $market->name }}</small>
    </h1>
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
            <h3 class="mt-3 mb-3">All Matches</h3>
            <order-matches market="{{ $market->slug }}"></order-matches>
        </div>
    </div>
</div>
@endsection
