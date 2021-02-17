<div class="col-md-12 m-t-md fadeIn" style="animation-duration: 1.5s">
    <div id="taskcard-list-box">

    </div>
</div>

@include('ppc::components.maintenance-program.taskcard-list._script')
@push('header-scripts')
    <link href="{{ URL::asset('theme/css/plugins/dualListbox/icon_font/css/icon_font.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('theme/css/plugins/dualListbox/jquery.transfer.css') }}" rel="stylesheet">
@endpush