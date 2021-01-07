@push('footer-scripts')
    <script>
        $(document).ready(function () {
            var userId;

            var table = $('#taskcard-type-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('ppc.taskcard-type.index')}}",
                },
                columns: [
                    { data: 'code', name: 'Code' },
                    { data: 'name', name: 'Task Card Type Name' },
                    { data: 'description', name: 'Description/Remark' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false },
                ],
            });

            $('#createTaskcardType').click(function () {
                $('#saveBtn').val("create-taskcard-type");
                $('#TaskcardTypeForm').trigger("reset");
                $('#modalTitle').html("Add New Task Card Type");

                $('#TaskcardTypeModal').modal('show');
                $('div[class^="invalid-feedback-"]').html('');  //hide all alert with pre-string invalid-feedback
                $('#TaskcardTypeForm').attr('action', '/ppc/taskcard-type');
                // $("#fpassword").parentsUntil('div.modal-body').show();
                // $('#fpassword').removeAttr('disabled');
                $("input[value='patch']").remove();
            });

            table.on('click', '.editBtn', function () {
                $('#TaskcardTypeForm').trigger("reset");
                $('#modalTitle').html("Edit Task Card Type");
                userId= $(this).val();
                let tr = $(this).closest('tr');
                let data = table.row(tr).data();
                // $("#fpassword").parentsUntil('div.modal-body').hide();
                // $('#fpassword').prop( "disabled", true );
                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#TaskcardTypeForm');

                $('#fcode').val(data.code);
                $('#fname').val(data.name);
                $('#fdescription').val(data.description);

                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-taskcard-type");
                $('#TaskcardTypeForm').attr('action', '/ppc/taskcard-type/' + data.id);

                $('div[class^="invalid-feedback-"]').html('');  //hide all alert with pre-string invalid-feedback
                $('#TaskcardTypeModal').modal('show');
            });

            $('#TaskcardTypeForm').on('submit', function (event) {
                event.preventDefault();
                $('div[class^="invalid-feedback-"]').html('');
                let url_action = $(this).attr('action');
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $(
                            'meta[name="csrf-token"]'
                        ).attr("content")
                    },
                    url: url_action,
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend:function(){
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'start' );
                        $('[class^="invalid-feedback-"]').html('');
                        $('#saveBtn').prop('disabled', true);
                    },
                    error: function(data){
                        let html = '';
                        let errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function (index, value) {
                                $('div.invalid-feedback-'+index).html(value);
                            })
                        }
                    },
                    success:function(data){
                        if (data.success) {
                            $('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $('#form_result').html(data.success);
                        }
                        $('#TaskcardTypeModal').modal('hide');
                        $('#taskcard-type-table').DataTable().ajax.reload();
                    },
                    complete:function(){
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'stop' );
                        $('#saveBtn').prop('disabled', false);
                    }
                });
            });

            table.on('click', '.deleteBtn', function () {
                userId = $(this).val();
                $('#deleteModal').modal('show');
                $('#delete-form').attr('action', "/ppc/taskcard-type/"+ userId);
            });

            $('#delete-form').on('submit', function (e) {
                e.preventDefault();
                let url_action = $(this).attr('action');
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $(
                            'meta[name="csrf-token"]'
                        ).attr("content")
                    },
                    url: url_action,
                    type: "DELETE", //bisa method
                    beforeSend:function(){
                        $('#delete-button').text('Deleting...');
                        $('#delete-button').prop('disabled', true);
                    },
                    error: function(data){
                        if (data.error) {
                            $('#form_result').attr('class', 'alert alert-danger fade show font-weight-bold');
                            $('#form_result').html(data.error);
                        }
                    },
                    success:function(data){
                        if (data.success){
                            $('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $('#form_result').html(data.success);
                        }
                    },
                    complete: function(data) {
                        $('#delete-button').text('Delete');
                        $('#deleteModal').modal('hide');
                        $('#delete-button').prop('disabled', false);
                        $('#taskcard-type-table').DataTable().ajax.reload();
                    }
                });
            });

            // $('.select2_status').select2({
            //     theme: 'bootstrap4',
            //     placeholder: 'choose a company',
            //     ajax: {
            //         url: "{{route('gate.user.select2.company')}}",
            //         dataType: 'json',
            //     },
            //     dropdownParent: $('#userModal')
            // });
        });
    </script>
@endpush
