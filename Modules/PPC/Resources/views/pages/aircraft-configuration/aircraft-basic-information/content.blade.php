<div class="col-md-12 m-t-md fadeIn" style="animation-duration: 1.5s">
    <div class="panel panel-danger">
        <div class="panel-heading">
            <i class="fa fa-paw"></i> &nbsp;Initial Aircraft Life Aging Count
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <p class="m-b-none">Initial Flight Hour:</p>
                    <h2 class="m-t-none"><strong>{{ $AircraftConfiguration->initial_flight_hour ?? '-' }} FH</strong></h2>
                </div>
                <div class="col-md-2">
                    <p class="m-b-none">Initial Flight Cycle:</p>
                    <h2 class="m-t-none"><strong>{{ $AircraftConfiguration->initial_flight_cycle ?? '-' }} FC</strong></h2>
                </div>
                <div class="col-md-2">
                    <p class="m-b-none">Initial Flight Event:</p>
                    <h2 class="m-t-none"><strong>{{ $AircraftConfiguration->initial_flight_event ?? '-' }} Event(s)</strong></h2>
                </div>
                <div class="col-md-5">
                    <p class="m-b-none">Initial Start Operation Date:</p>
                    <h2 class="m-t-none"><strong>{{ Carbon\Carbon::parse($AircraftConfiguration->initial_start_date)->format('Y-F-d') ?? '-' }} </strong></h2>
                </div>
                <div class="col-md-1 p-r-xl">
                    <i class="text-danger fa fa-recycle fa-3x fw"></i>
                </div>
            </div>
        </div>

        @if($AircraftConfiguration->approvals()->count() == 0)
        @can('update', Modules\PPC\Entities\AircraftConfiguration::class)
            <div class="panel-footer">
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="editButtonAircraftConfiguration btn btn-sm btn-outline btn-primary" 
                        data-toggle="tooltip" data-id="{{ $AircraftConfiguration->id ?? '' }}" title="Update">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                        </button>
                    </div>
                </div>
            </div>

            @include('ppc::pages.aircraft-configuration.aircraft-basic-information.modal')
            @include('ppc::components.aircraft-configuration.aircraft-basic-information._script')
        @endcan
        @endif
    </div>
</div>

<div class="col-md-3 m-t-md fadeIn" style="animation-duration: 1.5s">
    <div class="panel panel-primary h-100">
        <div class="panel-heading">
            <i class="fa fa-life-ring"></i> &nbsp;General
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10">
                    <p class="m-b-none">Manufactured Date:</p>
                    <p><strong>{{ $AircraftConfiguration->manufactured_date ?? '-' }}</strong></p>
                    
                    <p class="m-b-none">Received Date:</p>
                    <p><strong>{{ $AircraftConfiguration->received_date ?? '-' }}</strong></p>
                </div>
                <div class="col-md-2 p-0">
                    <i class="text-success fa fa-info-circle fa-3x fw"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3 m-t-md fadeIn" style="animation-duration: 1.5s">
    <div class="panel panel-primary h-100">
        <div class="panel-heading">
            <i class="fa fa-inbox"></i> &nbsp;Operation Weight and Balance
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10">
                    <p class="m-b-none">Maximum Take-Off Weight:</p>
                    <p><strong>{{ $AircraftConfiguration->max_takeoff_weight ?? '-' }} {{ $AircraftConfiguration->max_takeoff_weight_unit->name ?? '-' }}(s)</strong></p>
                    
                    <p class="m-b-none">Maximum Landing Weight:</p>
                    <p><strong>{{ $AircraftConfiguration->max_landing_weight ?? '-' }} {{ $AircraftConfiguration->max_landing_weight_unit->name ?? '-' }}(s)</strong></p>

                    <p class="m-b-none">Maximum Zero Fuel Weight (ZFW):</p>
                    <p><strong>{{ $AircraftConfiguration->max_zero_fuel_weight ?? '-' }} {{ $AircraftConfiguration->max_zero_fuel_weight_unit->name ?? '-' }}(s)</strong></p>
                </div>
                <div class="col-md-2 p-0">
                    <i class="text-success fa fa-inbox fa-3x fw"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3 m-t-md fadeIn" style="animation-duration: 1.5s">
    <div class="panel panel-primary h-100">
        <div class="panel-heading">
            <i class="fa fa-signal"></i> &nbsp;Capacity
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10">
                    <p class="m-b-none">Fuel Capacity:</p>
                    <p><strong>{{ $AircraftConfiguration->fuel_capacity ?? '-' }} {{ $AircraftConfiguration->fuel_capacity_unit->name ?? '-' }}(s)</strong></p>
                    
                    <p class="m-b-none">Basic Empty Weight (BEW):</p>
                    <p><strong>{{ $AircraftConfiguration->basic_empty_weight ?? '-' }} {{ $AircraftConfiguration->basic_empty_weight_unit->name ?? '-' }}(s)</strong></p>
                </div>
                <div class="col-md-2 p-0">
                    <i class="text-success fa fa-signal fa-3x fw"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3 m-t-md fadeIn" style="animation-duration: 1.5s">
    <div class="panel panel-primary h-100">
        <div class="panel-heading">
            <i class="fa fa-rub"></i> &nbsp;Maintenance Program
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10">
                    <p class="m-b-none">Code:</p>
                    <p><strong>{{ $AircraftConfiguration->maintenance_program->code ?? '-' }}</strong></p>
                    
                    <p class="m-b-none">Name:</p>
                    <p><strong>{{ $AircraftConfiguration->maintenance_program->name ?? '-' }}</strong></p>

                    <p class="m-b-none">Task Card Total:</p>
                    <p><strong>{{ $AircraftConfiguration->maintenance_program->maintenance_details->count() ?? '-' }} Task(s)</strong></p>
                </div>
                <div class="col-md-2 p-0">
                    <i class="text-success fa fa-rub fa-3x fw"></i>
                </div>
            </div>
        </div>
    </div>
</div>