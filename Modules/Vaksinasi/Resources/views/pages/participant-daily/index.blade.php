@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Data Total Vaksinasi Harian'])
    @endcomponent

    @include('vaksinasi::pages.participant-daily.modal')

    @component('components.crud-form.index',[
                    'title' => 'Data Total Vaksinasi Harian',
                    'tableId' => 'participant-daily-table'])

        @slot('createButton')
            @can('create', Modules\Vaksinasi\Entities\ParticipantDailyCount::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Tambah Baru
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Tanggal</th>
            <th>Nama Satuan</th>
            <th>Kategori</th>
            <th>Total</th>
            {{-- <th>Created By</th> --}}
            <th>Created At</th>
            {{-- <th>Last Updated By</th> --}}
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('vaksinasi::components.participant-daily._script')

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