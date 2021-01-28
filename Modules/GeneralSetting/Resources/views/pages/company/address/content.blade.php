@if (sizeOf($Company->addresses) > 0)
@foreach ($Company->addresses as $address)
<div class="col-md-4 fadeIn" style="animation-duration: 1.5s">
    <div class="panel panel-warning">
        <div class="panel-heading">
            {{ $address->label ?? '-' }}
        </div>
        <div class="panel-body" style="margin: 0px; width: 100%; padding-bottom: 0;">
            <div class="row">
                <div class="col-md-10 m-b m-l-n">
                    <div class="col">{{ $address->name ?? '-' }}</div>
                    <div class="col">{{ $address->street ?? '-' }}</div>
                    <div class="col">{{ $address->city ?? '-' }}, {{ $address->province ?? '-' }}</div>
                    <div class="col">{{ $address->country->nice_name ?? '-' }}, {{ $address->post_code ?? '-' }}</div>
                    <div class="col">Latitude: {{ $address->latitude ?? '-' }}</div>
                    <div class="col m-b">Longitude: {{ $address->longitude ?? '-' }}</div>
                    <div class="col">
                        @if($address->status == 1)
                            <label class="label label-success">
                                Active
                            </label>
                        @else
                            <label class="label label-danger">
                                Inactive
                            </label>
                        @endif
                    </div>
                </div>
                <div class="col-md-2 m-b">
                    <i class="text-warning fa fa-map-marker fa-5x"></i>
                </div>
            </div>
        </div>
        @can('update', Modules\GeneralSetting\Entities\Company::class)
            <div class="panel-footer">
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="editButtonAddress btn btn-sm btn-outline btn-primary" 
                        data-toggle="tooltip" data-id="{{ $address->id ?? '' }}" title="Update">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                        </button>

                        <button type="button" name="delete" class="deleteButtonAddress btn btn-sm btn-outline btn-danger" data-toggle="tooltip" title="Delete"
                        value="{{ $address->id ?? '' }}">
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