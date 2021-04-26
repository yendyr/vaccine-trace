@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
    <script>
        $(document).ready(function () {
            var actionUrl = '/hr/id-card';
            var tableId = '#idcard-table';
            var inputFormId = '#idcardForm';

            var tableIdcard = $(tableId).DataTable({
                processing: true,
                serverSide: false,
                searchDelay: 1500,
                language: {
                    emptyTable: "No data existed",
                },
                ajax: {
                    url: "/hr/id-card",
                    type: "GET",
                    dataType: "json",
                },
                columns: [
                    { data: 'empid', defaultContent: '-' },
                    { data: 'idcardtype.content', defaultContent: '-' },
                    { data: 'idcardno', defaultContent: '-' },
                    { data: 'idcarddate', defaultContent: '-' },
                    { data: 'idcardexpdate', defaultContent: '-' },
                    { data: 'status', defaultContent: '-' },
                    { data: 'action', orderable: false },
                ]
            });

            $('#idcardForm').find('.select2_empidIdcard').select2({
                theme: 'bootstrap4',
                placeholder: 'choose Emp ID',
                ajax: {
                    url: "{{route('hr.employee.select2.empid')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#idcardModal')
            });

            $('#create-idcard').click(function () {
                clearForm(inputFormId);
                $("input[value='patch']").remove();
                $('#fempidIdcard').val(null).trigger('change');
                $('#fempidIdcard').attr('disabled', false);
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                showCreateModal ('Add New Id Card', inputFormId, actionUrl, '#idcardModal');
            });

            tableIdcard.on('click', '.editBtn', function () {
                $('#idcardForm').trigger("reset");
                $('#idcardModal').find('#modalTitle').html("Update Id Card data");
                let tr = $(this).closest('tr');
                let data = $('#idcard-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#idcardForm');

                $('#fempidIdcard').attr('disabled', true);
                $('#fempidIdcard').append('<option value="' + data.empid + '" selected>' + data.empid + '</option>');

                $('#fidcardtype').find('option').removeAttr('selected');
                $('#fidcardtype').find('option[value="' + data.idcardtype.value + '"]').attr('selected', '');

                $('#fidcardno').val(data.idcardno);
                $('#fidcarddate').val(data.idcarddate);
                $('#fidcardexpdate').val(data.idcardexpdate);

                $("#idcardForm").find('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $("#idcardForm").find('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $("#idcardForm").find('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-idcard");
                $('#idcardForm').attr('action', '/hr/id-card/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#idcardModal').modal('show');
            });

            $(inputFormId).on('submit', function (event) {
                submitButtonProcessDynamic (tableId, inputFormId, '#idcardModal');
            });

            // deleteButtonProcess (datatableObject, tableId, actionUrl);
        });
    </script>
@endpush
