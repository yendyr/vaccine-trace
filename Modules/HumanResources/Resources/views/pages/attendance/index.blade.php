@extends('layouts.master')

@push('header-scripts')
    <style>
        .select2-container.select2-container--default.select2-container--open {
            z-index: 9999999 !important;
        }
        .select2{
            width: 100% !important;
        }

        .selected{
            background-color: #f2f2f2;
        }

        div.DTFC_RightBodyLiner{
            background-color: white;
            overflow-y: hidden !important;
            top: -13px !important;
        }
    </style>
@endpush

@section('content')
    @component('components.delete-modal', ['name' => 'Attendance data'])
    @endcomponent

    @include('humanresources::pages.attendance.modal')

    <div id="form_result" role="alert"></div>
    @component('components.crud-form.index',[
                    'title' => 'Attendance Datalist',
                    'tableId' => 'attendance-table'])

        @slot('createButton')
            @if(request()->is('hr/attendance/import'))
                <button type="button" id="import-attendance" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-square"></i> Import Data</button>
            @elseif(request()->is('hr/attendance'))
                <button type="button" id="create-attendance" class="btn btn-info btn-lg">
                    <i class="fa fa-plus-square"></i> Add Data</button>
            @endif
        @endslot

        @slot('tableContent')
            <th>Employee ID</th>
            <th>Attendance type</th>
            <th>Attendance date</th>
            <th>Attendance time</th>
            <th>Device</th>
            <th>Input On</th>
            <th>Status</th>
            <th>Action</th>
        @endslot

    @endcomponent

    @include('humanresources::components.attendance._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
