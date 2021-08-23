@extends('layouts.app')

@section('title', 'DEX Markets')
@section('description', 'Explore the Counterparty DEX.')

@section('content')
    @if($request->path() === '/')
        <h1>{{ __('Counterparty DEX') }}</h1>
        <p class="lead">{{ __('The Decentralized Exchange on Bitcoin') }}</p>
        <img src="{{ asset('images/how-it-works.png') }}" alt="XCP DEX" class="img-responsive my-2" width="100%" />
    @else
        <div class="row">
            <div class="col-md-6">
                <h1><img src="/images/{{ $quote_asset }}.png" style="height: 2rem; margin-top: -0.4rem;" alt="{{ $quote_asset }}" class="mr-1" /> {{ $quote_asset }}</h1>
                <p class="lead">Buy and Sell {{ $quote_asset }} on the Counterparty Dex.</p>
            </div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered text-center">
                        <tbody>
                            <tr>
                                <td class="font-weight-bold d-none d-md-block border-right-0 border-bottom-0">
                                    <span class="d-block font-weight-normal">
                                        Total Orders
                                    </span>
                                    {{ number_format($market->orders_count) }}
                                </td>
                                <td class="font-weight-bold">
                                    <span class="d-block font-weight-normal">
                                        Volume
                                        <small class="d-none d-md-inline-block">
                                            BITCORN
                                        </small>
                                    </span>
                                    39,000
                                </td>
                                <td class="font-weight-bold">
                                    <span class="d-block font-weight-normal">
                                        Last Trade
                                    </span>
                                    2020-06-05
                                </td>
                            </tr>
                            <tr class="bg-light">
                                <td colspan="3" title="{{ isset($price_data[$market->quoteAsset->display_name]) && $last_match ? '$' . number_format($market->baseAsset->supply_normalized * $last_match->trading_price_normalized * $price_data[$market->quoteAsset->display_name]['price']) . ' USD' : '' }}">
                                    @if($last_match)
                                        Market Cap: <strong>{{ number_format($market->baseAsset->supply_normalized * $last_match->trading_price_normalized) }} <small>{{ $market->quoteAsset->display_name }}</small></strong>
                                    @else
                                        Market Cap: <strong>---------- <small>{{ $market->quoteAsset->display_name }}</small></strong>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @include('markets.partials.filter')
    <markets quote_asset="{{ $quote_asset }}"></markets>
@endsection
