<div class="col-md-12 m-t-md fadeIn" style="animation-duration: 1.5s">
        @component('components.crud-form.index',[
                        'title' => 'Available Master Task Card for this Aircraft Type',
                        'tableId' => 'taskcard-table'])
        @endcomponent

    @include('ppc::components.work-order.taskcard-list._script')
</div>