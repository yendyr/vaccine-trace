@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Company'])
        <li class="breadcrumb-item">
            <a href="/ppc/taskcard-type">Task Card Type</a>
        </li>
        <li class="breadcrumb-item active">
            <a>Edit Task Card Type</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('components.crud-form.edit', ['action' => '/ppc/taskcard-type/', 'row' => $TaskcardType, 'name' => 'Task Card Type'])
        @slot('formEdit')
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Code</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ $TaskcardType->code }}">
                    @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Task Card Type Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $TaskcardType->name }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Description/Remark</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $TaskcardType->description }}">
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Active</label>
                <div class="col-sm-6">
                    <input type="checkbox" class="js-switch form-control @error('status') is-invalid @enderror" name="status" {{ ($TaskcardType->status == 1) ? 'checked' : '' }} />
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        @endslot
    @endcomponent
@endsection