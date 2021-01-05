@push('footer-scripts')
    <script>
        $(document).ready(function () {
            var menuId;

            var table = $('#menu-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('gate.menu.index')}}",
                },
                columns: [
                    // { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { title: 'Name', data: 'menu_text', name: 'menu_text' },
                    { title: 'icon', data: 'menu_icon', name: 'menu_icon' },
                    { title: 'Status', data: 'status', name: 'status' },
                    { title: 'Action', data: 'action', name: 'action', orderable: false },
                ]
            });

            $('#createMenu').click(function () {
                $('#saveBtn').val("create-menu");
                $('#menuForm').trigger("reset");
                $('#modalTitle').html("Add New Menu");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#menuModal').modal('show');
                $('#menuForm').attr('action', '/gate/menu');
                $("input[value='patch']").remove();
            });

            table.on('click', '.editBtn', function () {
                $('#menuForm').trigger("reset");
                $('#modalTitle').html("Edit Menu");
                menuId= $(this).val();
                let tr = $(this).closest('tr');
                let data = table.row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#menuForm');

                $('#fmenuname').val(data.menu_name);
                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-menu");
                $('#menuForm').attr('action', '/gate/menu/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#menuModal').modal('show');
            });

            $('#menuForm').on('submit', function (event) {
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
                        $('#menuModal').modal('hide');
                        $('#menu-table').DataTable().ajax.reload();
                    },
                    complete: function () {
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'stop' );
                        $('#saveBtn'). prop('disabled', false);
                    }
                });
            });

            table.on('click', '.deleteBtn', function () {
                menuId = $(this).val();
                $('#deleteModal').modal('show');
                $('#delete-form').attr('action', "/gate/menu/"+ menuId);
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
                        $('#menu-table').DataTable().ajax.reload();
                    }
                });
            });
        });


    </script>
@endpush
