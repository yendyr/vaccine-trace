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

        .scrollable-tabs{
            margin: 0% 3% 1%;
        }
        .responsive__tabs ul.scrollable-tabs {
            background-color: rgb(229, 235, 238);
            padding: 0% 2%;
            overflow-x: auto;
            white-space: nowrap;
            display: flex;
            flex-direction: row;
        }
        .responsive__tabs ul.scrollable-tabs li {
            list-style-type: none;
        }
        .responsive__tabs ul.scrollable-tabs li a {
            display: inline-block;
            color: rgb(0, 0, 0);
            text-align: center;
            padding: 12px;
            text-decoration: none;
            font-weight: 600;
        }
        .responsive__tabs ul.scrollable-tabs li a:hover, .responsive__tabs ul.scrollable-tabs li a.active {
            background-color: rgb(25, 170, 134);
            color: rgb(255, 255, 255);
        }

        /*.wrapper {*/
        /*    position:relative;*/
        /*    margin:0 auto;*/
        /*    overflow:hidden;*/
        /*    padding:5px;*/
        /*    height:50px;*/
        /*}*/

        /*.list {*/
        /*    position:absolute;*/
        /*    left:0px;*/
        /*    top:0px;*/
        /*    min-width:3000px;*/
        /*    margin-left:12px;*/
        /*    margin-top:0px;*/
        /*}*/

        /*.list li{*/
        /*    display:table-cell;*/
        /*    position:relative;*/
        /*    text-align:center;*/
        /*    cursor:grab;*/
        /*    cursor:-webkit-grab;*/
        /*    color:#efefef;*/
        /*    vertical-align:middle;*/
        /*}*/

        /*.scroller {*/
        /*    text-align:center;*/
        /*    cursor:pointer;*/
        /*    display:none;*/
        /*    padding:7px;*/
        /*    padding-top:11px;*/
        /*    white-space:nowrap;*/
        /*    vertical-align:middle;*/
        /*    background-color:#fff;*/
        /*}*/

        /*.scroller-right{*/
        /*    float:right;*/
        /*}*/

        /*.scroller-left {*/
        /*    float:left;*/
        /*}*/

    </style>
@endpush

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Routine Taskcard'])
        <li class="breadcrumb-item active">
            <a href="/taskcard/routine">Routine Taskcard</a>
        </li>
    @endcomponent
@endsection

@section('content')

    {{-- @can('viewAny', \Modules\HumanResources\Entities\Employee::class)
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
    @endcan --}}

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container responsive__tabs">
{{--                <div class="scroller scroller-left"><i class="glyphicon glyphicon-chevron-left"></i></div>--}}
{{--                <div class="scroller scroller-right"><i class="glyphicon glyphicon-chevron-right"></i></div>--}}
{{--                <div class="wrapper">--}}
{{--                    <ul class="nav nav-tabs list">--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link active" data-toggle="tab" role="tab" href="#employee">Employees</a>--}}
{{--                        </li>--}}
{{--                        @can('viewAny', \Modules\HumanResources\Entities\IdCard::class)--}}
{{--                            <li class="nav-item"><a class="nav-link" aria-controles="idcard" data-toggle="tab" role="tab" href="#idcard">ID Card</a></li>--}}
{{--                        @endcan--}}
{{--                        @can('viewAny', \Modules\HumanResources\Entities\Education::class)--}}
{{--                            <li class="nav-item"><a class="nav-link" aria-controles="education" data-toggle="tab" role="tab" href="#education">Education</a></li>--}}
{{--                        @endcan--}}
{{--                        @can('viewAny', \Modules\HumanResources\Entities\Family::class)--}}
{{--                            <li class="nav-item"><a class="nav-link" aria-controles="family" data-toggle="tab" role="tab" href="#family">Family</a></li>--}}
{{--                        @endcan--}}
{{--                        @can('viewAny', \Modules\HumanResources\Entities\Address::class)--}}
{{--                            <li class="nav-item"><a class="nav-link" aria-controles="address" data-toggle="tab" role="tab" href="#address">Address</a></li>--}}
{{--                        @endcan--}}
{{--                        @can('viewAny', \Modules\HumanResources\Entities\Attendance::class)--}}
{{--                            <li class="nav-item"><a class="nav-link" aria-controles="attendance" data-toggle="tab" role="tab" href="#attendance">Attendance</a></li>--}}
{{--                        @endcan--}}
{{--                    </ul>--}}
{{--                </div>--}}
                <ul class="scrollable-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#employee">Employees</a>
                    </li>
                    @can('viewAny', \Modules\HumanResources\Entities\IdCard::class)
                        <li class="nav-item"><a class="nav-item nav-link" aria-controles="idcard" data-toggle="tab" role="tab" href="#idcard">ID Card</a></li>
                    @endcan
                    @can('viewAny', \Modules\HumanResources\Entities\Education::class)
                        <li class="nav-item"><a class="nav-item nav-link" aria-controles="education" data-toggle="tab" role="tab" href="#education">Education</a></li>
                    @endcan
                    @can('viewAny', \Modules\HumanResources\Entities\Family::class)
                        <li class="nav-item"><a class="nav-item nav-link" aria-controles="family" data-toggle="tab" role="tab" href="#family">Family</a></li>
                    @endcan
                    @can('viewAny', \Modules\HumanResources\Entities\Address::class)
                        <li class="nav-item"><a class="nav-item nav-link" aria-controles="address" data-toggle="tab" role="tab" href="#address">Address</a></li>
                    @endcan
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="employee" class="tab-pane container fade show active">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">Employee data</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer" id="ibox-employee">
                                <div id="form_result" role="alert"></div>
                                <div class="col-md-1 m-2 p-1 row">
                                    @can('create', \Modules\HumanResources\Entities\Employee::class)
                                        <button type="button" id="create-employee" class="btn btn-block btn-primary"><strong><i class="fa fa-plus"></i></strong></button>
                                    @endcan
                                </div>
                                <div class="table-responsive">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="idcard" class="tab-pane fade" role="tabpanel">
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
                    <div role="tabpanel" id="education" class="tab-pane fade" role="tabpanel">
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
                    <div role="tabpanel" id="family" class="tab-pane fade" role="tabpanel">
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
                    <div role="tabpanel" id="address" class="tab-pane fade" role="tabpanel">
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

                </div>
            </div>

        </div>
    </div>

    @push('footer-scripts')
        <script>
            $('.tabs-container').on('click', 'li', function() {
                $('.scrollable-tabs li a.active').removeClass('active');
                $(this).addClass('active');
            });

            // var hidWidth;
            // var scrollBarWidths = 40;
            //
            // var widthOfList = function(){
            //     let itemsWidth = 0;
            //     $('.list li').each(function(){
            //         let itemWidth = $(this).outerWidth();
            //         itemsWidth+=itemWidth;
            //     });
            //     return itemsWidth;
            // };
            //
            // var widthOfHidden = function(){
            //     return (($('.wrapper').outerWidth())-widthOfList()-getLeftPosi())-scrollBarWidths;
            // };
            //
            // var getLeftPosi = function(){
            //     return $('.list').position().left;
            // };
            //
            // var reAdjust = function(){
            //     if (($('.wrapper').outerWidth()) < widthOfList()) {
            //         $('.scroller-right').show();
            //     }
            //     else {
            //         $('.scroller-right').hide();
            //     }
            //
            //     if (getLeftPosi()<0) {
            //         $('.scroller-left').show();
            //     }
            //     else {
            //         $('.item').animate({left:"-="+getLeftPosi()+"px"},'slow');
            //         $('.scroller-left').hide();
            //     }
            // }
            //
            // reAdjust();
            //
            // $(window).on('resize',function(e){
            //     reAdjust();
            // });
            //
            // $('.scroller-right').click(function() {
            //
            //     $('.scroller-left').fadeIn('slow');
            //     $('.scroller-right').fadeOut('slow');
            //
            //     $('.list').animate({left:"+="+widthOfHidden()+"px"},'slow',function(){
            //
            //     });
            // });
            //
            // $('.scroller-left').click(function() {
            //
            //     $('.scroller-right').fadeIn('slow');
            //     $('.scroller-left').fadeOut('slow');
            //
            //     $('.list').animate({left:"-="+getLeftPosi()+"px"},'slow',function(){
            //
            //     });
            // });
        </script>
    @endpush

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
    @endcan

@endsection
