@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/ppc/maintenance-program';
    var tableId = '#maintenance-program-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('ppc.maintenance-program.index') }}",
        },
        columns: [
            { data: 'code', "render": function ( data, type, row, meta ) {
                            return '<a href="maintenance-program/' + row.id + '">' + row.code + '</a>'; } },
            { data: 'aircraft_type.name', "render": function ( data, type, row, meta ) {
                            return '<a href="maintenance-program/' + row.id + '">' + row.aircraft_type.name + '</a>'; } },
            { data: 'name', "render": function ( data, type, row, meta ) {
                            return '<a href="maintenance-program/' + row.id + '">' + row.name + '</a>'; } },
            { data: 'description', name: 'Description/Remark' },
            { data: 'status', name: 'Status' },
            { data: 'creator_name', name: 'Created By' },
            { data: 'created_at', name: 'Created At' },
            { data: 'updater_name', name: 'Last Updated By' },
            { data: 'updated_at', name: 'Last Updated At' },
            { data: 'action', name: 'Action', orderable: false },
        ]
    });






    $('.aircraft_type_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose A/C Type',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.aircraft-type.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    





    $('#create').click(function () {
        showCreateModal ('Create New Maintenance Program', inputFormId, actionUrl);
    });






    datatableObject.on('click', '.editBtn', function () {
        $('#modalTitle').html("Edit Maintenance Program");
        $('#duplicated_from').hide();
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

        $('#code').val(data.code);
        $('#name').val(data.name);
        $('#description').val(data.description);

        $(".aircraft_type_id").val(null).trigger('change');
        if (data.aircraft_type != null) {
            $('#aircraft_type_id').append('<option value="' + data.aircraft_type_id + '" selected>' + data.aircraft_type.name + '</option>');
        }
               
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
        event.preventDefault();
        let url_action = $(inputFormId).attr('action');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $(
                    'meta[name="csrf-token"]'
                ).attr("content")
            },
            url: url_action,
            method: "POST",
            data: $(inputFormId).serialize(),
            dataType: 'json',
            beforeSend:function(){
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'start' );
                $('[class^="invalid-feedback-"]').html('');
                $('#saveBtn').prop('disabled', true);
            },
            error: function(data){
                let errors = data.responseJSON.errors;
                if (errors) {
                    $.each(errors, function (index, value) {
                        $('div.invalid-feedback-'+index).html(value);
                    })
                }
            },
            success: function (data) {
                if (data.success) {
                    generateToast ('success', data.success);                            
                }
                $('#inputModal').modal('hide');
                $(targetTableId).DataTable().ajax.reload();

                setTimeout(function () {
                    window.location.href = "maintenance-program/" + data.id;
                }, 2000);
            },
            complete: function () {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'stop' );
                $('#saveBtn'). prop('disabled', false);
            }
        }); 
    });

    deleteButtonProcess (datatableObject, tableId, actionUrl);

    approveButtonProcess (datatableObject, tableId, actionUrl);
});
</script>
@endpush