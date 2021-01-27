<div class="col-md-6 fadeIn" style="animation-duration: 1.5s">
    <div class="panel panel-danger">
        <div class="panel-heading">
            As Customer
        </div>
        <div class="panel-body" style="margin: 0px; width: 100%; padding-bottom: 0;">
            <div class="row">
                <div class="col-md-9 m-b m-l-n">
                    <div class="col">Account Receivable COA:</div>
                    <div class="col m-b"><strong>{{ $Company->account_receivable_coa->code ?? '' }} | {{ $Company->account_receivable_coa->name ?? '- not set yet -' }}</strong></div>
                    <div class="col">Sales Discount COA</div>
                    <div class="col m-b"><strong>{{ $Company->sales_discount_coa->code ?? '' }} | {{ $Company->sales_discount_coa->name ?? '- not set yet -' }}</strong></div>
                </div>
                <div class="col-md-3 m-b">
                    <i class="text-danger fa fa-shopping-cart fa-5x"></i>
                </div>
            </div>
        </div>
        @can('update', Modules\GeneralSetting\Entities\Company::class)
            <div class="panel-footer">
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="editButtonAccounting btn btn-sm btn-outline btn-primary" 
                        data-toggle="tooltip" data-id="{{ $Company->id ?? '' }}" title="Update">
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
                <div class="col-md-9 m-b m-l-n">
                    <div class="col">Account Payable COA:</div>
                    <div class="col m-b"><strong>{{ $Company->account_payable_coa->code ?? '' }} | {{ $Company->account_payable_coa->name ?? '- not set yet -' }}</strong></div>
                    <div class="col">Purchase Discount COA</div>
                    <div class="col m-b"><strong>{{ $Company->purchase_discount_coa->code ?? '' }} | {{ $Company->purchase_discount_coa->name ?? '- not set yet -' }}</strong></div>
                </div>
                <div class="col-md-3 m-b">
                    <i class="text-danger fa fa-stumbleupon fa-5x"></i>
                </div>
            </div>
        </div>
        @can('update', Modules\GeneralSetting\Entities\Company::class)
            <div class="panel-footer">
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="editButtonAccounting btn btn-sm btn-outline btn-primary" 
                        data-toggle="tooltip" data-id="{{ $Company->id ?? '' }}" title="Update">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                        </button>
                    </div>
                </div>
            </div>
        @endcan
    </div>
</div>