@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/generalsetting/currency';
        var tableId = '#currency-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            searchDelay: 1500,
            ajax: {
                url: "{{ route('generalsetting.currency.index') }}",
            },
            columns: [
                { data: 'code', defaultContent: '-' },
                { data: 'symbol', defaultContent: '-' },
                { data: 'name', defaultContent: '-' },
                { data: 'description', defaultContent: '-' },
                { data: 'country.nice_name', defaultContent: '-' },
                { data: 'status', defaultContent: '-' },
                { data: 'creator_name', defaultContent: '-' },
                { data: 'created_at', defaultContent: '-' },
                { data: 'updater_name', defaultContent: '-' },
                { data: 'updated_at', defaultContent: '-' },
                { data: 'action', orderable: false },
            ]
        });



        $('.country_id').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Country',
            allowClear: true,
            ajax: {
                url: "{{ route('generalsetting.country.select2') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });




        $('#create').click(function () {
            showCreateModal ('Create New Currency', inputFormId, actionUrl);
        });





        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Currency");
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
            $('#symbol').val(data.symbol);
            $('#description').val(data.description); 

            $(".country_id").val(null).trigger('change');
            if (data.country_id != null) {
                $('#country_id').append('<option value="' + data.country_id + '" selected>' + data.country.nice_name + '</option>');
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
            submitButtonProcess (tableId, inputFormId); 
        });




        deleteButtonProcess (datatableObject, tableId, actionUrl);
    });
</script>
@endpush