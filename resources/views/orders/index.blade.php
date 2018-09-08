@extends('layouts.app')

@section('content')
<orders status="{{ $request->input('status', 'false') }}"></orders>
@endsection