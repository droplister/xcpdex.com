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
    <div class="alert alert-warning">
        <i aria-hidden="true" class="fa fa-exclamation-circle mr-1"></i>
        <strong class="d-none d-md-inline-block">Work in Progress:</strong> This is a new feature, so it may have bugs.
    </div>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link{{ ! $request->has('status') ? ' active' : '' }}" href="{{ route('addresses.show', ['address' => $address->address]) }}">
                {{ __('Orders') }}
            </a>
        </li>
    </ul>
    <address-orders address="{{ $address->address }}"></address-orders>
@endsection