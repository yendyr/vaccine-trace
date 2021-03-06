@extends('layouts.master')

@section('content')
<div class="row">
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

    <div class="col-lg-3">        
        <span style="font-size: 18px; font-weight: 200;">Current Grouping Structure Tree</span><br>
        <span style="font-weight: 200;">
            <i class="fa fa-info-circle"></i>
            <i>Refresh Page to Update View</i>
        </span>
        <br><br>

        {{-- @if ($parentGroup)
        <div class="dd" id="nestable2">
            @foreach($parentGroup as $taxonomy)
            <ol class="dd-list">
                <li class="dd-item"> 
                    <button data-action="collapse" type="button" style="">Collapse</button>
                    <button data-action="expand" type="button" style="display: none;">Expand</button>
                    <div class="dd-handle">                   
                        {{ $taxonomy->name }} 
                    </div>                   
                </li>
                @if(count($taxonomy->subGroup))
                    @include('ppc::pages.taskcard-group.sub-group', ['subGroups' => $taxonomy->subGroup])
                @endif
            </ol>
            @endforeach 
        </div>
        @endif               --}}
        <div id="tree_view">

        </div>
    </div>
</div>
@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
    @include('ppc::components.taskcard-group._tree-script')
    <link href="{{ URL::asset('theme/css/plugins/jsTree/proton/style.min.css') }}" rel="stylesheet">
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
    <!-- Nestable Script -->
    {{-- <script src="{{ URL::asset('theme/js/plugins/nestable/jquery.nestable.js') }}"></script>
    <script>
        $(document).ready(function(){

        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target),
                    output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };
        
        // activate Nestable for list 2
        // $('#nestable2').nestable({
        //     group: 1
        // }).on('change', updateOutput);

        // output initial serialised data
        // updateOutput($('#nestable2').data('output', $('#nestable2-output')));

        // $('#nestable-menu').on('click', function (e) {
        //     var target = $(e.target),
        //             action = target.data('action');
        //     if (action === 'expand-all') {
        //         $('.dd').nestable('expandAll');
        //     }
        //     if (action === 'collapse-all') {
        //         $('.dd').nestable('collapseAll');
        //     }
        // });
        });
    </script> --}}
@endpush