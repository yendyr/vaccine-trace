@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group" id="daterange">
                <label class="font-normal">Period Range</label>
                <div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="form-control-sm form-control" name="input_range" id="input_range" />
                </div>
            </div>
        </div>
    </div>

    @component('components.crud-form.index',[
                    'title' => 'Trial Balance',
                    'tableId' => 'trial-balance-table'])

        @slot('headerSpan')
            <tr>
                <th rowspan="2" class="text-center align-middle">COA Class</th>
                <th rowspan="2" class="text-center align-middle">COA Code</th>
                <th rowspan="2" class="text-center align-middle">COA Name</th>
                <th colspan="2" class="text-right">Beginning Balance</th>
                <th colspan="2" class="text-right">In-Period Transaction</th>
                <th colspan="2" class="text-center">Balance</th>
                <th rowspan="2" class="text-center align-middle">Ending Balance</th>
            </tr>
        @endslot
        @slot('tableContent')
            <th>Debit</th>
            <th>Credit</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Debit</th>
            <th>Credit</th>
        @endslot
    @endcomponent

    @include('accounting::components.trial-balance._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
    <link href="{{ URL::asset('theme/css/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <style>
        /* thead input {
            width: 100%;
        } */
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
