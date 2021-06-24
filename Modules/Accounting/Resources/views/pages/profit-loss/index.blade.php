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
                    'title' => 'Profit & Loss',
                    'tableId' => 'profit-loss-table'])

        @slot('tableContent')
            <th>COA Class</th>
            <th>COA Code</th>
            <th>COA Name</th>
            <th>In-Period Balance</th>
            <th>All Time Balance</th>
            {{-- <th>Debit</th>
            <th>Credit</th> --}}
        @endslot
    @endcomponent

    @include('accounting::components.profit-loss._script')

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
