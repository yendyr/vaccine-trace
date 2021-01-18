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
        @can('create', \Modules\HumanResources\Entities\LeaveQuota::class)
            <div id="form_result" role="alert"></div>
            <button type="button" id="create-leave-quota" class="btn btn-primary btn-lg"><i class="fa fa-plus-square"></i> Add New Leave Quota</button>
        @endcan
@endsection

@section('content')
    @can('viewAny', \Modules\HumanResources\Entities\LeaveQuota::class)
        @include('humanresources::components.leave-quota.modal')
        @component('components.delete-modal', ['name' => 'Leave Quota data'])
        @endcomponent
    @endcan

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h4 class="text-center">Leave Quota Datalist</h4>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-footer" id="ibox-leave-quota">
                    <div class="table-responsive">
                        <table id="leave-quota-table" class="table table-hover text-center display nowrap" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th>Employee ID</th>
                                    <th>Quota Year</th>
                                    <th>Quota Code</th>
                                    <th>Quota start date</th>
                                    <th>Quota exp date</th>
                                    <th>Quota alloc date</th>
                                    <th>Quota quantity</th>
                                    <th>Quota remains</th>
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

    @can('viewAny', \Modules\HumanResources\Entities\Attendance::class)
        @include('humanresources::components.leave-quota._script')
    @endcan

@endsection
