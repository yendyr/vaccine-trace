@extends('layouts.master')

@section('content')
    @include('components.delete-modal', 
                    ['deleteModalId' => 'deleteModalInstruction',
                    'deleteFormId' => 'deleteFormInstruction',
                    'deleteModalButtonId' => 'deleteModalButtonInstruction'])
    
    @include('components.delete-modal', 
                    ['deleteModalId' => 'deleteModalItem',
                    'deleteFormId' => 'deleteFormItem',
                    'deleteModalButtonItem' => 'deleteModalButtonItem'])

    <div class="row m-b m-t">
        <div class="col-md-5">
            <div class="profile-image">
                @if($work_order->file_attachment)
                    <a target="_blank" href="{{ URL::asset('uploads/company/' . $work_order->owned_by . '/taskcard/' . $work_order->file_attachment) }}">
                    <img src="{{ URL::asset('assets/default-pdf-image.png') }}" class="m-t-xs" id="fileTaskcard">
                    </a>

                    <span class="m-l-sm font-italic"><small><label class="label label-primary" for="taskcardFile" style="cursor:pointer;" data-toggle="tooltip" title="Upload New Work Order Attachment File">Replace File</label></small></span>
                @else
                    <img src="{{ URL::asset('assets/default-file-image.png') }}" class="m-t-xs" id="fileTaskcard">

                    <span class="font-italic"><small><label class="label label-primary" for="taskcardFile" style="cursor:pointer;" data-toggle="tooltip" title="Upload New Work Order Attachment File">Attach New File</label></small></span>
                @endif

                <input onchange="getTaskcardFile(this)" style="display: none;" id="taskcardFile" type="file" name="taskcardFile" data-id="{{ $work_order->id }}" accept="application/pdf" />
            </div>
            <div class="profile-info">
                <h2 class="m-t-none m-b-none">
                    <strong>{{ $work_order->title ?? 'Work Order Title' }}</strong>
                </h2>
                <h2 class="text-success m-t-none"><strong>{{ $work_order->code ?? '' }}</strong></h2>
                <div>Work Order Description: <strong class="text-success">{{ $work_order->description ?? '' }}</strong></div>
            </div>
        </div>
        <div class="col-md-3">
            <div>CSN: <strong class="text-success">{{ $work_order->csn ?? '-' }}</strong></div>
            <div>CSO: <strong class="text-success">{{ $work_order->cso ?? '-' }}</strong></div>
            <div>TSN: <strong class="text-success">{{ $work_order->tsn ?? '-' }}</strong></div>
            <div>TSO: <strong class="text-success">{{ $work_order->tso ?? '-' }}</strong></div>
            <div>Station: <strong class="text-success">{{ $work_order->station ?? '-' }}</strong></div>
        </div>
        <div class="col-md-4">
        <div>Aircraft: <strong class="text-success">{{ $work_order->aircraft?->aircraft_type?->name ?? '-' }}</strong></div>
            <div>Aircraft Serial Number: <strong class="text-success">{{ $work_order?->aircraft_serial_number ?? $work_order->aircraft?->serial_number ?? '-' }}</strong></div>
            <div>Aircraft Registration Number: <strong class="text-success">{{ $work_order?->aircraft_registration_number ?? $work_order->aircraft?->registration_number ?? '-' }}</strong></div>
            <div>Issued Date: <strong class="text-success">{{ $work_order->created_at->format('Y-F-d') ?? '-' }}</strong></div>
            <div>Status: <strong>
                @if($work_order->status == 1)
                    <label class="label label-success">
                        Active
                    </label>
                @else
                    <label class="label label-danger">
                        Inactive
                    </label>
                @endif
                </strong>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            @include('ppc::pages.work-order.work-package.content')
        </div>
    </div>
@endsection

@include('ppc::components.work-order._file_upload_script')

@push('header-scripts')
@include('layouts.includes._header-datatable-script')
    <style>
        thead input {
            width: 100%;
        }
        tr.group,
        tr.group:hover {
            background-color: #aaa !important;
        }
    .select2-container.select2-container--default.select2-container--open {
        z-index: 9999999 !important;
    }
    .select2 {
        width: 100% !important;
    }
</style>
@endpush

@push('footer-scripts')
    <script>
        $(document).ready(function(){
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
                $('#myTab a[href="' + activeTab + '"]').tab('show');
            }
        });
    </script>
@include('layouts.includes._footer-datatable-script')
@endpush