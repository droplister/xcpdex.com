@extends('layouts.app')

@section('title', 'DEX Markets')

@section('content')
<h1 class="mb-3">DEX Markets</h1>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('markets.index', ['quote_asset' => $request->input('quote_asset', 'XCP')]) }}">
            {{ $request->input('quote_asset', 'XCP') }}
        </a>
    </li>
    <li class="nav-item dropdown d-none d-md-inline-block">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            Quote Asset
        </a>
        <div class="dropdown-menu">
        @foreach($markets as $market)
            <a class="dropdown-item{{ $market->xcp_core_quote_asset === $request->input('quote_asset', null) ? ' active' : '' }}" href="{{ route('markets.index', ['quote_asset' => $market->xcp_core_quote_asset]) }}">
                {{ $market->xcp_core_quote_asset }}
            </a>
        @endforeach
        </div>
    </li>
</ul>
<markets quote_asset="{{ $request->input('quote_asset', 'XCP') }}"></markets>
@endsection
