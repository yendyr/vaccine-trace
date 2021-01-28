<div class="ibox full-height">
    <div class="ibox-title">
        <h4 class="text-center">Item Requirement</h4> 
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
        <div class="table-responsive" style="font-size: 9pt;">
            <table id="{{ $instruction_detail->id ?? '-' }}" class="perInstructionItem table table-hover table-striped text-center" style="width:100%">
                <thead>
                    <tr>
                        <th style="font-weight: normal;">Code</th>
                        <th style="font-weight: normal;">Item Name</th>
                        <th style="font-weight: normal;">Qty</th>
                        <th style="font-weight: normal;">Unit</th>
                        <th style="font-weight: normal;">Category</th>
                        <th style="font-weight: normal;">Remark</th>
                        @can('update', Modules\PPC\Entities\Taskcard::class)
                            <th style="font-weight: normal;">Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @if (sizeOf($instruction_detail->item_details) > 0)
                    @foreach ($instruction_detail->item_details as $item_detail)
                    <tr>
                        <td>{{ $item_detail->item->code ?? '' }}</td>
                        <td>{{ $item_detail->item->name ?? '' }}</td>
                        <td>{{ $item_detail->quantity ?? '' }}</td>
                        <td>{{ $item_detail->unit->name ?? '' }}</td>
                        <td>{{ $item_detail->category->name ?? '' }}</td>
                        <td>{{ $item_detail->description ?? '' }}</td>
                        <td>
                        @can('update', Modules\PPC\Entities\Taskcard::class)                
                        <button class="editButtonItem btn btn-sm btn-outline btn-primary" 
                        data-toggle="tooltip" data-id="{{ $item_detail->id ?? '' }}" title="Update">
                        <i class="fa fa-edit"></i></button>

                        <button type="button" name="delete" class="deleteButtonItem btn btn-sm btn-outline btn-danger" data-toggle="tooltip" title="Delete"
                        value="{{ $item_detail->id ?? '' }}">
                        <i class="fa fa-trash"></i></button>  
                        @endcan 
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div> 
    </div>
    <div class="ibox-footer text-center">
        @can('update', Modules\PPC\Entities\Taskcard::class)                
        <button type="button" class="createNewButtonItem btn btn-primary btn-xs" data-taskcard_detail_instruction_id="{{ $instruction_detail->id ?? '' }}">
            <i class="fa fa-plus-circle"></i>&nbsp;Add
        </button>   
        @endcan 

        @include('ppc::pages.taskcard.instruction.item-modal')
    </div>
</div>