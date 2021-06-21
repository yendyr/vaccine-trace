@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="daterange">
            <label class="font-normal">Range select</label>
            <div class="input-daterange input-group" id="datepicker">
                <input type="text" class="form-control-sm form-control" name="input_range" id="input_range" />
            </div>
        </div>
    </div>
</div>

    @component('components.crud-form.index',[
                    'title' => 'Trial Balance',
                    'tableId' => 'trial-balance-table'])

        @slot('tableContent')
            <th>COA Code</th>
            <th>COA Name</th>
            <th>Beginning Debit</th>
            <th>Beginning Credit</th>
            <th>In-Period Debit</th>
            <th>In-Period Credit</th>
            <th>Ending Debit</th>
            <th>Ending Credit</th>
        @endslot
    @endcomponent

    @include('accounting::components.trial-balance._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
    <link href="{{ URL::asset('theme/css/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    {{-- <style>
        thead input {
            width: 100%;
        }
        tr.group,
        tr.group:hover {
            background-color: #aaa !important;
        }
    </style> --}}
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
    <script src="{{ URL::asset('theme/js/plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ URL::asset('theme/js/plugins/daterangepicker/daterangepicker.min.js') }}"></script>
@endpush
