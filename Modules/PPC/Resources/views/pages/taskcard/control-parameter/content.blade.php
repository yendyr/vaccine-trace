<div class="col-md-6 fadeIn" style="animation-duration: 1.5s">
    <div class="panel panel-danger">
        <div class="panel-heading">
            Threshold
        </div>
        <div class="panel-body" style="margin: 0px; width: 100%; padding-bottom: 0;">
            <div class="row">
                <div class="col-md-9 m-b m-l-n">
                    <div class="col">After Flight Hour (FH):</div>
                    <div class="col m-b"><h3>{{ $Taskcard->threshold_flight_hour ?? '-' }} FH</h3></div>
                    <div class="col">After Flight Cycle (FC):</div>
                    <div class="col m-b"><h3>{{ $Taskcard->threshold_flight_cycle ?? '-' }} FC</h3></div>
                    <div class="col">After Daily Basis:</div>
                    <div class="col m-b"><h3>{{ $Taskcard->threshold_daily ?? '-' }} {{ $Taskcard->threshold_daily_unit ?? '' }}(s)</h3></div>
                    <div class="col">After Exact Calendar Date:</div>
                    <div class="col m-b"><h3>{{ Carbon\Carbon::parse($Taskcard->threshold_date)->format('Y-F-d') ?? '-' }}</h3></div>
                </div>
                <div class="col-md-3 m-b">
                    <i class="text-danger fa fa-sign-in fa-5x"></i>
                </div>
            </div>
        </div>
        @can('update', Modules\PPC\Entities\Taskcard::class)
            <div class="panel-footer">
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="editButtonInterval btn btn-sm btn-outline btn-primary" 
                        data-toggle="tooltip" data-id="{{ $Taskcard->id ?? '' }}" title="Update">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                        </button>
                    </div>
                </div>
            </div>
        @endcan
    </div>
</div>

<div class="col-md-6 fadeIn" style="animation-duration: 1.5s">
    <div class="panel panel-danger">
        <div class="panel-heading">
            Repeat
        </div>
        <div class="panel-body" style="margin: 0px; width: 100%; padding-bottom: 0;">
            <div class="row">
                <div class="col-md-9 m-b m-l-n">
                    <div class="col">After Flight Hour (FH):</div>
                    <div class="col m-b"><h3>{{ $Taskcard->repeat_flight_hour ?? '-' }} FH</h3></div>
                    <div class="col">After Flight Cycle (FC):</div>
                    <div class="col m-b"><h3>{{ $Taskcard->repeat_flight_cycle ?? '-' }} FC</h3></div>
                    <div class="col">After Daily Basis:</div>
                    <div class="col m-b"><h3>{{ $Taskcard->repeat_daily ?? '-' }} {{ $Taskcard->repeat_daily_unit ?? '' }}(s)</h3></div>
                    <div class="col">After Exact Calendar Date:</div>
                    <div class="col m-b"><h3>{{ Carbon\Carbon::parse($Taskcard->repeat_date)->format('Y-F-d') ?? '-' }}</h3></div>
                </div>
                <div class="col-md-3 m-b">
                    <i class="text-danger fa fa-refresh fa-5x"></i>
                </div>
            </div>
        </div>
        @can('update', Modules\PPC\Entities\Taskcard::class)
            <div class="panel-footer">
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="editButtonInterval btn btn-sm btn-outline btn-primary" 
                        data-toggle="tooltip" data-id="{{ $Taskcard->id ?? '' }}" title="Update">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                        </button>
                    </div>
                </div>
            </div>
        @endcan
    </div>
</div>