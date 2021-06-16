@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Journal Datalist'])
    @endcomponent

    @component('components.approve-modal', ['name' => 'Journal Datalist'])
    @endcomponent

    @include('procurement::pages.journal.modal')

    @component('components.crud-form.index',[
                    'title' => 'Journal Datalist',
                    'tableId' => 'journal-table'])

        @slot('createButton')
            @can('create', Modules\Accounting\Entities\Journal::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Transaction Code</th>
            <th>Transaction Date</th>
            <th>Remark</th>
            <th>Transaction Reference</th>
            <th>Current Primary/Local Currency</th>
            <th>Currency</th>
            <th>Exchange Rate</th>
            <th>Total Amount</th>
            <th>Created By</th>
            <th>Created At</th>
            {{-- <th>Last Updated By</th>
            <th>Last Updated At</th> --}}
            <th>Action</th>
        @endslot
    @endcomponent

    @include('accounting::components.journal._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush