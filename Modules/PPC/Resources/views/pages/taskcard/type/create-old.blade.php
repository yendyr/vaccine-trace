@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Task Card Type'])
        <li class="breadcrumb-item">
            <a href="/ppc/taskcard/type">Task Card Type</a>
        </li>
        <li class="breadcrumb-item active">
            <a>Create Task Card Type</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('components.crud-form.create', ['action' => '/ppc/taskcard/type', 'name' => 'Task Card Type'])
        @slot('formCreate')
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Code</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}">
                    @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Task Card Type Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Description/Remark</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}">
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Active</label>
                <div class="col-sm-6">
                    {{-- <select class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select> --}}

                    <input type="checkbox" class="js-switch form-control @error('status') is-invalid @enderror" name="status" checked />
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        @endslot
    @endcomponent
@endsection

@push('footer-scripts')
<script>
    var elem = document.querySelector('.js-switch');
    var switchery = new Switchery(elem, { color: '#1AB394' });
</script>
@endpush