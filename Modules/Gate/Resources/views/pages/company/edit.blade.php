@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Company'])
        <li class="breadcrumb-item">
            <a href="/gate/company">Company</a>
        </li>
        <li class="breadcrumb-item active">
            <a>Edit Company</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('gate::components.edit', ['action' => '/gate/company/', 'row' => $company, 'name' => 'Company'])
        @slot('formEdit')
            <div class="form-group row"><label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$company->name}}">
                    @error('name')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row"><label class="col-sm-2 col-form-label">Code</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{$company->code}}">
                    @error('code')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row"><label class="col-sm-2 col-form-label">Email @if(isset($message)) {{$message}} @endif</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$company->email}}">
                    @error('email')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row"><label class="col-sm-2 col-form-label">Remark</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('remark') is-invalid @enderror" name="remark" value="{{$company->remark}}">
                    @error('remark')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        @endslot
    @endcomponent
@endsection

