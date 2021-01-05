@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Menu'])
        <li class="breadcrumb-item active">
            <a href="/gate/menu">Menu</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('components.delete-modal', ['name' => 'Menu data'])
    @endcomponent

    @include('gate::components.menu.modal')

    @component('gate::components.index', ['title' => 'Menus data'])
        @slot('tableContent')
            <div id="form_result" menu="alert"></div>
            <div class="p-4 d-flex justify-content-end" style="font-size:14px;">
                    <button type="button" id="createMenu" class="btn btn-primary"><i class="fa fa-plus-circle"></i>&nbsp;<strong>Menu</strong></button>
            </div>
            <div class="table-responsive">
                <table id="menu-table" class="table table-hover text-center">
                    <thead>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        @endslot
    @endcomponent

    @include('gate::components.menu._script')

@endsection
