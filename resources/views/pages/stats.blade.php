@extends('layouts.app')

@section('title', 'Statistics')

@section('content')
    <h1 class="mb-3">
        <small><i class="fa fa-area-chart text-secondary" aria-hidden="true"></i></small>
        Statistics
    </h1>
    <div class="row justify-content-center mb-2">
        <div class="col-12">
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary mt-3 float-right">
                <i aria-hidden="true" class="fa fa-book"></i>
                {{ __('New Orders') }}
            </a>
            <h2 class="mt-3 mb-3">Orders Placed</h2>
        </div>
        <div class="col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    Last 24 Hours
                </div>
                <div class="card-body">
                    <h3>{{ number_format($order_counts['recent']) }}</h3>
                </div>
            </div>
        </div>
        <div class="d-none d-sm-inline-block col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    Last 30 Days
                </div>
                <div class="card-body">
                    <h3>{{ number_format($order_counts['thirty']) }}</h3>
                </div>
            </div>
        </div>
        <div class="d-none d-sm-inline-block col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    Last 365 Days
                </div>
                <div class="card-body">
                    <h3>{{ number_format($order_counts['annual']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    All-Time
                </div>
                <div class="card-body">
                    <h3>{{ number_format($order_counts['all']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Counterparty DEX Chart
                </div>
                <chart title="DEX Orders (All-Time)" label="Total" cumulative="true"
                    source="{{ route('api.orders.chart') }}">
                </chart>
            </div>
        </div>
    </div>
@endsection
