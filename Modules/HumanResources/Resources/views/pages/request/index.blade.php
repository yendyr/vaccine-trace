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
    @component('components.breadcrumb',
                    ['name' => 'Request',
                    'href' => '/hr/request',
                ])
        @can('create', \Modules\HumanResources\Entities\Request::class)
            <div id="form_result" role="alert"></div>
            <button type="button" id="create-request" class="btn btn-primary btn-lg"><i class="fa fa-plus-square"></i> Add New Request</button>
        @endcan
    @endcomponent
@endsection

@section('content')

    @can('viewAny', \Modules\HumanResources\Entities\Request::class)
        @component('components.delete-modal', ['name' => 'Request data'])
        @endcomponent
        @include('humanresources::components.request.modal')
    @endcan

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h4 class="text-center">Request Datalist</h4>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-footer" id="ibox-request">
                    <div class="table-responsive">
                        <table id="request-table" class="table table-hover text-center display nowrap" width="100%">
                            <thead>
                            <tr class="text-center">
                                <th>Txn Period</th>
                                <th>Request Code</th>
                                <th>Request Type</th>
                                <th>Document no.</th>
                                <th>Document date</th>
                                <th>Employee ID</th>
                                <th>Work date</th>
                                <th>Shift No.</th>
                                <th>Workhour Start</th>
                                <th>Workdate Start</th>
                                <th>Workhour Finish</th>
                                <th>Workdate Finish</th>
                                <th>Rest Time Start</th>
                                <th>Rest Date Start</th>
                                <th>Rest Time Finish</th>
                                <th>Rest Date Finish</th>
                                <th>Work Status</th>
                                <th>Quota year</th>
                                <th>Remark</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @can('viewAny', \Modules\HumanResources\Entities\Request::class)
        @include('humanresources::components.request._script')
    @endcan

@endsection
