@extends('layouts.master')


@section('content')
    @component('components.crud-form.edit', 
            ['action' => '/gate/company/', 
            'row' => $company, 
            'name' => 'Company'
        ])

        @slot('formEdit')
            <div class="form-group row"><label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$company->company_name}}">
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
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-6">
                    <select class="form-control @error('status') is-invalid @enderror" name="status">
                        <option {{ ($company->status==1) ? 'selected' : ''}} value="1">Active</option>
                        <option {{ ($company->status==0) ? 'selected' : ''}} value="0">Inactive</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        @endslot
    @endcomponent
@endsection

