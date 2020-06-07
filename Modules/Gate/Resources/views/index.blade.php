@extends('layouts.master')

@section('content')
    <h1>Welcome</h1>

    <p>
        This view is loaded from module: {!! config('gate.name') !!}
    </p>
@endsection
