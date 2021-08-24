@extends('layouts.app')

@section('title', $request->path() === '/' ? 'Counterparty DEX' : $quote_asset . ' Markets')
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
                <p class="lead">Buy and Sell <span class="d-none d-md-inline-block">{{ $quote_asset }}</span> on the Counterparty DEX.</p>
            </div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered text-center">
                        <tbody>
                            <tr class="bg-light">
                                <td colspan="{{ in_array($quote_asset, ['XCP', 'BTC', 'PEPECASH', 'BITCORN']) ? '3' : '2' }}">
                                    Market Info
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
                                    {{ number_format($data['open_orders']) }}
                                </td>
                                @if(in_array($quote_asset, ['XCP', 'BTC', 'PEPECASH', 'BITCORN']))
                                    <td class="font-weight-bold">
                                        <span class="d-block font-weight-normal">
                                            Volume <small>90d</small>
                                        </span>
                                        ${{ number_format($data['volume_90d'] * $price_data[$quote_asset]) }}
                                    </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @include('markets.partials.filter')
    <markets quote_asset="{{ $quote_asset }}" sort_by="{{ $request->input('sort_by', 'volume') }}"></markets>
@endsection
