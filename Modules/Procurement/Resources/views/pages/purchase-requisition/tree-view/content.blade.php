<div class="col m-t-md fadeIn" style="animation-duration: 1.5s">
    <div id="tree_view">

    </div>
</div>

@include('procurement::components.purchase-requisition.tree-view-content._script')
@push('header-scripts')
<link href="{{ URL::asset('theme/css/plugins/jsTree/proton/style.min.css') }}" rel="stylesheet">
@endpush