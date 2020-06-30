@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Company'])
        <li class="breadcrumb-item">
            <a href="/gate/company">Company</a>
        </li>
        <li class="breadcrumb-item active">
            <a>Create Company</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('gate::components.create', ['action' => '/gate/company', 'name' => 'Company'])
        @slot('formCreate')
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')}}">
                    @error('name')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Code</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code')}}">
                    @error('code')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email')}}">
                    @error('email')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Remark</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('remark') is-invalid @enderror" name="remark" value="{{ old('remark')}}">
                    @error('remark')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        @endslot
    @endcomponent
@endsection
