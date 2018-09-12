@extends('layouts.app')

@section('title', 'Blockchain')

@section('content')
    <h1 class="mb-3">
        <small><i class="fa fa-chain text-secondary" aria-hidden="true"></i></small>
        Blockchain
    </h1>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('blocks.index') }}">
                New Blocks
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('mempool.index') }}">
                Mempool
            </a>
        </li>
    </ul>
    <blocks></blocks>
@endsection