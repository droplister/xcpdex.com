@extends('layouts.app')

@section('orders')
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link font-weight-normal py-1" href="#">
            Newest
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link font-weight-normal py-1" href="#">
            Ending Soon
        </a>
    </li>
</ul>
@endsection

@section('content')
<orders></orders>
@endsection