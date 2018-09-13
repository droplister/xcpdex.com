@extends('layouts.app')

@section('title', 'Counterparty DEX')

@section('content')
    <h1 class="mb-3">
        Counterparty DEX
    </h1>
    <hr />
    <h2>Last 24 Hours</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Orders
                </div>
                <div class="card-body">
                    <h3>{{ $orders_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Order Matches
                </div>
                <div class="card-body">
                    <h3>{{ $trades_count }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
