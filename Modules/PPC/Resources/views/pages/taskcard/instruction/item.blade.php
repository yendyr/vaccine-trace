@if (sizeOf($Taskcard->instruction_details) > 0)
@foreach ($Taskcard->instruction_details->sortBy('sequence') as $instruction_detail)
<div class="col-md-12 fadeIn" style="animation-duration: 1.5s">
    <div class="panel panel-success">
        <div class="panel-heading">
            Instruction Sequence: <label class="label label-danger m-b-none">{{ $instruction_detail->sequence ?? '-' }}</label>
        </div>
        <div class="panel-body" style="margin: 0px; width: 100%;">
            <div class="row">
                <div class="col-md-3 p-xs border">Work Area: <p class="m-b-xs"><strong>{{ $instruction_detail->taskcard_workarea->name ?? '-' }}</strong></p></div>
                <div class="col-md-3 p-xs border">Manhours Estimation: <p class="m-b-xs"><strong>{{ $instruction_detail->manhours_estimation ?? '-' }}</strong></p></div>
                <div class="col-md-3 p-xs border">Performance Factor: <p class="m-b-xs"><strong>{{ $instruction_detail->performance_factor ?? '-' }}</strong></p></div>
                <div class="col-md-3 p-xs border">Minimum Engineering Level: <p class="m-b-xs"><strong>{{ $instruction_detail->engineering_level->name ?? '-' }}</strong></p></div>
                <div class="col-md-3 p-xs border">Manpower Quantity: <p class="m-b-xs"><strong>{{ $instruction_detail->manpower_quantity ?? '-' }}</strong></p></div>
                <div class="col-md-3 p-xs border">Task Release Level: <p class="m-b-xs"><strong>{{ $instruction_detail->task_release_level->name ?? '-' }}</strong></p></div>
                <div class="col-md-6 p-xs border">Skill Requirement: 
                    @if (sizeOf($instruction_detail->skills) > 0)
                    <p class="m-b-xs">
                    @foreach ($instruction_detail->skills as $skill)
                        <label class="label label-success m-b-none">{{ $skill->name }}</label>
                    @endforeach
                    </p>
                    @endif
                </div>
                <div class="col-md-12 p-xs text-center">--- INSTRUCTION/TASK: ---</div>
                <div class="col-md-12 p-xs border">
                    @if ($instruction_detail->instruction)
                        {!! $instruction_detail->instruction !!}
                    @endif
                </div>
            </div>
        </div>
        @can('update', Modules\PPC\Entities\Taskcard::class)
            <div class="panel-footer">
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="editButtonInstruction btn btn-sm btn-outline btn-primary" 
                        data-toggle="tooltip" data-id="{{ $instruction_detail->id ?? '' }}" title="Update">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                        </button>

                        @include('components.delete-modal', 
                                ['deleteModalId' => 'deleteModalInstruction',
                                'deleteFormId' => 'deleteFormInstruction',
                                'deleteModalButtonId' => 'deleteModalButtonInstruction'])

                        <button type="button" name="delete" class="deleteButtonInstruction btn btn-sm btn-outline btn-danger" data-toggle="tooltip" title="Delete"
                        value="{{ $instruction_detail->id ?? '' }}">
                            <i class="fa fa-trash"></i>&nbsp;Delete
                        </button>
                    </div>
                </div>
            </div>
        @endcan
    </div>
</div>
@endforeach
@else 
    <div class="col-md-12 m-t-xl">
        <p class="font-italic text-center m-t-xl">No Data Found</p>
    </div>
@endif