@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Data Satuan'])
    @endcomponent

    @include('vaksinasi::pages.squad.modal')

    @component('components.crud-form.index',[
                    'title' => 'Data Satuan',
                    'tableId' => 'squad-table'])

        @slot('createButton')
            @can('create', Modules\Vaksinasi\Entities\Squad::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Tambah Baru
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Kode</th>
            <th>Nama Satuan</th>
            <th>Deskripsi</th>
            <th>Alamat</th>
            <th>Target Vaksinasi</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Last Updated By</th>
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('vaksinasi::components.squad._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush