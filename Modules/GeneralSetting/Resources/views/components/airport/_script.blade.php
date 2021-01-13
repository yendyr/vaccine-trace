@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/generalsetting/airport/';
        var tableId = '#airport-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('generalsetting.airport.index') }}",
            },
            columns: [
                { data: 'ident', name: 'Identity', defaultContent: '-' },
                { data: 'type', name: 'Type', defaultContent: '-' },
                { data: 'name', name: 'Name', defaultContent: '-' },
                { data: 'latitude', name: 'Latitude', defaultContent: '-' },
                { data: 'longitude', name: 'Longitude', defaultContent: '-' },
                { data: 'elevation', name: 'Elevation', defaultContent: '-' },
                { data: 'continent', name: 'Continent', defaultContent: '-' },
                { data: 'iso_country', name: 'ISO Country', defaultContent: '-' },
                { data: 'iso_region', name: 'ISO Region', defaultContent: '-' },
                { data: 'municipality', name: 'Municipality', defaultContent: '-' },
                { data: 'scheduled_service', name: 'Scheduled Service', defaultContent: '-' },
                { data: 'gps_code', name: 'GPS Code', defaultContent: '-' },
                { data: 'iata_code', name: 'IATA Code', defaultContent: '-' },
                { data: 'local_code', name: 'Local Code', defaultContent: '-' },
                { data: 'home_link', name: 'Home Link', defaultContent: '-' },
                { data: 'wikipedia_link', name: 'Wikipedia Link', defaultContent: '-' },
                { data: 'keywords', name: 'Keywords', defaultContent: '-' },
                { data: 'description', name: 'Dscription', defaultContent: '-' },
                { data: 'status', name: 'Status', defaultContent: '-' },
                { data: 'creator_name', name: 'Created By', defaultContent: '-' },
                { data: 'created_at', name: 'Created At', defaultContent: '-' },
                { data: 'updater_name', name: 'Last Updated By', defaultContent: '-' },
                { data: 'updated_at', name: 'Last Updated At', defaultContent: '-' },
                { data: 'action', name: 'Action', orderable: false },
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
            $(inputFormId).attr('action', actionUrl + data.id);

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