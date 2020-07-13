@extends('layouts.master')

@push('header-scripts')
    <style>
        .select2-container.select2-container--default.select2-container--open {
            z-index: 9999999 !important;
        }
        .select2{
            width: 100% !important;
        }
    </style>
@endpush

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'User'])
        <li class="breadcrumb-item active">
            <a href="/gate/user">User</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('components.deleteModal', ['name' => 'User data'])
    @endcomponent

    @include('gate::components.user.modal')

    @component('gate::components.index', ['title' => 'Users data'])
        @slot('tableContent')
            <div id="form_result"></div>

            <div class="table-responsive">
                <table id="user-table" class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            @can('create', Modules\Gate\Entities\User::class)
                <div class="col-md-4 offset-md-4 center">
                    <button type="button" id="createUser" class="btn btn-block btn-primary"><strong>Add User</strong></button>
                </div>
            @endcan
        @endslot
    @endcomponent

    @push('footer-scripts')

    <script>
        $(document).ready(function () {
            var userId;

            var table = $('#user-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('gate.user.index')}}",
                },
                columns: [
                    { data: 'username', name: 'username' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'role.role_name', name: 'role.role_name' },
                    { data: 'company.company_name', name: 'company.company_name', defaultContent: "" },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false },
                ]
            });

            $('#createUser').click(function () {
                $('#saveBtn').val("create-user");
                $('#userForm').trigger("reset");
                $('#modalTitle').html("Add New User");
                $('#userModal').modal('show');
                $('div[class^="invalid-feedback-"]').html('');  //hide all alert with pre-string invalid-feedback
                $('#userForm').attr('action', '/gate/user');
                $("#fpassword").parentsUntil('div.modal-body').show();
                $('#fpassword').removeAttr('disabled');
                $("input[value='patch']").remove();
            });

            table.on('click', '.editBtn', function () {
                $('#userForm').trigger("reset");
                $('#modalTitle').html("Edit User");
                userId= $(this).val();
                let tr = $(this).closest('tr');
                let data = table.row(tr).data();

                $("#fpassword").parentsUntil('div.modal-body').hide();
                $('#fpassword').prop( "disabled", true );
                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#userForm');

                $('#fusername').val(data.username);
                $('#fname').val(data.name);
                $('#femail').val(data.email);
                $('#frole').empty();
                $('#frole').append('<option value="' + data.role_id + '" selected>' + data.role.role_name + '</option>');
                $('#fcompany').empty();
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
                placeholder: 'choose a company',
                ajax: {
                    url: "{{route('gate.user.select2.company')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#userModal')
            });
            $('.select2_role').select2({
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
                        $('#saveBtn').html('<strong>Saving...</strong>');
                        $('#saveBtn'). prop('disabled', true);
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
                            $('#form_result').attr('class', 'alert alert-success alert-dismissable fade show font-weight-bold');
                            $('#form_result').html(data.success +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                '    <span aria-hidden="true">&times;</span>\n' +
                                '  </button>');
                        }
                        $('#userModal').modal('hide');
                        $('#user-table').DataTable().ajax.reload();
                    },
                    complete: function () {
                        $('#saveBtn'). prop('disabled', false);
                        $('#saveBtn').html('<strong>Save Changes</strong>');
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
                    },
                    error: function(data){
                        if (data.error) {
                            $('#form_result').attr('class', 'alert alert-danger alert-dismissable fade show font-weight-bold');
                            $('#form_result').html(data.error +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                '    <span aria-hidden="true">&times;</span>\n' +
                                '  </button>');
                            $('#deleteModal').modal('hide');
                            $('#user-table').DataTable().ajax.reload();
                        }
                    },
                    success:function(data){
                        if (data.success){
                            $('#form_result').attr('class', 'alert alert-success alert-dismissable fade show font-weight-bold');
                            $('#form_result').html(data.success +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                '    <span aria-hidden="true">&times;</span>\n' +
                                '  </button>');
                            $('#deleteModal').modal('hide');
                            $('#user-table').DataTable().ajax.reload();
                        }
                    }
                });
            });

        });


    </script>
    @endpush

@endsection
