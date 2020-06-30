@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Role'])
        <li class="breadcrumb-item">
            <a href="/gate/role">Role</a>
        </li>
        <li class="breadcrumb-item active">
            <a>Edit Role</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('gate::components.edit', ['action' => '/gate/role/', 'row' => $role, 'name' => 'Role'])
        @slot('formEdit')
            <div class="form-group row"><label class="col-sm-2 col-form-label">Role Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control @error('role_name') is-invalid @enderror" name="role_name" value="{{$role->role_name}}">
                    @error('role_name')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        @endslot
    @endcomponent
@endsection

