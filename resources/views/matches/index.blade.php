@extends('layouts.app')

@section('title', __('Filled Orders'))
@section('description', 'Counterparty DEX Order Matches.')

@section('content')
    <h1 class="mb-3">
        <small><i class="fa fa-book text-secondary" aria-hidden="true"></i></small>
        {{ __('Filled Orders') }}
    </h1>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.index') }}">
                {{ __('Orders') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.index', ['status' => 'ending-soon']) }}">
                Ending
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('matches.index') }}">
                Filled
            </a>
        </li>
    </ul>
    <order-matches></order-matches>
@endsection
