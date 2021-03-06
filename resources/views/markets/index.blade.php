@extends('layouts.app')

@section('title', 'DEX Markets')
@section('description', 'Explore the Counterparty DEX.')

@section('content')
    <h1 class="mb-3">DEX Markets</h1>
    @include('markets.partials.filter')
    <markets quote_asset="{{ $quote_asset }}"></markets>
@endsection
