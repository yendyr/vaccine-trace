@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Data Partisipan Vaksinasi'])
    @endcomponent

    @include('vaksinasi::pages.vaccination-participant.modal')

    @component('components.crud-form.index',[
                    'title' => 'Data Partisipan Vaksinasi',
                    'tableId' => 'vaccination-participant-table'])

        @slot('createButton')
            @can('create', Modules\Vaksinasi\Entities\VaccinationParticipant::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Tambah Baru
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Tanggal</th>
            <th>Nama Satuan</th>
            <th>Jenis Identitas</th>
            <th>Nomor Identitas</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Jenis Vaksin</th>
            {{-- <th>Created By</th> --}}
            <th>Created At</th>
            {{-- <th>Last Updated By</th> --}}
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('vaksinasi::components.vaccination-participant._script')

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