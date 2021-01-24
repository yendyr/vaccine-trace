@if (sizeOf($Taskcard->instruction_details) > 0)
@foreach ($Taskcard->instruction_details as $instruction_detail)
<div class="col-md-12 fadeIn" style="animation-duration: 1.5s">
    <div class="panel panel-default">
        <div class="panel-heading">
            Instruction Sequence: <label class="label label-success">{{ $instruction_detail->sequence ?? '-' }}</label>
        </div>
        <div class="panel-body" style="margin: 0px; width: 100%; padding-bottom: 0;">
            <div class="row">
                <div class="col-md-3 m-b">Work Area: <strong>{{ $instruction_detail->taskcard_workarea->name ?? '-' }}</strong></div>
                <div class="col-md-3 m-b">Manhours Estimation: <strong>{{ $instruction_detail->manhours_estimation ?? '-' }}</strong></div>
                <div class="col-md-3 m-b">Performance Factor: <strong>{{ $instruction_detail->performance_factor ?? '-' }}</strong></div>
                <div class="col-md-3 m-b">Minimum Authorized Engineering Level: <strong>{{ $instruction_detail->engineering_level->name ?? '-' }}</strong></div>
                <div class="col-md-3 m-b">Manpower Quantity: <strong>{{ $instruction_detail->manpower_quantity ?? '-' }}</strong></div>
                <div class="col-md-3 m-b">Task Release Level: <strong>{{ $instruction_detail->task_release_level->name ?? '-' }}</strong></div>
                <div class="col-md-6 m-b">Skill Requirement: 
                    @if (sizeOf($instruction_detail->skills) > 0)
                    @foreach ($instruction_detail->skills as $skill)
                        <label class="label label-success">{{ $skill->name }}</label>
                    @endforeach
                    @endif
                </div>
                <div class="col-md-12">Instruction:</div>
                <div class="col-md-12 m-b">
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