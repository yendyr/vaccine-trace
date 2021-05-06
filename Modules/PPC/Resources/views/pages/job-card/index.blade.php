@extends('layouts.master')

@section('content')
    @include('ppc::pages.job-card.modal')

    @component('components.crud-form.index',[
                    'title' => 'Job Card Datalist',
                    'tableId' => 'job-card-table'])
    @endcomponent

    @include('ppc::components.job-card._script')

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