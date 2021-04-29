<div class="row m-b fadeIn animate-md">
    <div class="col">
        <ol>
            <li>This aircraft configuration and it's properties, won't shown up in any transaction (so you still can't use this aircraft) and reporting form until it approved</li>
            <li>Once this aircraft configuration approved, any changes in this page won't be available any more</li>
            <li>You have to use specific transactional form for any modification (ex: item transfer, item adding, item removal, etc) after approval, for auditable reason</li>
        </ol>
    </div>
</div>

<div class="row m-b fadeIn animate-md">
    <div class="col-md-4">
        <div class="panel panel-primary h-100">
            <div class="panel-heading">
                <i class="fa fa-info-circle"></i> &nbsp;Current Approval Status
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-10">
                        <p class="m-b-none">Approved by:</p>
                        <p><strong>{{ $AircraftConfiguration->approvals->first()->creator->name ?? 'Not Yet Approved' }}</strong></p>
                        
                        <p class="m-b-none">Approved Date:</p>
                        <p><strong>{{ $AircraftConfiguration->approvals->first()->created_at ?? 'Not Yet Approved' }}</strong></p>
                    </div>
                    <div class="col-md-2 p-r-xl">
                        <i class="text-success fa fa-check-circle-o fa-3x fw"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($AircraftConfiguration->approvals()->count() == 0)
        @can('approval', Modules\PPC\Entities\AircraftConfiguration::class)
            @component('components.approve-modal', ['name' => 'Aircraft Configuration Datalist'])
            @endcomponent

            <div class="col-md-4">
                <button type="button" class="approveBtn btn btn-lg btn-outline btn-success" data-toggle="tooltip" title="Approve"
                    value="{{ $AircraftConfiguration->id }}">
                    <i class="fa fa-check-circle"></i>&nbsp;Approve Now
                </button>
            </div>
        @endcan
    @endif
</div>