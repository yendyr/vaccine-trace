<div class="col-md-4 fadeIn animate-md">
    <div class="panel panel-primary h-100">
        <div class="panel-heading">
            <i class="fa fa-info-circle"></i> &nbsp;Current Approval Status
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10">
                    <p class="m-b-none">Approved by:</p>
                    <p><strong>{{ $afmlog->approvals->first()->creator->name ?? 'Not Yet Approved' }}</strong></p>
                    
                    <p class="m-b-none">Approved Date:</p>
                    <p><strong>{{ $afmlog->approvals->first()->created_at ?? 'Not Yet Approved' }}</strong></p>
                </div>
                <div class="col-md-2 p-r-xl">
                    <i class="text-success fa fa-check-circle-o fa-3x fw"></i>
                </div>
            </div>
        </div>
    </div>
</div>

@if($afmlog->approvals()->count() == 0)
    @can('approval', Modules\FlightOperations\Entities\AfmLog::class)
        @component('components.approve-modal', ['name' => 'AFML Datalist'])
        @endcomponent

        <div class="col-md-4">
            <button type="button" class="approveBtn btn btn-lg btn-outline btn-success" data-toggle="tooltip" title="Approve"
                value="{{ $afmlog->id }}">
                <i class="fa fa-check-circle"></i>&nbsp;Approve Now
            </button>
        </div>

        @include('flightoperations::components.afmlog.approval-status._script')
    @endcan
@endif