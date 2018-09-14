@extends('layouts.app')

@section('title', __('Blocks'))
@section('description', 'Bitcoin blocks containing Counterparty DEX activity.')

@section('content')
    <h1 class="mb-3">
        <small><i class="fa fa-chain text-secondary" aria-hidden="true"></i></small>
        {{ __('Blocks') }}
    </h1>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('blocks.index') }}">
                {{ __('Blocks') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('mempool.index') }}">
                {{ __('Mempool') }}
            </a>
        </li>
    </ul>
    <blocks></blocks>
@endsection