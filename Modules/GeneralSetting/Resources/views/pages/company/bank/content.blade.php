@if (sizeOf($Company->banks) > 0)
@foreach ($Company->banks as $bank)
<div class="col-md-4 fadeIn" style="animation-duration: 1.5s">
    <div class="panel panel-success">
        <div class="panel-heading">
            {{ $bank->label ?? '-' }}
        </div>
        <div class="panel-body" style="margin: 0px; width: 100%; padding-bottom: 0;">
            <div class="row">
                <div class="col-md-9 m-b m-l-n">
                    <div class="col"><h3>{{ $bank->account_number ?? '-' }}</h3></div>
                    <div class="col">{{ $bank->bank_name ?? '-' }}</div>
                    <div class="col">{{ $bank->bank_branch ?? '-' }}</div>
                    <div class="col">{{ $bank->account_holder_name ?? '-' }}</div>
                    <div class="col">{{ $bank->swift_code ?? '-' }}</div>
                    <div class="col">{{ $bank->description ?? '-' }}</div>
                    <div class="col m-b">COA: {{ $bank->chart_of_account->name ?? '-' }}</div>
                    <div class="col">
                        @if($bank->status == 1)
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
                <div class="col-md-3 m-b">
                    <i class="text-success fa fa-cc-mastercard fa-3x"></i>
                </div>
            </div>
        </div>
        @can('update', Modules\GeneralSetting\Entities\Company::class)
            <div class="panel-footer">
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="editButtonBank btn btn-sm btn-outline btn-primary" 
                        data-toggle="tooltip" data-id="{{ $bank->id ?? '' }}" title="Update">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                        </button>

                        <button type="button" name="delete" class="deleteButtonBank btn btn-sm btn-outline btn-danger" data-toggle="tooltip" title="Delete"
                        value="{{ $bank->id ?? '' }}">
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