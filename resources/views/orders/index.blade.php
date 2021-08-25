@extends('layouts.app')

@section('title', $request->has('status') ? __('Ending Soon') : __('Orders'))
@section('description', 'Counterparty DEX Orders.')

@section('content')
    <div class="alert alert-success">
        <i aria-hidden="true" class="fa fa-thumb-tack mr-1"></i><b>Pinned:</b>
        <a href="{{ route('markets.show', ['slug' => $featured->market->slug]) }}" class="font-weight-bold">{{ $featured->market->base_asset_display_name }}</a>
        @if($featured->market->lastMatch())
            <span class="text-muted">@ {{ $featured->market->lastMatch()->trading_price_normalized }} {{ $featured->market->quote_asset_display_name }}</span>
        @endif
        <button class="badge badge-link float-right" data-toggle="modal" data-target="#howToModal">More Info</button>
    </div>
    @include('home.modals.how-to')

    <h1 class="mb-3">
        <small><i class="fa fa-edit text-secondary" aria-hidden="true"></i></small>
        {{ __('Orders') }}
        @if($request->has('status'))
            <small class="lead">{{ __('Ending Soon') }}</small>
        @endif
    </h1>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('orders.index') }}">
                {{ __('Orders') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('matches.index') }}">
                {{ __('Trades') }}
            </a>
        </li>
    </ul>
    <orders status="{{ $request->input('status', 'false') }}"></orders>
@endsection