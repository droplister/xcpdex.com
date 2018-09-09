@extends('layouts.app')

@section('content')
<markets quote_asset="{{ $request->input('quote_asset', 'XCP') }}"></markets>
@endsection
