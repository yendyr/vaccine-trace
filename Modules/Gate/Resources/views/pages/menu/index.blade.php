@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Menu'])
        <li class="breadcrumb-item active">
            <a href="/gate/menu">Menu</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('components.delete-modal', ['name' => 'Menu Datalist'])
    @endcomponent

    @include('gate::components.menu.modal')

    @component('components.crud-form.index', ['title' => 'Menu Datalist'])
        @slot('tableContent')
            <div id="form_result" menu="alert"></div>
            
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

@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush