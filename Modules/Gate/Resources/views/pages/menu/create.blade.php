@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Menu'])
        <li class="breadcrumb-item">
            <a href="/gate/menu">Menu</a>
        </li>
        <li class="breadcrumb-item active">
            <a>Create Menu</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('gate::components.create', ['action' => '/gate/menu', 'name' => 'Menu'])
        @slot('formCreate')
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Menu Link</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control @error('menu_link') is-invalid @enderror" name="menu_link" value="{{ old('menu_link')}}">
                    @error('menu_link')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Menu Parent</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control @error('parent') is-invalid @enderror" name="parent" value="{{ old('parent')}}">
                    @error('parent')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        @endslot
    @endcomponent
@endsection
