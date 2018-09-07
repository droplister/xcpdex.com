@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <order-book market="{{ $market->slug }}" side="buy"></order-book>
        </div>
        <div class="col-md-6">
            <order-book market="{{ $market->slug }}" side="sell"></order-book>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <order-matches market="{{ $market->slug }}"></order-matches>
        </div>
    </div>
</div>
@endsection
