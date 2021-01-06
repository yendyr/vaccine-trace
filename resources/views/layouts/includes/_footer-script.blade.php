{{-- Laravel Mix - JS File --}}
{{-- <script src="{{ mix('js/gate.js') }}"></script> --}}
    <!-- Mainly scripts -->
    <script src="{{URL::asset('theme/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{URL::asset('theme/js/popper.min.js')}}"></script>
    <script src="{{URL::asset('theme/js/bootstrap.js')}}"></script>
    <script src="{{URL::asset('theme/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{URL::asset('theme/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{URL::asset('theme/js/inspinia.js')}}"></script>
    <script src="{{URL::asset('theme/js/plugins/pace/pace.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{URL::asset('theme/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- Sweet Alert -->
    <script src="{{URL::asset('theme/js/plugins/sweetalert/sweetalert.min.js')}}"></script>
{{--    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
{{--        <link rel="stylesheet" href="sweetalert2.min.css">--}}

    <!-- Ladda -->
    <script src="{{URL::asset('theme/js/plugins/ladda/spin.min.js')}}"></script>
    <script src="{{URL::asset('theme/js/plugins/ladda/ladda.min.js')}}"></script>
    <script src="{{URL::asset('theme/js/plugins/ladda/ladda.jquery.min.js')}}"></script>

    <!-- Select2 -->
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>--}}
        <script src="{{URL::asset('theme/js/plugins/select2/select2.full.min.js')}}"></script>

<script>
    $(window).bind("scroll", function () {
        let toast = $('.toast');
        toast.css("top", window.pageYOffset + 20);

    });
</script>