@foreach ($Company->contacts as $contact)
<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $contact->label ?? '-' }}
        </div>
        <div class="panel-body" style="margin: 0px; width: 100%">
            <div class="row">
                <div class="col-md-6 m-b">
                    <i class="fa fa-user"></i>&nbsp;Contact Person:
                    <h4 class="no-margins">
                        {{ $contact->name ?? '-' }}
                    </h4>
                </div>
                <div class="col-md-6 m-b">
                    <i class="fa fa-envelope"></i>&nbsp;Email:
                    <h4 class="no-margins">
                        {{ $contact->email ?? '-' }}
                    </h4>
                </div>
                <div class="col-md-6 m-b">
                    <i class="fa fa-mobile"></i>&nbsp;Mobile Number:
                    <h4 class="no-margins">
                        {{ $contact->mobile_number ?? '-' }}
                    </h4>
                </div>
                <div class="col-md-6 m-b">
                    <i class="fa fa-phone"></i>&nbsp;Office Number:
                    <h4 class="no-margins">
                        {{ $contact->office_number ?? '-' }}
                    </h4>
                </div>
                <div class="col-md-6 m-b">
                    <i class="fa fa-tty"></i>&nbsp;Fax Number:
                    <h4 class="no-margins">
                        {{ $contact->fax_number ?? '-' }}
                    </h4>
                </div>
                <div class="col-md-6 m-b">
                    <i class="fa fa-phone"></i>&nbsp;Other Number:
                    <h4 class="no-margins">
                        {{ $contact->other_number ?? '-' }}
                    </h4>
                </div>
                <div class="col-md-6 m-b">
                    <i class="fa fa-globe"></i>&nbsp;Website:
                    <h4 class="no-margins">
                        <a href="{{ $contact->website ?? '#' }}" target="_blank">{{ $contact->website ?? '-' }}</a>
                    </h4>
                </div>
                <div class="col-md-6 m-b">
                    <i class="fa fa-info-circle"></i>&nbsp;Status:
                    <div class="no-margins">
                        @if($contact->status == 1)
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
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <button class="editBtn btn btn-sm btn-outline btn-primary ml-1" 
                    value="" data-toggle="tooltip" data-id="{{ $contact->id ?? '' }}" title="Update">
                        <i class="fa fa-edit"></i>&nbsp;Edit</button>

                    <a href="{{ $href ?? '' }}" name="delete" id="{{ (isset($deleteId) ? $deleteId : '') }}" class="deleteBtn btn btn-sm btn-outline btn-danger ml-1" data-toggle="tooltip" title="Delete">
                        <i class="fa fa-trash"></i>&nbsp;Delete
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach