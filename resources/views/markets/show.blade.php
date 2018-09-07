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
</div>
@endsection
