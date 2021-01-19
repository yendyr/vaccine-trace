<div class="col-md-6 fadeIn" style="animation-duration: 1.5s">
    <div class="panel panel-danger">
        <div class="panel-heading">
            As Customer
        </div>
        <div class="panel-body" style="margin: 0px; width: 100%; padding-bottom: 0;">
            <div class="row">
                <div class="col-md-10 m-b m-l-n">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col m-b"></div>
                </div>
                <div class="col-md-2 m-b">
                    <i class="text-danger fa fa-arrow-circle-left fa-5x"></i>
                </div>
            </div>
        </div>
        @can('update', Modules\GeneralSetting\Entities\Company::class)
            <div class="panel-footer">
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="editButtonCustomer btn btn-sm btn-outline btn-primary" 
                        data-toggle="tooltip" data-id="{{ $address->id ?? '' }}" title="Update">
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
            As Supplier
        </div>
        <div class="panel-body" style="margin: 0px; width: 100%; padding-bottom: 0;">
            <div class="row">
                <div class="col-md-10 m-b m-l-n">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col m-b"></div>
                </div>
                <div class="col-md-2 m-b">
                    <i class="text-danger fa fa-arrow-circle-right fa-5x"></i>
                </div>
            </div>
        </div>
        @can('update', Modules\GeneralSetting\Entities\Company::class)
            <div class="panel-footer">
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="editButtonCustomer btn btn-sm btn-outline btn-primary" 
                        data-toggle="tooltip" data-id="{{ $address->id ?? '' }}" title="Update">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                        </button>
                    </div>
                </div>
            </div>
        @endcan
    </div>
</div>