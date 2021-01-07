@push('footer-scripts')
    <script>
        $(document).ready(function () {
            var taskcardTypeId;

            var table = $('#taskcard-type-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('ppc.taskcard.type.index')}}",
                },
                columns: [
                    { data: 'code', name: 'Code'  },
                    { data: 'name', name: 'Task Card Type Name' },
                    { data: 'description', name: 'Description/Remark' },
                    { data: 'status', name: 'Status' },
                    { data: 'action', name: 'Action', orderable: false },
                ]
            });

            $('#createTaskcardType').click(function () {
                $('#saveBtn').val("create-role");
                $('#taskcardTypeForm').trigger("reset");
                $('#modalTitle').html("Create New Task Card Type");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#taskcardTypeModal').modal('show');
                $('#taskcardTypeForm').attr('action', '/ppc/taskcard/type');
                $("input[value='patch']").remove();
            });

            table.on('click', '.editBtn', function () {
                $('#taskcardTypeForm').trigger("reset");
                $('#modalTitle').html("Edit Task Card Type");
                taskcardTypeId= $(this).val();
                let tr = $(this).closest('tr');
                let data = table.row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#taskcardTypeForm');

                $('#code').val(data.code);
                $('#name').val(data.name);
                $('#description').val(data.description);                
                if (data.status == '<label class="label label-success">Active</label>') {
                    $('#status').prop("checked", true);
                    // document.getElementById("status").checked = true;
                }
                else if (data.status == '<label class="label label-danger">Inactive</label>') {
                    $('#status').prop("checked", false);
                    // document.getElementById("status").checked = false;
                }

                $('#saveBtn').val("edit-taskcardType");
                $('#taskcardTypeForm').attr('action', '/ppc/taskcard/type/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#taskcardTypeModal').modal('show');
            });

            $('#taskcardTypeForm').on('submit', function (event) {
                event.preventDefault();
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
                        $('#saveBtn'). prop('disabled', true);
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
                            $('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $('#form_result').html(data.success);
                        }
                        $('#taskcardTypeModal').modal('hide');
                        $('#taskcard-type-table').DataTable().ajax.reload();
                    },
                    complete: function () {
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'stop' );
                        $('#saveBtn'). prop('disabled', false);
                    }
                });
            });

            table.on('click', '.deleteBtn', function () {
                roleId = $(this).val();
                $('#deleteModal').modal('show');
                $('#delete-form').attr('action', "/ppc/taskcard/type/"+ taskcardTypeId);
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
        });
    </script>
@endpush