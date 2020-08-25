@extends('layouts.master')

@push('header-scripts')
    <!-- Syncfusion Essential JS 2 Styles -->
    <link rel="stylesheet" href="https://cdn.syncfusion.com/ej2/material.css">
    <script src="https://cdn.syncfusion.com/ej2/dist/ej2.min.js" type="text/javascript"></script>

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
    @component('components.breadcrumb', ['name' => 'Organization Structure'])
        <li class="breadcrumb-item active">
            <a href="/hr/org-structure">Organization Structure</a>
        </li>
    @endcomponent
@endsection

@section('content')

    @can('viewAny', \Modules\HumanResources\Entities\OrganizationStructureTitle::class)
        @include('humanresources::components.ost.modal')
    @endcan

    @can('viewAny', \Modules\HumanResources\Entities\OrganizationStructure::class)
        @include('humanresources::components.os.modal')
    @endcan

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#os">Header Structure</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#ost">Title Structure</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="os" class="tab-pane active">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Organization Structure data</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer" id="ibox-os">
                                <div id="form_result" role="alert"></div>
                                <div class="row pb-2">
                                    <div class="col-4">
                                        <div class="m-1">
                                            <button type="button" onclick="reloadOs()" class="btn btn-secondary"><strong><i class="fa fa-repeat"></i></strong></button>
                                        </div>
                                    </div>
                                    <div class="col-8 text-right" style="font-size:14px;">
                                        @can('create', \Modules\HumanResources\Entities\OrganizationStructure::class)
                                            <div class="m-1">
                                                <button type="button" id="createOS" class="btn btn-primary"><strong><i class="fa fa-plus-circle"></i>&nbsp;Header Structure</strong></button>
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                                <div id="container">
                                    <div id="TreeGrid"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="ost" class="tab-pane">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Organization Structure Title data</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer" id="ibox-ost">
                                <div id="form_result" role="alert"></div>
                                <div class="p-4 d-flex justify-content-end" style="font-size:14px;">
                                    @can('create', \Modules\HumanResources\Entities\OrganizationStructureTitle::class)
                                        <button type="button" id="createOST" class="btn btn-primary"><strong><i class="fa fa-plus-circle"></i>&nbsp;Title Structure</strong></button>
                                    @endcan
                                </div>
                                <div class="table-responsive">
                                    <table id="ost-table" class="table table-hover text-center" style="width: 100%">
                                        <thead>
                                        <tr class="text-center">
                                            <th>Title Code</th>
                                            <th>Job Title</th>
                                            <th>Report Organization</th>
                                            <th>Report Title</th>
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
            </div>

        </div>
    </div>

    @can('viewAny', \Modules\HumanResources\Entities\OrganizationStructure::class)
        @push('footer-scripts')
            <script>
                var ele = document.getElementById('container');
                if(ele) {
                    ele.style.visibility = "visible";
                }
            </script>
        @endpush
        @can('viewAny', \Modules\HumanResources\Entities\OrganizationStructureTitle::class)
            @include('humanresources::components.ost._script')
        @endcan

        @include('humanresources::components.os._script')
    @endcan

@endsection
