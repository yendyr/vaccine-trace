@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Menu Datalist'])
    @endcomponent

    @include('gate::components.menu.modal')
    @component('components.crud-form.index', [
                    'title' => 'Menu Datalist',
                    'tableId' => 'menu-table',
                    'ajaxSource' => '/gate/menu'])
    @endcomponent

    @include('gate::components.menu._script')

@endsection

@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
