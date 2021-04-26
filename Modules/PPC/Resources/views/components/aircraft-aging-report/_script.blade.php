{{-- @include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit') --}}

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/ppc/aircraft-aging-report';
    var tableId = '#aircraft-aging-report-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('ppc.aircraft-aging-report.index') }}",
        },
        columns: [
            { data: 'aircraft_type.manufacturer.name', defaultContent: '-' },
            { data: 'aircraft_type.name', defaultContent: '-' },
            { data: 'registration_number', defaultContent: '-' },
            { data: 'serial_number' },
            { data: 'description', defaultContent: '-' },
            { data: 'initial_start_date', defaultContent: '-' },
            { data: 'initial_status', defaultContent: '-' },
            { data: 'in_period_aging', defaultContent: '-' },
            { data: 'current_status', defaultContent: '-' },
            { data: 'month_since_start', defaultContent: '-' },
        ]
    });
});
</script>
@endpush