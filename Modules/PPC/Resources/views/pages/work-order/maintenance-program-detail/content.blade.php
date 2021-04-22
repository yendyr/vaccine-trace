<div class="col-md-12 m-t-md fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Maintenance Program Datalist'])
    @endcomponent

    @component('components.crud-form.index',[
                    'title' => "Selected Maintenance Program's Task Card",
                    'tableId' => 'maintenance-program-table'])
    @endcomponent
</div>