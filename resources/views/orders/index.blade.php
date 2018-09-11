@extends('layouts.app')

@section('title', $request->has('status') ? 'Ending Soon' : 'Open Orders')

@section('content')
    <h1 class="mb-3">{{ $request->has('status') ? 'Ending Soon' : 'Open Orders' }}</h1>
    <orders status="{{ $request->input('status', 'false') }}"></orders>
@endsection