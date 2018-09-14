@extends('layouts.app')

@section('title', __('Mempool'))
@section('description', 'Counterparty TXs in the Bitcoin mempool.')

@section('content')
    <h1 class="mb-3">
        <small><i class="fa fa-chain-broken text-secondary" aria-hidden="true"></i></small>
        {{ ('Mempool') }}
    </h1>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('blocks.index') }}">
                Blocks
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('mempool.index') }}">
                {{ __('Mempool') }}
            </a>
        </li>
    </ul>
    <mempool></mempool>
@endsection
