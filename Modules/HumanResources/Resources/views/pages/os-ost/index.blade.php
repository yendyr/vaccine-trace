@extends('layouts.master')

@push('header-scripts')
    @include('humanresources::components.os._script')
    <script>
        @isset($allData)
            var sampling = {!! json_encode($allData) !!}
            console.log(sampling)
        @endisset


    </script>
    <style>
        .select2-container.select2-container--default.select2-container--open {
            z-index: 9999999 !important;
        }
        .select2{
            width: 100% !important;
        }
    </style>
@endpush

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Organization Structure'])
        <li class="breadcrumb-item active">
            <a href="/hr/os">Organization Structure</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @include('components.approve-modal')

{{--    @can('viewAny', \Modules\HumanResources\Entities\OrganizationStructureTitle::class)--}}
        @component('components.delete-modal', ['name' => 'Organization Structure Title data'])
        @endcomponent
        @include('humanresources::components.ost.modal')
{{--    @endpush--}}

    {{--    @can('viewAny', \Modules\HumanResources\Entities\OrganizationStructureTitle::class)--}}
        @component('components.delete-modal', ['name' => 'Organization Structure data'])
        @endcomponent
        @include('humanresources::components.os.modal')
    {{--    @endpush--}}

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#os">Header Structure</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#ost">Title Structure</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="os" class="tab-pane active">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Organization Structure data</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer">
                                <div id="form_result" role="alert"></div>

                                <div id="container">
                                    <div id="TreeGrid"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="ost" class="tab-pane">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Organization Structure Title data</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer">
                                <div id="form_result" role="alert"></div>

                                <div class="table-responsive">
                                    <table id="ost-table" class="table table-hover text-center" style="width: 100%">
                                        <thead>
                                        <tr class="text-center">
                                            <th>Title Code</th>
                                            <th>Job Title</th>
                                            <th>Report Organization</th>
                                            <th>Report Title</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <tr></tr>
                                        </tfoot>
                                    </table>
                                </div>
{{--                                    @can('create', \Modules\HumanResources\Entities\OrganizationStructureTitle::class)--}}
                                    <div class="col-md-4 offset-md-4 center">
                                        <button type="button" id="createOST" class="btn btn-block btn-primary"><strong>Add OST data</strong></button>
                                    </div>
{{--                                    @endcan--}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

{{--    @can('viewAny', \Modules\HumanResources\Entities\OrganizationStructure::class)--}}
        @push('footer-scripts')
            <script>
                var ele = document.getElementById('container');
                if(ele) {
                    ele.style.visibility = "visible";
                }
            </script>
            <script type="text/javascript">
                ej.treegrid.TreeGrid.Inject(ej.treegrid.Edit, ej.treegrid.Toolbar, ej.treegrid.Sort, ej.treegrid.Filter);

                var treeGridObj = new ej.treegrid.TreeGrid({
                    dataSource: sampling,
                    childMapping: 'childs',
                    toolbar: ['Add', 'Edit', 'Delete', 'Search'],
                    allowSorting: true,
                    searchSettings: { fields: ['orgcode', 'orgname']},
                    editSettings: { allowEditing: true, allowAdding: true, allowDeleting: true, showDeleteConfirmDialog: true,
                        mode: 'Row', newRowPosition: 'Child' },
                    treeColumnIndex: 1,
                    columns: [
                        { field: 'id', headerText: 'ID', isPrimaryKey: true, width: 45, textAlign: 'Center', visible: false},
                        { field: 'orgcode', headerText: 'Organization Code', width: 120, textAlign: 'Left'},
                        { field: 'orgparent', headerText: 'Organization Parent', width: 120, textAlign: 'Left', visible: false},
                        { field: 'orgname', headerText: 'Organization Name', width: 180, textAlign: 'Left'},
                        // { field: 'startDate', headerText: 'Start Date', width: 90, textAlign: 'Left', editType: 'datepickeredit', type: 'date', format: 'yMd', allowSorting: false },
                        { field: 'orglevel', headerText: 'Org. Level', width: 120, textAlign: 'Left',
                            allowSorting: false, type: 'number' },
                        { field: 'status', headerText: 'Status', width: 80, textAlign: 'Left', allowSorting: false,
                            valueAccessor: getStatus, disableHtmlEncode: false },
                    ],
                    height: 270,
                    actionBegin: function(args){
                        if (args.requestType === 'save') {
                            console.log('saved')
                        }
                    },
                    actionComplete: function(args){
                        if (args.requestType === 'beginEdit') {
                            console.log(args.form.querySelector("#forgcode").value);
                            // document.getElementById('osForm').attr('action', '/hr/ost/' + 1);
                        }
                        if (args.requestType === 'add') {
                            console.log('add')
                        }
                    },
                });

                function getStatus(field, data, column){
                    if (data.status == 1){
                        return '<p class="text-success">Active</p>';
                    } else if(data.status == 0){
                        return '<p class="text-danger">Inactive</p>';
                    }
                }

                treeGridObj.appendTo('#TreeGrid');
            </script>

            @include('humanresources::components.ost._script')
        @endpush
{{--    @endcan--}}

@endsection
