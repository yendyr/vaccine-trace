@extends('layouts.master')
@push('header-scripts')
    <style>
        .select2-container.select2-container--default.select2-container--open {
            z-index: 9999999 !important;
        }
        .select2{
            width: 100% !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" integrity="sha512-rxThY3LYIfYsVCWPCW9dB0k+e3RZB39f23ylUYTEuZMDrN/vRqLdaCBo/FbvVT6uC2r0ObfPzotsfKF9Qc5W5g==" crossorigin="anonymous" />
@endpush

@section('content')
    @component('components.delete-modal', ['name' => 'Holiday data'])
    @endcomponent
    @include('humanresources::pages.holiday.sunday-modal')
    @include('humanresources::pages.holiday.modal')

    @component('components.crud-form.index',[
                    'title' => 'Holiday Datalist',
                    'tableId' => 'holiday-table'])

        @slot('createButton')
            @can('create', \Modules\HumanResources\Entities\Holiday::class)
                <div id="form_result" role="alert"></div>
                <button type="button" id="create" class="btn btn-primary btn-lg" style="margin-left: 10px;">
                    <i class="fa fa-plus-square"></i> New Holiday
                </button>
                <button type="button" id="generate-sunday" class="btn btn-info btn-lg">
                    <i class="fa fa-plus-square"></i> Generate Sunday
                </button>
            @endcan
        @endslot

        @slot('tableContent')
            <th>Year</th>
            <th>Date</th>
            <th>Code</th>
            <th>Remark</th>
            <th>Status</th>
            <th>Action</th>
        @endslot

    @endcomponent

    @include('humanresources::components.holiday._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
