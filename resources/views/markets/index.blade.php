@extends('layouts.app')

@section('title', $request->path() === '/' ? 'Counterparty DEX' : $quote_asset . ' Markets')
@section('description', 'Explore the Counterparty DEX.')

@section('content')
    @if($request->path() === '/')
        <h1>{{ __('Counterparty DEX') }}</h1>
        <p class="lead">{{ __('The Decentralized Exchange on Bitcoin') }}</p>
        <img src="{{ asset('images/how-it-works.png') }}" alt="XCP DEX" class="img-responsive my-2" width="100%" />
        <div class="alert alert-warning">
            <i aria-hidden="true" class="fa fa-exclamation-circle mr-1"></i>
            <strong class="d-none d-md-inline-block">Read-Only:</strong> This site is like Yahoo Finance for XCP.
        </div>
    @else
        <div class="row">
            <div class="col-md-6">
                <h1>
                    @if(in_array($quote_asset, ['XCP', 'BTC', 'PEPECASH', 'BITCORN', 'BITCRYSTALS']))
                        <img src="/images/{{ $quote_asset }}.png" style="height: 2rem; margin-top: -0.4rem;" alt="{{ $quote_asset }}" class="mr-1" />
                    @endif
                    {{ $quote_asset }}
                </h1>
                <p class="lead">Buy and Sell <span class="d-none d-md-inline-block">{{ $quote_asset }}</span> on the Counterparty DEX.</p>
            </div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered text-center">
                        <tbody>
                            <tr class="bg-light">
                                <td colspan="{{ in_array($quote_asset, ['XCP', 'BTC', 'PEPECASH', 'BITCORN']) ? '3' : '2' }}" class="font-weight-bold">
                                    Market Data
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">
                                    <span class="d-block font-weight-normal">
                                        Trading Pairs
                                    </span>
                                    {{ number_format($data['trading_pairs']) }}
                                </td>
                                <td class="font-weight-bold">
                                    <span class="d-block font-weight-normal">
                                        Open Orders
                                    </span>
                                    {{ number_format($data['get_orders']) }} / {{ number_format($data['give_orders']) }}
                                </td>
                                @if(in_array($quote_asset, ['XCP', 'BTC', 'PEPECASH', 'BITCORN']))
                                    <td class="font-weight-bold">
                                        <span class="d-block font-weight-normal">
                                            Volume <small>90d</small>
                                        </span>
                                        <span title="{{ normalizeQuantity($data['volume_90d'], $quote_asset !== 'BITCORN') }} {{ $quote_asset }}">${{ number_format((float) normalizeQuantity($data['volume_90d'], $quote_asset !== 'BITCORN') * (float) $price_data[$quote_asset]['price']) }}</span>
                                    </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if($quote_asset === 'BTC')
        <div class="alert alert-warning">
            <i aria-hidden="true" class="fa fa-exclamation-circle mr-1"></i>
            <strong class="d-none d-md-inline-block">Please note:</strong> Trading BTC takes <a href="https://counterpartytalk.org/t/what-is-btc-pay-and-how-does-it-work/1179" class="text-dark">extra steps</a>.
        </div>
    @endif
    @include('markets.partials.filter')
    <markets quote_asset="{{ $quote_asset }}" sort_by="{{ $request->input('sort_by', 'volume') }}"></markets>
@endsection
