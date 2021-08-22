@extends('layouts.app')

@section('title', $request->has('status') ? __('Ending Soon') : __('Orders'))
@section('description', 'Counterparty DEX Orders.')

@section('content')
    <h1 class="mb-3">
        <small><i class="fa fa-edit text-secondary" aria-hidden="true"></i></small>
        {{ __('Orders') }}
        @if($request->has('status'))
            <small class="lead">{{ __('Ending Soon') }}</small>
        @endif
    </h1>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link{{ ! $request->has('status') ? ' active' : '' }}" href="{{ route('orders.index') }}">
                {{ __('Orders') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('matches.index') }}">
                {{ __('Trades') }}
            </a>
        </li>
    </ul>
    <orders status="{{ $request->input('status', 'false') }}"></orders>
@endsection