<div class="col fadeIn" style="animation-duration: 1.5s">
    @if($Journal->approvals()->count() == 0)
        @include('accounting::pages.journal.ledger.modal')
        @component('components.delete-modal', ['name' => 'Ledger Detail Datalist'])
        @endcomponent
    @endif

    @component('components.crud-form.index',[
        'title' => "Ledger Detail Datalist",
        'tableId' => 'journal-detail-table'])

        @if($Journal->approvals()->count() == 0)
            @slot('createButton')
                @can('create', Modules\Accounting\Entities\Journal::class)                
                    <button type="button" id="create" class="btn btn-primary btn-lg">
                        <i class="fa fa-plus-circle"></i>&nbsp;Create New
                    </button>   
                @endcan
            @endslot
        @endif

        @slot('tableContent')
            <th>Account/COA Code</th>
            <th>Account/COA Name</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Remark</th>
            {{-- <th>Status</th> --}}
            <th>Created At</th>
            <th>Action</th>
            {{-- @if($Journal->approvals()->count() == 0)
                <th>Action</th>
            @else
                <th>Receiving/Inbound Status</th>
            @endif --}}
        @endslot

        @slot('tableFooter')
            <th colspan="2" style="text-align:right" class="text-danger">Total ({{ $Journal->currency->code }}):</th>
            <th class="text-danger"></th>
            <th class="text-danger"></th>
            <th class="text-danger text-left"></th>
        @endslot
    @endcomponent
</div>

@include('accounting::components.journal.ledger._script')