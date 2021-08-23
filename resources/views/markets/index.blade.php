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
                                    {{ number_format($markets->sum('orders_count')) }}
                                </td>
                                <td class="font-weight-bold">
                                    <span class="d-block font-weight-normal">
                                        Total Trades
                                    </span>
                                    {{ number_format($markets->sum('order_matches_count')) }}
                                </td>
                                <td class="font-weight-bold">
                                    <span class="d-block font-weight-normal">
                                        Volume <small>90d</small>
                                    </span>
                                    {{ number_format($markets->sum('volume')) }} {{ $quote_asset }}
                                </td>
                            </tr>
                            <tr class="bg-light">
                                <td colspan="3">
 
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
