@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/vaksinasi/squad';
    var tableId = '#squad-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('vaksinasi.squad.index') }}",
        },
        columns: [
            { data: 'code', defaultContent: '-'  },
            { data: 'name', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'address', defaultContent: '-' },
            { data: 'vaccine_target', defaultContent: '-' },
            { data: 'status', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'updater_name', defaultContent: '-' },
            { data: 'updated_at', defaultContent: '-' },
            { data: 'action', orderable: false },
        ]
    });



    // $('.item_type').select2({
    //     theme: 'bootstrap4',
    //     placeholder: 'Choose Type',
    //     allowClear: false,
    //     minimumResultsForSearch: -1,
    //     dropdownParent: $('#inputModal')
    // });




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
        }).prependTo('#inputForm');

        $('#code').val(data.code);
        $('#name').val(data.name);
        $('#description').val(data.description); 
        $('#address').val(data.address); 
        $('#vaccine_target').val(data.vaccine_target); 

        // $(".unit_class_id").val(null).trigger('change');
        // if (data.unit_class != null){
        //     $('#unit_class_id').append('<option value="' + data.unit_class_id + '" selected>' + data.unit_class.name + '</option>');
        // } 

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