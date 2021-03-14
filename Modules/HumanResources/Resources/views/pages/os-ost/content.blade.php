<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Organization Struture Datalist'])
    @endcomponent

    @include('humanresources::pages.os-ost.os-modal')

        <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title ribbon ribbon-left">
                    <div class="ribbon-target" style="top: 6px;">
                        @can('create', \Modules\HumanResources\Entities\OrganizationStructure::class)
                            <button type="button" id="createOS" class="btn btn-info btn-lg">
                                <i class="fa fa-plus-square"></i> Add Header Structure
                            </button>
                        @endcan
                    </div>
                    <h4 class="text-center">Organization Struture Datalist</h4>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="fullscreen-link">
                            <i class="fa fa-expand"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div id="TreeGrid"></div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('humanresources::components.os._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    <script>
        var ele = document.getElementById('container');
        if(ele) {
            ele.style.visibility = "visible";
        }
    </script>
    @include('layouts.includes._footer-datatable-script')
@endpush

