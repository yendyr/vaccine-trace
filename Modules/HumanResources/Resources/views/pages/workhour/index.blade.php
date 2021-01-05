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
                    ['name' => 'Working Hour',
                    'href' => '/hr/working-hour',
                ])
        @can('create', \Modules\HumanResources\Entities\WorkingHour::class)
            <div id="form_result" role="alert"></div>
            @if (request()->is('hr/working-hour/calculate'))
                <button type="button" id="calculate-whour" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-square"></i> Calculate</button>
            @elseif(request()->is('hr/working-hour'))
                <button type="button" id="create-whour" class="btn btn-info btn-lg">
                    <i class="fa fa-plus-square"></i> Generate</button>                                        
            @endif
        @endcan
    @endcomponent
@endsection

@section('content')

    @can('viewAny', \Modules\HumanResources\Entities\WorkingHour::class)
        @component('components.delete-modal', ['name' => 'Working Hour data'])
        @endcomponent
        @include('humanresources::components.workhour.modal')
    @endcan

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li>
                        <a class="nav-link active" data-toggle="tab" href="#whour">Working Hour</a>
                    </li>
                    @can('viewAny', \Modules\HumanResources\Entities\WorkingHourDetail::class)
                        <li>
                            <a class="nav-link" data-toggle="tab" href="#whour-detail">Working Hour Detail</a>
                        </li>
                    @endcan
                    @can('viewAny', \Modules\HumanResources\Entities\WorkingHourAttendance::class)
                        <li>
                            <a class="nav-link" data-toggle="tab" href="#whour-attendance">Working Hour Attendance</a>
                        </li>
                    @endcan
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="whour" class="tab-pane fade show active">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Working Hour Datalist</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer" id="ibox-whour">
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
                                            {{-- <th>Action</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="whour-detail" class="tab-pane fade">
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
                    <div role="tabpanel" id="whour-attendance" class="tab-pane fade">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Working Hour Attendance data</h4>

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
                                            <th>Time Start</th>
                                            <th>Date Start</th>
                                            <th>Time finish</th>
                                            <th>Date Finish</th>
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
                </div>
            </div>

        </div>
    </div>

    @can('viewAny', \Modules\HumanResources\Entities\WorkingHour::class)
        @include('humanresources::components.workhour._script')
        @can('viewAny', \Modules\HumanResources\Entities\WorkingHourDetail::class)
            @include('humanresources::components.workhour-detail._script')
        @endcan
        @can('viewAny', \Modules\HumanResources\Entities\WorkingHourAttendance::class)
            @include('humanresources::components.workhour-attendance._script')
        @endcan
    @endcan

@endsection
