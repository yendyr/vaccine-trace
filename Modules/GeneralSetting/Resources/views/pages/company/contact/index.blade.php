@component('components.delete-modal', ['name' => 'Contact Datalist'])
@endcomponent

@include('generalsetting::pages.company.contact.modal')

@component('components.crud-form.index',[
                'title' => 'Contact Datalist',
                'tableId' => 'company-contact-table'])

    @slot('createButton')
        @can('create', Modules\GeneralSetting\Entities\CompanyDetailContact::class)                
            <button type="button" id="create" class="btn btn-primary btn-lg">
                <i class="fa fa-plus-circle"></i>&nbsp;Create New
            </button>   
        @endcan
    @endslot    

    @slot('tableContent')
        <th>Label</th>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile Number</th>
        <th>Office Number</th>
        <th>Fax Number</th>
        <th>Other Number</th>
        <th>Website</th>
        <th>Status</th>
        <th>Created By</th>
        <th>Created At</th>
        <th>Last Updated By</th>
        <th>Last Updated At</th>
        <th>Action</th>            
    @endslot
@endcomponent