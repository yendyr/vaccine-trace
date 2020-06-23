{{-- Laravel Mix - JS File --}}
{{-- <script src="{{ mix('js/gate.js') }}"></script> --}}
    <!-- Mainly scripts -->
    <script src="{{URL::asset('theme/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{URL::asset('theme/js/popper.min.js')}}"></script>
    <script src="{{URL::asset('theme/js/bootstrap.js')}}"></script>
    <script src="{{URL::asset('theme/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{URL::asset('theme/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Flot -->
{{--    <script src="{{URL::asset('theme/js/plugins/flot/jquery.flot.js')}}"></script>--}}
{{--    <script src="{{URL::asset('theme/js/plugins/flot/jquery.flot.tooltip.min.js')}}"></script>--}}
{{--    <script src="{{URL::asset('theme/js/plugins/flot/jquery.flot.spline.js')}}"></script>--}}
{{--    <script src="{{URL::asset('theme/js/plugins/flot/jquery.flot.resize.js')}}"></script>--}}
{{--    <script src="{{URL::asset('theme/js/plugins/flot/jquery.flot.pie.js')}}"></script>--}}

{{--    <!-- Peity -->--}}
{{--    <script src="{{URL::asset('theme/js/plugins/peity/jquery.peity.min.js')}}"></script>--}}
{{--    <script src="{{URL::asset('theme/js/demo/peity-demo.js')}}"></script>--}}

    <!-- Custom and plugin javascript -->
    <script src="{{URL::asset('theme/js/inspinia.js')}}"></script>
    <script src="{{URL::asset('theme/js/plugins/pace/pace.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{URL::asset('theme/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

{{--    <!-- GITTER -->--}}
{{--    <script src="{{URL::asset('theme/js/plugins/gritter/jquery.gritter.min.js')}}"></script>--}}

{{--    <!-- Sparkline -->--}}
{{--    <script src="{{URL::asset('theme/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>--}}

{{--    <!-- Sparkline demo data  -->--}}
{{--    <script src="{{URL::asset('theme/js/demo/sparkline-demo.js')}}"></script>--}}

{{--    <!-- ChartJS-->--}}
{{--    <script src="{{URL::asset('theme/js/plugins/chartJs/Chart.min.js')}}"></script>--}}

{{--    <!-- Toastr -->--}}
{{--    <script src="{{URL::asset('theme/js/plugins/toastr/toastr.min.js')}}"></script>--}}


    <!-- Data Foo Table-->
    <script src="{{URL::asset('theme/js/plugins/footable/footable.all.min.js')}}"></script>
    <script>
        $(document).ready(function() {

            $('.footable').footable();
            $('.footable2').footable();

        });
    </script>

    <script>
        $(window).bind("scroll", function () {
            let toast = $('.toast');
            toast.css("top", window.pageYOffset + 20);

        });
    </script>
