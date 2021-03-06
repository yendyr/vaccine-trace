<div class="col-md-12 m-t-md fadeIn" style="animation-duration: 1.5s">
@component('components.delete-modal', ['name' => 'Work Package Datalist'])
    @endcomponent
    
        @component('components.crud-form.index',[
                        'title' => 'Work Package list on this project',
                        'tableId' => 'work-package-table'])

            @slot('createButton')
                @can('update', $work_order->id)                
                    <button type="button" id="create" class="btn btn-primary btn-lg">
                        <i class="fa fa-plus-circle"></i>&nbsp;Create New
                    </button>   
                @endcan
            @endslot 

        @endcomponent

    @include('ppc::components.work-order.work-package-list._script')
</div>

@include('ppc::pages.work-order.work-package.modal')
