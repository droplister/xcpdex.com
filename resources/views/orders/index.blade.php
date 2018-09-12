@extends('layouts.app')

@section('title', $request->has('status') ? 'Ending Soon' : 'Orders')

@section('content')
    <h1 class="mb-3">{{ $request->has('status') ? 'Ending Soon' : 'Orders' }}</h1>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link{{ ! $request->has('status') ? ' active' : '' }}" href="{{ route('orders.index') }}">
                Orders
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ $request->has('status') ? ' active' : '' }}" href="{{ route('orders.index', ['status' => 'ending-soon']) }}">
                Ending Soon
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('matches.index') }}">
                Filled Orders
            </a>
        </li>
    </ul>
    <orders status="{{ $request->input('status', 'false') }}"></orders>
@endsection