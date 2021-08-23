@extends('layouts.app')

@section('title', 'Create Order')

@section('content')

    <div class="page-header">
        <h1><small><i class="glyphicon glyphicon-edit"></i></small> Create Order</h1>
    </div>

    @include('order.partials.form')

@endsection