@extends('layouts.app')

@section('title', 'Filled Orders')

@section('content')
    <h1 class="mb-3">Filled Orders</h1>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.index') }}">
                Orders
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.index', ['status' => 'ending-soon']) }}">
                Ending Soon
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('matches.index') }}">
                Filled Orders
            </a>
        </li>
    </ul>
    <order-matches></order-matches>
@endsection
