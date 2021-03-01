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
            { data: 'aircraft_configuration.aircraft_type.manufacturer.name' },
            { data: 'aircraft_configuration.aircraft_type.name' },
            { data: 'aircraft_configuration.registration_number' },
            { data: 'aircraft_configuration.serial_number' },
            { data: 'aircraft_configuration.description', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'initial_start_date', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'initial_status' },
            { data: 'in_period_aging' },
            { data: 'current_status' },
            { data: 'month_since_start' },
        ]
    });
});
</script>
@endpush