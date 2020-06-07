@extends('layouts.master')

@section('page-heading')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        @php
            $name = "User";   
        @endphp

        <h2>{{ $name }}</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('dashboard')}}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <a>{{ $name }}</a>
            </li>
        </ol>
    </div>
</div>

@endsection

@section('content')
    <h1>Hello Company</h1>

    <p>
        This view is loaded from module: {!! config('gate.name') !!}
    </p>
@endsection
