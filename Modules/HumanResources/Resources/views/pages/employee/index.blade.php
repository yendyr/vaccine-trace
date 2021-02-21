@extends('layouts.master')

@push('header-scripts')
    <style>

    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" id="myTab">
                    <li>
                        <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-1" style="min-height: 50px;" id="tab-employee">
                            <i class="fa fa-user-circle fa-2x text-warning"></i>&nbsp;Employee
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 50px;" id="tab-idcard">
                            <i class="fa fa-id-card-o fa-2x text-warning"></i>&nbsp;ID Card
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-3" style="min-height: 50px;" id="tab-education">
                            <i class="fa fa-mortar-board fa-2x text-warning"></i>&nbsp;Education
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-4" style="min-height: 50px;" id="tab-family">
                            <i class="fa fa-users fa-2x text-warning"></i>&nbsp;Family
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-5" style="min-height: 50px;" id="tab-address">
                            <i class="fa fa-address-book fa-2x text-warning"></i>&nbsp;Address
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('humanresources::pages.employee.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('humanresources::pages.employee.idcard.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('humanresources::pages.employee.education.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('humanresources::pages.employee.family.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-5" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('humanresources::pages.employee.address.content')
                            </div>
                        </div>
                    </div>
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
        // $('.tabs-container').on('click', 'li', function() {
        //     $('.scrollable-tabs li a.active').removeClass('active');
        //     $(this).addClass('active');
        // });

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
