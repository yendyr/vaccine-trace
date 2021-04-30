<div class="col-md-12 m-t-md fadeIn" style="animation-duration: 1.5s">
        @component('components.crud-form.index',[
                        'title' => 'Available Master Task Card for this Aircraft Type',
                        'tableId' => 'taskcard-table'])

                @slot('createButton')
                    @can('update', $work_order)                
                        <button type="button" class="useBtnAll btn btn-sm btn-outline btn-success text-nowrap pr-2" data-toggle="tooltip" title="Use All" value="{{ $work_order->id }}">
                            <i class="fa fa-check-square-o"></i>Use All
                        </button>
                    @endcan
                @endslot
        @endcomponent

    @include('ppc::components.work-order.taskcard-list._script')
</div>