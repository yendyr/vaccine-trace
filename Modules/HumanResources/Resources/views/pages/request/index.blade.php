@extends('layouts.master')

@push('header-scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" integrity="sha512-rxThY3LYIfYsVCWPCW9dB0k+e3RZB39f23ylUYTEuZMDrN/vRqLdaCBo/FbvVT6uC2r0ObfPzotsfKF9Qc5W5g==" crossorigin="anonymous" />
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
    @component('components.delete-modal', ['name' => 'Request Datalist'])
    @endcomponent

    @include('humanresources::pages.request.modal')

    @component('components.crud-form.index',[
                    'title' => 'Request Datalist',
                    'tableId' => 'request-table'])

        @slot('createButton')
            @can('create', \Modules\HumanResources\Entities\Request::class)
                <div id="form_result" role="alert"></div>
                <button type="button" id="create" class="btn btn-primary btn-lg"><i class="fa fa-plus-square"></i> New Request</button>
            @endcan
        @endslot

        @slot('tableContent')
            <th>Txn Period</th>
            <th>Request Code</th>
            <th>Request Type</th>
            <th>Document no.</th>
            <th>Document date</th>
            <th>Employee ID</th>
            <th>Work date</th>
            <th>Shift No.</th>
            <th>Workhour Start</th>
            <th>Workdate Start</th>
            <th>Workhour Finish</th>
            <th>Workdate Finish</th>
            <th>Rest Time Start</th>
            <th>Rest Date Start</th>
            <th>Rest Time Finish</th>
            <th>Rest Date Finish</th>
            <th>Work Status</th>
            <th>Quota year</th>
            <th>Remark</th>
            <th>Status</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('humanresources::components.request._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
