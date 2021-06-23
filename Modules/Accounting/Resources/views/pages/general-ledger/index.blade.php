@extends('layouts.master')

@section('content')
    <div class="row m-b">
        <div class="col-md-4">
            <div class="form-group" id="daterange">
                <label class="font-normal">Period Range</label>
                <div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="form-control-sm form-control" name="input_range" id="input_range" />
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <label>Choose COA</label>
            <select class="coas form-control @error('coas') is-invalid @enderror" id="coas" name="coas[]" multiple="multiple"></select>
            <div class="invalid-feedback-coas text-danger font-italic"></div>
            <span class="text-info font-italic">
                <i class="fa fa-info-circle"></i>
                you can choose multiple value
            </span>
        </div>
    </div>

    @component('components.crud-form.index',[
                    'title' => 'General Ledger',
                    'tableId' => 'general-ledger-table'])

        @slot('tableContent')
            <th>COA Name</th>
            <th>Journal Type</th>
            <th>Journal Transaction</th>
            <th>Transaction Reference</th>
            <th>Transaction Date</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
            <th>Remark</th>
        @endslot
    @endcomponent

    @include('accounting::components.general-ledger._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
    <link href="{{ URL::asset('theme/css/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <style>
        tr.group,
        tr.group:hover {
            background-color: #aaa !important;
        }
    </style>
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
    <script src="{{ URL::asset('theme/js/plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ URL::asset('theme/js/plugins/daterangepicker/daterangepicker.min.js') }}"></script>
@endpush
