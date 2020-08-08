@extends('layouts.master')

@push('header-scripts')
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
                    <div class="col-md-1 m-2 p-1 row">
                        @can('create', \Modules\HumanResources\Entities\WorkingGroup::class)
                            <button type="button" id="create-holiday" class="btn btn-block btn-primary"><strong><i class="fa fa-plus"></i></strong></button>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table id="holiday-table" class="table table-hover text-center" style="width: 100%">
                            <thead>
                            <tr class="text-center">
                                <th>Code</th>
                                <th>Year</th>
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

    @can('viewAny', \Modules\HumanResources\Entities\WorkingGroup::class)
        @push('footer-scripts')
            @include('humanresources::components.holiday._script')
        @endpush
    @endcan

@endsection
