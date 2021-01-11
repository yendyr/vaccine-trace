@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-3">        
        <span style="font-size: 18px; font-weight: 200;">Current Grouping Structure Tree</span><br>
        <span style="font-weight: 200;"><i>Refresh Page to Update View</i></span>
        <br><br><br>
        @if ($parentGroup)
            @foreach($parentGroup as $taxonomy)
            <ul>
                <li>                    
                    {{ $taxonomy->name }}                    
                </li>
                @if(count($taxonomy->subGroup))
                    @include('ppc::pages.taskcard-group.sub-group', ['subGroups' => $taxonomy->subGroup])
                @endif
            </ul>
            @endforeach 
        @endif              
    </div>
    <div class="col-lg-9">
        @component('components.delete-modal', ['name' => 'Task Card Group Datalist'])
        @endcomponent

        @include('ppc::pages.taskcard-group.modal')

        @component('components.crud-form.index',[
                        'title' => 'Task Card Group Datalist',
                        'tableId' => 'taskcard-group-table'])

            @slot('createButton')
                @can('create', Modules\PPC\Entities\TaskcardGroup::class)                
                    <button type="button" id="create" class="btn btn-primary btn-lg">
                        <i class="fa fa-plus-circle"></i>&nbsp;Create New
                    </button>   
                @endcan
            @endslot    

            @slot('tableContent')
                <th>Code</th>
                <th>Task Card Group Name</th>
                <th>Parent Group Name</th>
                <th>Description/Remark</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Last Updated By</th>
                <th>Last Updated At</th>
                <th>Action</th>
            @endslot
        @endcomponent

        @include('ppc::components.taskcard-group._script')
    </div>
</div>
@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush