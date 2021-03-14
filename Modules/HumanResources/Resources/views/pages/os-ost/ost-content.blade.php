<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Organization Struture Title Datalist'])
    @endcomponent

    @include('humanresources::pages.os-ost.ost-modal')

    @component('components.crud-form.index',[
                    'title' => 'Organization Struture Title Datalist',
                    'tableId' => 'ost-table'])

        @slot('createButton')
            @can('create', \Modules\HumanResources\Entities\OrganizationStructureTitle::class)
                <div id="form_result" role="alert"></div>
                <button type="button" id="createOST" class="btn btn-primary btn-lg" style="margin-left: 10px;">
                    <i class="fa fa-plus-circle"></i> Add Title Structure
                </button>
            @endcan
        @endslot

        @slot('tableContent')
            <th>Title Code</th>
            <th>Job Title</th>
            <th>Report Organization</th>
            <th>Report Title</th>
            <th>Status</th>
            <th>Action</th>
        @endslot
    @endcomponent
</div>

@include('humanresources::components.ost._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
