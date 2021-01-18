@push('footer-scripts')
    <script src="{{URL::asset('theme/js/plugins/pwstrength/pwstrength-bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            var userId;

            var table = $('#user-table').DataTable({
                processing: true,
                serverSide: false,
                searchDelay: 1500,
                ajax: {
                    url: "{{ route('gate.user.index')}}",
                },
                columns: [
                    { data: 'username', name: 'username' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'role.role_name', name: 'role.role_name' },
                    { data: 'company.company_name', name: 'company.company_name',
                        defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false },
                    { data: 'password', name: 'password', visible: false },
                ],
            });

            $('#createUser').click(function () {
                $('#saveBtn').val("create-user");
                $('#userForm').trigger("reset");
                $('#modalTitle').html("Add New User");
                $(".select2_role").val(null).trigger('change');
                $(".select2_company").val(null).trigger('change');

                $('#userModal').modal('show');
                $('div[class^="invalid-feedback-"]').html('');  //hide all alert with pre-string invalid-feedback
                $('#userForm').attr('action', '/gate/user');
                // $("#fpassword").parentsUntil('div.modal-body').show();
                // $('#fpassword').removeAttr('disabled');
                $("input[value='patch']").remove();
            });

            table.on('click', '.editBtn', function () {
                $('#userForm').trigger("reset");
                $('#modalTitle').html("Edit User");
                userId= $(this).val();
                let tr = $(this).closest('tr');
                let data = table.row(tr).data();
                // $("#fpassword").parentsUntil('div.modal-body').hide();
                // $('#fpassword').prop( "disabled", true );
                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#userForm');

                $('#fusername').val(data.username);
                $('#fname').val(data.name);
                $('#femail').val(data.email);
                $('#fpassword').val(data.password);
                $(".select2_role").val(null).trigger('change');
                $('#frole').append('<option value="' + data.role_id + '" selected>' + data.role.role_name + '</option>');
                $(".select2_company").val(null).trigger('change');
                if (data.company == null){
                    $('#fcompany').append('<option value="' + data.company_id + '" selected></option>');
                } else{
                    $('#fcompany').append('<option value="' + data.company_id + '" selected>' + data.company.company_name + '</option>');
                }

                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-user");
                $('#userForm').attr('action', '/gate/user/' + data.id);

                $('div[class^="invalid-feedback-"]').html('');  //hide all alert with pre-string invalid-feedback
                $('#userModal').modal('show');
            });

            $('.select2_company').select2({
                theme: 'bootstrap4',
                placeholder: 'choose a company',
                ajax: {
                    url: "{{route('gate.user.select2.company')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#userModal')
            });
            $('.select2_role').select2({
                theme: 'bootstrap4',
                placeholder: 'choose a role',
                ajax: {
                    url: "{{route('gate.user.select2.role')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#userModal')
            });

            $('#userForm').on('submit', function (event) {
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
                        $('#userModal').modal('hide');
                        $('#user-table').DataTable().ajax.reload();
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
                $('#delete-form').attr('action', "/gate/user/"+ userId);
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
                        $('#user-table').DataTable().ajax.reload();
                    }
                });
            });

        });

        $('#fpassword').pwstrength({
            ui: { showVerdictsInsideProgressBar: true }
        });
    </script>
@endpush
