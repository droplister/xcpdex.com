@extends('layouts.app')

@section('title', 'DEX Markets')

@section('content')
    <h1 class="mb-3">DEX Markets</h1>
    @include('markets.partials.filter')
    <markets quote_asset="{{ $request->input('quote_asset', 'XCP') }}"></markets>
@endsection
