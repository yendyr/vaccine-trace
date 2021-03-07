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

@section('content')
    @can('viewAny', \Modules\HumanResources\Entities\Attendance::class)
        @include('humanresources::pages.attendance.modal')
        @component('components.delete-modal', ['name' => 'Attendance data'])
        @endcomponent
    @endcan

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <div class="row">
                        <div class="col-md-11 text-center">
                            <h3 class="text-center">Attendance Validation Datalist</h3>
                        </div>
                    </div>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-footer mb-3" id="ibox-validation-in">
                    <div id="form_result" role="alert"></div>
                    <div class="row justify-content-center">
                        <div class="text-center">
                            <h4>Validation In Data</h4>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="validation-in-table" class="table table-hover text-center display nowrap" width="100%">
                            <thead>
                            <tr class="text-center">
                                <th>Employee ID</th>
                                <th>Attendance type</th>
                                <th>Attendance date</th>
                                <th>Attendance time</th>
                                <th>Device</th>
                                <th>Input On</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="ibox-footer" id="ibox-validation-out">
                    <div id="form_result" role="alert"></div>
                    <div class="row justify-content-center">
                        <div class="text-center">
                            <h4>Validation Out Data</h4>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="validation-out-table" class="table table-hover text-center display nowrap" width="100%">
                            <thead>
                            <tr class="text-center">
                                <th>Employee ID</th>
                                <th>Attendance type</th>
                                <th>Attendance date</th>
                                <th>Attendance time</th>
                                <th>Device</th>
                                <th>Input On</th>
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

    @can('viewAny', \Modules\HumanResources\Entities\Attendance::class)
        @include('humanresources::components.attendance._script')
    @endcan

@endsection
