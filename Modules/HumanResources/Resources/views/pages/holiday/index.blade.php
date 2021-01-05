@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb',
                    ['name' => 'Holiday',
                    'href' => '/hr/holiday',
                ])
        @can('create', \Modules\HumanResources\Entities\Holiday::class)
            <div id="form_result" role="alert"></div>
            <button type="button" id="create-holiday" class="btn btn-primary btn-lg" style="margin-left: 10px;">
                <i class="fa fa-plus-square"></i> Add New Holiday
            </button>
            <button type="button" id="generate-sunday" class="btn btn-info btn-lg">
                <i class="fa fa-plus-square"></i> Generate Sunday
            </button>
        @endcan
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
                    <h4 class="text-center">Holiday Datalist</h4>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-footer" id="ibox-holiday">
                    <div class="table-responsive">
                        <table id="holiday-table" class="table table-hover text-center" style="width: 100%">
                            <thead>
                                <tr class="text-center">
                                    <th>Year</th>
                                    <th>Date</th>
                                    <th>Code</th>
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
