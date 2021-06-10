<div class="col-md-12 m-t-md fadeIn" style="animation-duration: 1.5s">
        @component('components.crud-form.index',[
                        'title' => 'Available Task Card for this Aircraft Maintenance Program',
                        'tableId' => 'aircraft-maintenance-program-table'])

                @slot('createButton')
                    @can('update', $work_order)                
                        <button type="button" class="useBtnAllMaintenanceProgram btn btn-sm btn-outline btn-success text-nowrap pr-2" data-toggle="tooltip" title="Use All" value="{{ $work_order->id }}">
                            <i class="fa fa-check-square-o"></i> Use All
                        </button>
                    @endcan
                @endslot
        @endcomponent
</div>

@include('ppc::pages.work-order.aircraft-maintenance-program.modal')

@push('footer-scripts')
    @include('ppc::components.work-order.aircraft-maintenance-program._script')
@endpush