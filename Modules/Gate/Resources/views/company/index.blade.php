@extends('gate::layouts.master')

@section('content')
    <h1>Hello Company</h1>

    <p>
        This view is loaded from module: {!! config('gate.name') !!}
    </p>
@endsection
