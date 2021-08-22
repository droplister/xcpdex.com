@extends('layouts.app')

@section('title', $address->address)
@section('description', 'Counterparty DEX Trade History')

@section('content')
    <div class="row">
        <div class="col-md-6">
            @include('addresses.partials.title')
        </div>
        <div class="col-md-6">
            @include('addresses.partials.table')
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link{{ ! $request->has('status') ? ' active' : '' }}" href="{{ route('addresses.show', ['address' => $address->address]) }}">
                {{ __('Orders') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('addresses.show', ['address' => $address->address]) }}">
                {{ __('Trades') }}
            </a>
        </li>
    </ul>
    <orders status="{{ $request->input('status', 'false') }}"></orders>
@endsection