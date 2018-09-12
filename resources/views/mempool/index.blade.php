@extends('layouts.app')

@section('title', 'Mempool')

@section('content')
    <h1 class="mb-3">Mempool</h1>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('blocks.index') }}">
                Blocks
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('mempool.index') }}">
                Mempool
            </a>
        </li>
    </ul>
@endsection
