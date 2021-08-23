@extends('layouts.app')

@section('title', $request->path() === '/' ? 'Counterparty DEX' : 'Buy and Sell ' . $quote_asset)
@section('description', 'Explore the Counterparty DEX.')

@section('content')
    @if($request->path() === '/')
        <h1>{{ __('Counterparty DEX') }}</h1>
        <p class="lead">{{ __('The Decentralized Exchange on Bitcoin') }}</p>
        <img src="{{ asset('images/how-it-works.png') }}" alt="XCP DEX" class="img-responsive my-2" width="100%" />
    @else
        <div class="row">
            <div class="col-md-6">
                <h1>
                    @if(in_array($quote_asset, ['XCP', 'BTC', 'PEPECASH', 'BITCORN', 'BITCRYSTALS']))
                        <img src="/images/{{ $quote_asset }}.png" style="height: 2rem; margin-top: -0.4rem;" alt="{{ $quote_asset }}" class="mr-1" />
                    @endif
                    {{ $quote_asset }}
                </h1>
                <p class="lead">Buy and Sell {{ $quote_asset }} on the Counterparty Dex.</p>
            </div>
            <div class="col-md-6">
            </div>
        </div>
    @endif
    @include('markets.partials.filter')
    <markets quote_asset="{{ $quote_asset }}" sort_by="{{ $request->input('sort_by', 'volume') }}"></markets>
@endsection
