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

        .modal-dialog{
            overflow-y: initial !important
        }
        .modal-body{
            max-height: calc(100vh - 200px);
            overflow-y: auto;
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
            <a href="/hr/employee">Employee</a>
        </li>
    @endcomponent
@endsection

@section('content')

    @can('viewAny', \Modules\HumanResources\Entities\Employee::class)
        @component('components.delete-modal', ['name' => 'Employees data'])
        @endcomponent
        @include('humanresources::components.employee.modal')

        @can('viewAny', \Modules\HumanResources\Entities\IdCard::class)
            @include('humanresources::components.idcard.modal')
        @endcan
        @can('viewAny', \Modules\HumanResources\Entities\Education::class)
            @include('humanresources::components.education.modal')
        @endcan
        @can('viewAny', \Modules\HumanResources\Entities\Family::class)
            @include('humanresources::components.family.modal')
        @endcan
        @can('viewAny', \Modules\HumanResources\Entities\Address::class)
            @include('humanresources::components.address.modal')
        @endcan
        @can('viewAny', \Modules\HumanResources\Entities\WorkingHour::class)
            @include('humanresources::components.workhour.modal')
        @endcan
        @can('viewAny', \Modules\HumanResources\Entities\Attendance::class)
            @include('humanresources::components.attendance.modal')
        @endcan
    @endcan

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#employee">Employees</a></li>
                    @can('viewAny', \Modules\HumanResources\Entities\IdCard::class)
                        <li><a class="nav-link" data-toggle="tab" href="#idcard">ID Card</a></li>
                    @endcan
                    @can('viewAny', \Modules\HumanResources\Entities\Education::class)
                        <li><a class="nav-link" data-toggle="tab" href="#education">Education</a></li>
                    @endcan
                    @can('viewAny', \Modules\HumanResources\Entities\Family::class)
                        <li><a class="nav-link" data-toggle="tab" href="#family">Family</a></li>
                    @endcan
                    @can('viewAny', \Modules\HumanResources\Entities\Address::class)
                        <li><a class="nav-link" data-toggle="tab" href="#address">Address</a></li>
                    @endcan
                    @can('viewAny', \Modules\HumanResources\Entities\WorkingHour::class)
                        <li><a class="nav-link" data-toggle="tab" href="#whour">Working Hour</a></li>
                    @endcan
                    @can('viewAny', \Modules\HumanResources\Entities\WorkingHourDetail::class)
                        <li><a class="nav-link" data-toggle="tab" href="#whour-detail">Working Hour detail</a></li>
                    @endcan
                    @can('viewAny', \Modules\HumanResources\Entities\WorkingHourAttendance::class)
                        <li><a class="nav-link" data-toggle="tab" href="#whour-attendance">Working Hour attendance</a></li>
                    @endcan
                    @can('viewAny', \Modules\HumanResources\Entities\Attendance::class)
                        <li><a class="nav-link" data-toggle="tab" href="#attendance">Attendance</a></li>
                    @endcan
                </ul>
                <div class="tab-content">
                    @component('humanresources::components.index', ['idPanel' => 'employee', 'iboxTitle' => 'Employees data', 'ibox' => 'employee'])
                        @slot('addButton')
                            @can('create', \Modules\HumanResources\Entities\Employee::class)
                                <button type="button" id="create-employee" class="btn btn-block btn-primary"><strong><i class="fa fa-plus"></i></strong></button>
                            @endcan
                        @endslot
                        @slot('tableContent')
                            <table id="employee-table" class="table table-hover text-center display nowrap" width="100%">
                                <thead>
                                <tr class="text-center">
                                    <th>photo</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Place of birth</th>
                                    <th>Date of birth</th>
                                    <th>Gender</th>
                                    <th>Religion</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Bloodtype</th>
                                    <th>Marital status</th>
                                    <th>Emp date</th>
                                    <th>Cessation date</th>
                                    <th>Probation</th>
                                    <th>Cessation code</th>
                                    <th>Recruit by</th>
                                    <th>Employee type</th>
                                    <th>Workgroup</th>
                                    <th>Site</th>
                                    <th>Access group</th>
                                    <th>Achievement group</th>
                                    <th>Org code</th>
                                    <th>Org. level</th>
                                    <th>Title</th>
                                    <th>Jobtitle</th>
                                    <th>Job group</th>
                                    <th>Cost code</th>
                                    <th>Remark</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        @endslot
                    @endcomponent
                    <div role="tabpanel" id="idcard" class="tab-pane">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">ID Card data</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer" id="ibox-idcard">
                                <div id="form_result" role="alert"></div>
                                <div class="col-md-1 m-2 p-1 row">
                                    @can('create', \Modules\HumanResources\Entities\IdCard::class)
                                        <button type="button" id="create-idcard" class="btn btn-block btn-primary"><strong><i class="fa fa-plus"></i></strong></button>
                                    @endcan
                                </div>
                                <div class="table-responsive">
                                    <table id="idcard-table" class="table table-hover text-center display nowrap" width="100%">
                                        <thead>
                                        <tr class="text-center">
                                            <th>Employee ID</th>
                                            <th>ID card type</th>
                                            <th>ID card no.</th>
                                            <th>ID card date</th>
                                            <th>ID card exp date</th>
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
                    <div role="tabpanel" id="education" class="tab-pane">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Education data</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer" id="ibox-education">
                                <div id="form_result" role="alert"></div>
                                <div class="col-md-1 m-2 p-1 row">
                                    @can('create', \Modules\HumanResources\Entities\Education::class)
                                        <button type="button" id="create-education" class="btn btn-block btn-primary"><strong><i class="fa fa-plus"></i></strong></button>
                                    @endcan
                                </div>
                                <div class="table-responsive">
                                    <table id="education-table" class="table table-hover text-center display nowrap" width="100%">
                                        <thead>
                                        <tr class="text-center">
                                            <th>Employee ID</th>
                                            <th>Instantion Name</th>
                                            <th>Start periode</th>
                                            <th>Finish periode</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Country</th>
                                            <th>Majors</th>
                                            <th>Minors</th>
                                            <th>Education level</th>
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
                    <div role="tabpanel" id="family" class="tab-pane">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Family data</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer" id="ibox-family">
                                <div id="form_result" role="alert"></div>
                                <div class="col-md-1 m-2 p-1 row">
                                    @can('create', \Modules\HumanResources\Entities\Family::class)
                                        <button type="button" id="create-family" class="btn btn-block btn-primary"><strong><i class="fa fa-plus"></i></strong></button>
                                    @endcan
                                </div>
                                <div class="table-responsive">
                                    <table id="family-table" class="table table-hover text-center display nowrap" width="100%">
                                        <thead>
                                        <tr class="text-center">
                                            <th>Employee ID</th>
                                            <th>Family ID</th>
                                            <th>Relationship</th>
                                            <th>Full Name</th>
                                            <th>Place of birth</th>
                                            <th>Date of birth</th>
                                            <th>Gender</th>
                                            <th>Marital status</th>
                                            <th>Education level</th>
                                            <th>Education major</th>
                                            <th>Job</th>
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
                    <div role="tabpanel" id="address" class="tab-pane">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Address data</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer" id="ibox-address">
                                <div id="form_result" role="alert"></div>
                                <div class="col-md-1 m-2 p-1 row">
                                    @can('create', \Modules\HumanResources\Entities\Address::class)
                                        <button type="button" id="create-address" class="btn btn-block btn-primary"><strong><i class="fa fa-plus"></i></strong></button>
                                    @endcan
                                </div>
                                <div class="table-responsive">
                                    <table id="address-table" class="table table-hover text-center display nowrap" width="100%">
                                        <thead>
                                        <tr class="text-center">
                                            <th>Employee ID</th>
                                            <th>Family ID</th>
                                            <th>Address ID</th>
                                            <th>Street</th>
                                            <th>Area</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Country</th>
                                            <th>Postcode</th>
                                            <th>Telephone</th>
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
                    <div role="tabpanel" id="whour" class="tab-pane">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Working Hour data</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer" id="ibox-whour">
                                <div id="form_result" role="alert"></div>
                                <div class="col-md-1 m-2 p-1 row">
                                    @can('create', \Modules\HumanResources\Entities\WorkingHour::class)
                                        <button type="button" id="create-whour" class="btn btn-block btn-primary"><strong>Generate</strong></button>
                                    @endcan
                                </div>
                                <div class="table-responsive">
                                    <table id="whour-table" class="table table-hover text-center display nowrap" width="100%">
                                        <thead>
                                        <tr class="text-center">
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
                                            <th>Standard Hours</th>
                                            <th>Minimum Hours</th>
                                            <th>Work Type</th>
                                            <th>Work Status</th>
                                            <th>Processedon</th>
                                            <th>Leave hours</th>
                                            <th>Attendance hours</th>
                                            <th>Over hours</th>
                                            <th>Attendance status</th>
                                            <th>Status</th>
{{--                                            <th>Action</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="whour-detail" class="tab-pane">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Working Hour Detail data</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer" id="ibox-whour-detail">
                                <div id="form_result" role="alert"></div>
                                <div class="table-responsive">
                                    <table id="whour-detail-table" class="table table-hover text-center display nowrap" width="100%">
                                        <thead>
                                        <tr class="text-center">
                                            <th>Employee ID</th>
                                            <th>Work date</th>
                                            <th>Attendance type</th>
                                            <th>Date Start</th>
                                            <th>Time Start</th>
                                            <th>Date Finish</th>
                                            <th>Time finish</th>
                                            <th>Processedon</th>
                                            <th>Main Attendance</th>
                                            <th>Calc Date Start</th>
                                            <th>Calc Time Start</th>
                                            <th>Calc Date Finish</th>
                                            <th>Calc Time Finish</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="whour-attendance" class="tab-pane">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Working Hour Detail data</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer" id="ibox-whour-attendance">
                                <div id="form_result" role="alert"></div>
                                <div class="table-responsive">
                                    <table id="whour-attendance-table" class="table table-hover text-center display nowrap" width="100%">
                                        <thead>
                                        <tr class="text-center">
                                            <th>Employee ID</th>
                                            <th>Work date</th>
                                            <th>Attendance type</th>
                                            <th>Date Start</th>
                                            <th>Time Start</th>
                                            <th>Date Finish</th>
                                            <th>Time finish</th>
                                            <th>Validatedon</th>
                                            <th>Processedon</th>
                                            <th>Round Date Start</th>
                                            <th>Round Time Start</th>
                                            <th>Round Date Finish</th>
                                            <th>Round Time Finish</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="attendance" class="tab-pane">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Attendance data</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer" id="ibox-attendance">
                                <div id="form_result" role="alert"></div>
                                <div class="table-responsive">
                                    <table id="attendance-table" class="table table-hover text-center display nowrap" width="100%">
                                        <thead>
                                        <tr class="text-center">
                                            <th>Employee ID</th>
                                            <th>Attendance type</th>
                                            <th>Attendance date</th>
                                            <th>Attendance time</th>
                                            <th>Device</th>
                                            <th>Inputon</th>
                                            <th>Status</th>
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
            </div>

        </div>
    </div>

    @can('viewAny', \Modules\HumanResources\Entities\Employee::class)
        @include('humanresources::components.employee._script')

        @can('viewAny', \Modules\HumanResources\Entities\IdCard::class)
            @include('humanresources::components.idcard._script')
        @endcan
        @can('viewAny', \Modules\HumanResources\Entities\Education::class)
            @include('humanresources::components.education._script')
        @endcan
        @can('viewAny', \Modules\HumanResources\Entities\Family::class)
            @include('humanresources::components.family._script')
        @endcan
        @can('viewAny', \Modules\HumanResources\Entities\Address::class)
            @include('humanresources::components.address._script')
        @endcan
        @can('viewAny', \Modules\HumanResources\Entities\WorkingHour::class)
            @include('humanresources::components.workhour._script')
        @endcan
        @can('viewAny', \Modules\HumanResources\Entities\WorkingHourDetail::class)
            @include('humanresources::components.workhour-detail._script')
        @endcan
        @can('viewAny', \Modules\HumanResources\Entities\WorkingHourAttendance::class)
            @include('humanresources::components.workhour-attendance._script')
        @endcan
        @can('viewAny', \Modules\HumanResources\Entities\Attendance::class)
            @include('humanresources::components.attendance._script')
        @endcan
    @endcan

@endsection
