@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        @component('components.delete-modal', ['name' => 'Task Card Tag Datalist'])
        @endcomponent

        @include('ppc::pages.taskcard-tag.modal')

        @component('components.crud-form.index',[
                        'title' => 'Task Card Tag Datalist',
                        'tableId' => 'taskcard-tag-table'])

            @slot('createButton')
                @can('create', Modules\PPC\Entities\TaskcardTag::class)                
                    <button type="button" id="create" class="btn btn-primary btn-lg">
                        <i class="fa fa-plus-circle"></i>&nbsp;Create New
                    </button>   
                @endcan
            @endslot    

            @slot('tableContent')
                <th>Code</th>
                <th>Name</th>
                <th>Remark</th>
                <!-- <th>Threshold</th>
                <th>Repeat</th>
                <th>Method</th> -->
                <th>Status</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Last Updated By</th>
                <th>Last Updated At</th>
                <th>Action</th>
            @endslot
        @endcomponent

        @include('ppc::components.taskcard-tag._script')
    </div>
</div>
@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush