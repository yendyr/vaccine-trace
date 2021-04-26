@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/generalsetting/airport';
        var tableId = '#airport-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            searchDelay: 1500,
            ajax: {
                url: "{{ route('generalsetting.airport.index') }}",
            },
            columns: [
                { data: 'type', defaultContent: '-' },
                { data: 'name', defaultContent: '-' },
                { data: 'latitude_deg', defaultContent: '-' },
                { data: 'longitude_deg', defaultContent: '-' },
                { data: 'elevation_ft', defaultContent: '-' },
                { data: 'continent', defaultContent: '-' },
                { data: 'iso_country', defaultContent: '-' },
                { data: 'iso_region', defaultContent: '-' },
                { data: 'municipality', defaultContent: '-' },
                { data: 'scheduled_service', defaultContent: '-' },
                { data: 'gps_code', defaultContent: '-' },
                { data: 'iata_code', defaultContent: '-' },
                { data: 'local_code', defaultContent: '-' },
                { data: 'description', defaultContent: '-' },
                { data: 'status', defaultContent: '-' },
                { data: 'creator_name', defaultContent: '-' },
                { data: 'created_at', defaultContent: '-' },
                { data: 'updater_name', defaultContent: '-' },
                { data: 'updated_at', defaultContent: '-' },
                { data: 'action', orderable: false },
            ]
        });

        $('#create').click(function () {
            showCreateModal ('Create New Airport', inputFormId, actionUrl);
        });

        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Airport");
            $(inputFormId).trigger("reset");                
            rowId= $(this).val();
            let tr = $(this).closest('tr');
            let data = datatableObject.row(tr).data();
            $(inputFormId).attr('action', actionUrl + '/' + data.id);

            $('<input>').attr({
                type: 'hidden',
                name: '_method',
                value: 'patch'
            }).prependTo('#inputForm');

            $('#ident').val(data.ident);
            $('#type').val(data.type);
            $('#name').val(data.name);
            $('#latitude_deg').val(data.latitude_deg);
            $('#longitude_deg').val(data.longitude_deg);
            $('#elevation_ft').val(data.elevation_ft);
            $('#continent').val(data.continent);
            $('#iso_country').val(data.iso_country);
            $('#iso_region').val(data.iso_region);
            $('#municipality').val(data.municipality);
            $('#scheduled_service').val(data.scheduled_service);
            $('#gps_code').val(data.gps_code);
            $('#iata_code').val(data.iata_code);
            $('#local_code').val(data.local_code);
            $('#home_link').val(data.home_link);
            $('#wikipedia_link').val(data.wikipedia_link);
            $('#keywords').val(data.keywords);
            $('#description').val(data.description);                
            if (data.status == '<label class="label label-success">Active</label>') {
                $('#status').prop('checked', true);
            }
            else {
                $('#status').prop('checked', false);
            }

            $('#saveBtn').val("edit");
            $('[class^="invalid-feedback-"]').html('');  // clearing validation
            $('#inputModal').modal('show');
        });

        $(inputFormId).on('submit', function (event) {
            submitButtonProcess (tableId, inputFormId); 
        });

        deleteButtonProcess (datatableObject, tableId, actionUrl);
    });
</script>
@endpush