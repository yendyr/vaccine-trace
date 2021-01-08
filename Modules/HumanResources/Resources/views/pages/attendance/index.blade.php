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
        @can('create', \Modules\HumanResources\Entities\Attendance::class)
            <div id="form_result" role="alert"></div>
            @if(request()->is('hr/attendance/import'))
                <button type="button" id="import-attendance" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-square"></i> Import Data</button>
            @elseif(request()->is('hr/attendance'))
                <button type="button" id="create-attendance" class="btn btn-info btn-lg">
                    <i class="fa fa-plus-square"></i> Add Data</button>
            @endif
        @endcan
@endsection

@section('content')
    @can('viewAny', \Modules\HumanResources\Entities\Attendance::class)
        @include('humanresources::components.attendance.modal')
        @component('components.delete-modal', ['name' => 'Attendance data'])
        @endcomponent
    @endcan

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h4 class="text-center">Attendance Datalist</h4>

                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-footer" id="ibox-attendance">
                    <div class="table-responsive">
                        <table id="attendance-table" class="table table-hover text-center display nowrap" width="100%">
                            <thead>
                            <tr class="text-center">
                                <th>Employee ID</th>
                                <th>Attendance type</th>
                                <th>Attendance date</th>
                                <th>Attendance time</th>
                                <th>Device</th>
                                <th>Input On</th>
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
        @include('humanresources::components.attendance._script')
    @endcan

@endsection
