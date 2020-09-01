@extends('layouts.master')

@push('header-scripts')
    <style>
        .select2-container.select2-container--default.select2-container--open {
            z-index: 9999999 !important;
        }
        .select2{
            width: 100% !important;
        }

        .selected{
            background-color: #f2f2f2;
        }

        div.DTFC_RightBodyLiner{
            background-color: white;
            overflow-y: hidden !important;
            top: -13px !important;
        }
    </style>
@endpush

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Organization Structure'])
        <li class="breadcrumb-item active">
            <a href="/hr/workgroup">Working Group</a>
        </li>
    @endcomponent
@endsection

@section('content')

    @can('viewAny', \Modules\HumanResources\Entities\WorkingGroup::class)
        @component('components.delete-modal', ['name' => 'Working Group data'])
        @endcomponent
        @include('humanresources::components.workgroup.modal')
    @endcan
    @can('viewAny', \Modules\HumanResources\Entities\WorkingGroupDetail::class)
        @component('components.delete-modal', ['name' => 'Working Group Detail data'])
        @endcomponent
        @include('humanresources::components.workgroup-detail.modal')
    @endcan

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#workgroup">Working Group</a></li>
                    @can('viewAny', \Modules\HumanResources\Entities\WorkingGroupDetail::class)
                        <li><a class="nav-link" data-toggle="tab" href="#workgroup-detail">Working Group Detail</a></li>
                    @endcan
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="workgroup" class="tab-pane active">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Working Group data</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer" id="ibox-workgroup">
                                <div id="form_result" role="alert"></div>
                                <div class="col-md-1 m-2 p-1 row">
                                    @can('create', \Modules\HumanResources\Entities\WorkingGroup::class)
                                        <button type="button" id="create-wg" class="btn btn-block btn-primary"><strong><i class="fa fa-plus"></i></strong></button>
                                    @endcan
                                </div>
                                <div class="table-responsive">
                                    <table id="workgroup-table" class="table table-hover text-center display nowrap" width="100%">
                                        <thead>
                                        <tr class="text-center">
                                            <th>Work Group</th>
                                            <th>Work Name</th>
                                            <th>Shift Status</th>
                                            <th>Shift Rolling</th>
                                            <th>Range Rolling</th>
                                            <th>Round Time</th>
                                            <th>Work Finger</th>
                                            <th>Rest Finger</th>
                                            <th>Remark</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <tr></tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="workgroup-detail" class="tab-pane">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Working Group Detail data</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer" id="ibox-workgroup-detail">
                                <div id="form_result" role="alert"></div>
                                <div class="col-md-1 m-2 p-1 row">
                                    @can('create', \Modules\HumanResources\Entities\WorkingGroupDetail::class)
                                        <button type="button" id="create-wg-detail" class="btn btn-block btn-primary"><strong><i class="fa fa-plus"></i></strong></button>
                                    @endcan
                                </div>
                                <div class="table-responsive">
                                    <table id="workgroup-detail-table" class="table table-hover text-center display nowrap" width="100%">
                                        <thead>
                                        <tr class="text-center">
                                            <th>WorkGroup</th>
                                            <th>Day Code</th>
                                            <th>Shift No.</th>
                                            <th>Workhour Start</th>
                                            <th>Workhour Finish</th>
                                            <th>Rest Time Start</th>
                                            <th>Rest Time Finish</th>
                                            <th>Standard Hours</th>
                                            <th>Minimum Hours</th>
                                            <th>Working Type</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <tr></tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @can('viewAny', \Modules\HumanResources\Entities\WorkingGroup::class)
        @include('humanresources::components.workgroup._script')

        @can('viewAny', \Modules\HumanResources\Entities\WorkingGroupDetail::class)
            @include('humanresources::components.workgroup-detail._script')
        @endcan
    @endcan

@endsection
