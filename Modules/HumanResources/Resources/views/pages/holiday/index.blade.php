@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Holidays'])
        <li class="breadcrumb-item active">
            <a href="/hr/holiday">Holiday</a>
        </li>
    @endcomponent
@endsection

@section('content')

    @can('viewAny', \Modules\HumanResources\Entities\Holiday::class)
        @component('components.delete-modal', ['name' => 'Holiday data'])
        @endcomponent
        @include('humanresources::components.holiday.sunday-modal')
        @include('humanresources::components.holiday.modal')
    @endcan

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h4 class="text-center">Holiday data</h4>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-footer" id="ibox-holiday">
                    <div id="form_result" role="alert"></div>
                        <div class="row mb-2 p-1">
                            @can('create', \Modules\HumanResources\Entities\Holiday::class)
                                <div class="col-md-1">
                                    <button type="button" id="create-holiday" class="btn btn-block btn-primary"><strong><i class="fa fa-plus"></i></strong></button>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="generate-sunday" class="btn btn-block btn-info" data-toggle="modal" data-target="#sundayModal"><strong>Generate Sunday</strong></button>
                                </div>
                            @endcan
                        </div>

                    <div class="table-responsive">
                        <table id="holiday-table" class="table table-hover text-center" style="width: 100%">
                            <thead>
                                <tr class="text-center">
                                    <th>
                                        <p class="title mb-1">Code</p>
                                        <select class="form-control m-b-sm" id="search-code" name="search-code"></select>
                                    </th>
                                    <th>
                                        <p class="title mb-1">Year</p>
                                        <select class="form-control m-b-sm" id="search-year" name="search-year"></select>
                                    </th>
                                    <th>Date</th>
                                    <th>Remark</th>
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
                </div>
            </div>

        </div>
    </div>

    @can('viewAny', \Modules\HumanResources\Entities\Holiday::class)
        @include('humanresources::components.holiday._script')
    @endcan

@endsection
