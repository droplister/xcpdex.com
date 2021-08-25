@extends('layouts.app')

@section('title', __('Filled Orders'))
@section('description', 'Counterparty DEX Order Matches.')

@section('content')
    <div class="alert alert-success">
        <i aria-hidden="true" class="fa fa-thumb-tack mr-1"></i><b>Pinned:</b>
        <a href="{{ route('markets.show', ['market' => $featured->market->slug]) }}" class="font-weight-bold">{{ $featured->market->base_asset_display_name }}</a>
        @if($featured->market->lastMatch())
            <span class="text-muted">@ {{ $featured->market->lastMatch()->trading_price_normalized }} {{ $featured->market->quote_asset_display_name }}</span>
        @endif
        <button class="badge badge-link float-right" data-toggle="modal" data-target="#howToModal">More Info</button>
    </div>
    @include('home.modals.how-to')

    <h1 class="mb-3">
        <small><i class="fa fa-retweet text-secondary" aria-hidden="true"></i></small>
        {{ __('Trades') }}
    </h1>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.index') }}">
                {{ __('Orders') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('matches.index') }}">
                Trades
            </a>
        </li>
    </ul>
    <order-matches></order-matches>
@endsection
