@extends('layouts.master')

@section('content')

    @component('components.generate-modal', ['name' => 'Work Order Datalist'])
    @endcomponent

    @include('ppc::pages.job-card.generate.modal')

    @component('components.crud-form.index',[
                    'title' => 'Generate Job Card Datalist',
                    'tableId' => 'generate-job-card-table'])
    @endcomponent

    @include('ppc::components.job-card.generate._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
    <style>
        thead input {
            width: 100%;
        }
        tr.group,
        tr.group:hover {
            background-color: #aaa !important;
        }
    </style>
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush