@extends('layouts.app')

@section('markets')
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link font-weight-normal py-1" href="{{ route('markets.show', ['market' => 'PEPECASH_XCP']) }}">
            PEPECASH/XCP
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link font-weight-normal py-1" href="{{ route('markets.show', ['market' => 'BITCORN_XCP']) }}">
            BITCORN/XCP
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link font-weight-normal py-1" href="{{ route('markets.show', ['market' => 'CROPS_XCP']) }}">
            CROPS/XCP
        </a>
    </li>
</ul>
@endsection

@section('content')

@endsection
