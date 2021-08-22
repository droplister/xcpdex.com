@extends('layouts.app')

@section('title', 'DEX Markets')
@section('description', 'Explore the Counterparty DEX.')

@section('content')
    @if(! isset($quote_asset))
        <h1>{{ __('Counterparty DEX') }}</h1>
        <p class="lead">{{ __('The Decentralized Exchange on Bitcoin') }}</p>
        <img src="{{ asset('images/how-it-works.png') }}" alt="XCP DEX" class="img-responsive my-2" width="100%" />
    @else
        <h1 class="mb-3">{{ $quote_asset }}</h1>
        <p class="lead">Open orders for {{ $quote_asset }} on the Counterparty Dex.</p>
    @endif
    @include('markets.partials.filter')
    <markets quote_asset="{{ $quote_asset }}"></markets>
@endsection
