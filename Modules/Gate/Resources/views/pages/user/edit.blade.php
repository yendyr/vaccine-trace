@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'User'])
        <li class="breadcrumb-item">
            <a href="/gate/user">User</a>
        </li>
        <li class="breadcrumb-item active">
            <a>Edit User</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('gate::components.edit', ['action' => '/gate/user/', 'row' => $user, 'name' => 'User'])
        @slot('formEdit')
            <div class="form-group row"><label class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{$user->username}}">
                    @error('username')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row"><label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$user->name}}">
                    @error('name')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row"><label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}">
                    @error('email')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row"><label class="col-sm-2 col-form-label">Company</label>
                <div class="col-sm-4">
                    <select class="form-control m-b @error('company') is-invalid @enderror" name="company">
                        @if($user->company_id == null)
                            <option disabled selected>-- none --</option>
                        @endif
                        @foreach($companies as $id => $companyName)
                            <option {{ ($id == $user->company_id) ? 'selected' : '' }} value="{{$id}}">{{$companyName}}</option>
                        @endforeach
                    </select>
                    @error('company')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row"><label class="col-sm-2 col-form-label">Role</label>
                <div class="col-sm-4">
                    <select class="form-control m-b @error('role') is-invalid @enderror" name="role">
                        @foreach($roles as $id => $role_name)
                            <option {{ ($id == $user->role_id) ? 'selected' : '' }} value="{{$id}}">{{$role_name}}</option>
                        @endforeach
                    </select>
                    @error('role')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        @endslot
    @endcomponent
@endsection

