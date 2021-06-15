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
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" id="myTab">
                    @can('viewAny', \Modules\HumanResources\Entities\WorkingGroup::class)
                    <li>
                        <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-1" style="min-height: 50px;" id="tab-header">
                            <i class="fa fa-briefcase fa-2x text-warning"></i>&nbsp;Workgroup
                        </a>
                    </li>
                    @endcan
                    @can('viewAny', \Modules\HumanResources\Entities\WorkingGroupDetail::class)
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 50px;" id="tab-detail">
                            <i class="fa fa-plus fa-2x text-warning"></i>&nbsp;Detail Workgroup
                        </a>
                    </li>
                    @endcan
                </ul>
                <div class="tab-content">
                    @can('viewAny', \Modules\HumanResources\Entities\WorkingGroup::class)
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('humanresources::pages.workgroup.content')
                            </div>
                        </div>
                    </div>
                    @endcan
                    @can('viewAny', \Modules\HumanResources\Entities\WorkingGroupDetail::class)
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('humanresources::pages.workgroup.detail-content')
                            </div>
                        </div>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>

@endsection

@push('footer-scripts')
    <script>
        $(document).ready(function(){
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
                $('#myTab a[href="' + activeTab + '"]').tab('show');
            }
        });
    </script>
@endpush
