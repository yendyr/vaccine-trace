@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/vaksinasi/vaccination-participant';
    var tableId = '#vaccination-participant-table';
    var inputFormId = '#inputForm';

    $('#vaccination-participant-table thead tr').clone(true).appendTo('#vaccination-participant-table thead');
    $('#vaccination-participant-table thead tr:eq(1) th').each( function (i) {
        if ($(this).text() != 'Action') {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search" class="form-control" />');
    
            $('input', this).on('keypress', function (e) {
                if(e.which == 13) {
                    if (datatableObject.column(i).search() !== this.value) {
                        datatableObject
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                }
            });
        }
        else {
            $(this).html('&nbsp;');
        }
    });

    $('#vaccination-participant-table tbody').on( 'click', 'tr.group', function () {
        var currentOrder = datatableObject.order()[0];
        if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
            datatableObject.order( [ groupColumn, 'desc' ] ).draw();
        }
        else {
            datatableObject.order( [ groupColumn, 'asc' ] ).draw();
        }
    });

    var groupColumn = 1;

    var datatableObject = $(tableId).DataTable({
        columnDefs: [{
            visible: false, 
            targets: groupColumn }
        ],
        order: [[ groupColumn, 'asc' ]],
        drawCallback: function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group" style="text-align: left;"><td colspan="10">Satuan: <b>' + group + '</b></td></tr>'
                    );
                    last = group;
                }
            });
        },
        pageLength: 50,
        processing: true,
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-5x fa-fw text-success"></i>'
        },
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('vaksinasi.vaccination-participant.index') }}",
        },
        columns: [
            { data: 'date', defaultContent: '-'  },
            { data: 'squad.name', defaultContent: '-'  },
            { data: 'id_type', defaultContent: '-'  },
            { data: 'id_number', defaultContent: '-'  },
            { data: 'name', defaultContent: '-' },
            { data: 'address', defaultContent: '-' },
            { data: 'vaccine_used', defaultContent: '-' },
            // { data: 'status', defaultContent: '-' },
            // { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            // { data: 'updater_name', defaultContent: '-' },
            { data: 'updated_at', defaultContent: '-' },
            { data: 'action', orderable: false },
        ]
    });




    $('.squad_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih Satuan',
        allowClear: true,
        ajax: {
            url: "{{ route('vaksinasi.squad.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.id_type').select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih Jenis Identitas',
        allowClear: false,
        minimumResultsForSearch: -1,
        dropdownParent: $('#inputModal')
    });

    $('.vaccine_used').select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih Jenis Vaksin',
        allowClear: false,
        minimumResultsForSearch: -1,
        dropdownParent: $('#inputModal')
    });






    $('#create').click(function () {
        showCreateModal ('Buat Data Satuan Baru', inputFormId, actionUrl);
    });

    datatableObject.on('click', '.editBtn', function () {
        $('#modalTitle').html("Ubah Data Satuan");
        $(inputFormId).trigger("reset");                
        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject.row(tr).data();
        $(inputFormId).attr('action', actionUrl + '/' + data.id);

        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo(inputFormId);

        $('#code').val(data.code);
        $('#name').val(data.name);
        $('#description').val(data.description); 
        $('#address').val(data.address); 
        $('#vaccine_target').val(data.vaccine_target); 

        if (data.status == '<label class="label label-success">Active</label>') {
            $('#status').prop('checked', true);
        }
        else {
            $('#status').prop('checked', false);
        }

        $('#saveBtn').val("edit");
        $('#inputModal').modal('show');
    });

    $(inputFormId).on('submit', function (event) {
        submitButtonProcess (tableId, inputFormId); 
    });

    deleteButtonProcess (datatableObject, tableId, actionUrl);
});
</script>
@endpush