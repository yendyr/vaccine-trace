@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Role'])
        <li class="breadcrumb-item active">
            <a href="/gate/role">Role</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('components.delete-modal', ['name' => 'Role data'])
    @endcomponent

    @include('gate::components.role.modal')

    @component('gate::components.index', ['title' => 'Roles data'])
        @slot('tableContent')
            <div id="form_result" role="alert"></div>

            <div class="table-responsive">
                <table id="role-table" class="table table-hover text-center">
                    <thead>
                        <tr class="text-center">
                            <th>Role Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr></tr>
                    </tfoot>
                </table>
            </div>
            @can('create', Modules\Gate\Entities\Role::class)
                <div class="col-md-4 offset-md-4 center">
                    <button type="button" id="createRole" class="btn btn-block btn-primary"><strong>Add Role</strong></button>
                </div>
            @endcan
        @endslot
    @endcomponent

    @push('footer-scripts')
        <script>
            $(document).ready(function () {
                var roleId;

                var table = $('#role-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('gate.role.index')}}",
                    },
                    columns: [
                        // { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'role_name', name: 'role_name' },
                        { data: 'status', name: 'status' },
                        { data: 'action', name: 'action', orderable: false },
                    ]
                });

                $('#createRole').click(function () {
                    $('#saveBtn').val("create-role");
                    $('#roleForm').trigger("reset");
                    $('#modalTitle').html("Add New Role");
                    $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                    $('#roleModal').modal('show');
                    $('#roleForm').attr('action', '/gate/role');
                    $("input[value='patch']").remove();
                });

                table.on('click', '.editBtn', function () {
                    $('#roleForm').trigger("reset");
                    $('#modalTitle').html("Edit Role");
                    roleId= $(this).val();
                    let tr = $(this).closest('tr');
                    let data = table.row(tr).data();

                    $('<input>').attr({
                        type: 'hidden',
                        name: '_method',
                        value: 'patch'
                    }).prependTo('#roleForm');

                    $('#frolename').val(data.role_name);
                    $('#fstatus').find('option').removeAttr('selected');
                    if (data.status == '<p class="text-success">Active</p>'){
                        $('#fstatus').find('option[value="1"]').attr('selected', '');
                    }else{
                        $('#fstatus').find('option[value="0"]').attr('selected', '');
                    }

                    $('#saveBtn').val("edit-role");
                    $('#roleForm').attr('action', '/gate/role/' + data.id);

                    $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                    $('#roleModal').modal('show');
                });

                $('#roleForm').on('submit', function (event) {
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
                            $('#saveBtn').html('<strong>Saving...</strong>');
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
                                $('#form_result').html(data.success +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                    '    <span aria-hidden="true">&times;</span>\n' +
                                    '  </button>');
                            }
                            $('#roleModal').modal('hide');
                            $('#role-table').DataTable().ajax.reload();
                        },
                        complete: function () {
                            $('#saveBtn'). prop('disabled', false);
                            $('#saveBtn').html('<strong>Save Changes</strong>');
                        }
                    });
                });

                table.on('click', '.deleteBtn', function () {
                    roleId = $(this).val();
                    $('#deleteModal').modal('show');
                    $('#delete-form').attr('action', "/gate/role/"+ roleId);
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
                                $('#form_result').html(data.error +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                    '    <span aria-hidden="true">&times;</span>\n' +
                                    '  </button>');
                            }
                        },
                        success:function(data){
                            if (data.success){
                                $('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                                $('#form_result').html(data.success +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                    '    <span aria-hidden="true">&times;</span>\n' +
                                    '  </button>');
                            }
                        },
                        complete: function(data) {
                            $('#delete-button').text('Delete');
                            $('#deleteModal').modal('hide');
                            $('#delete-button').prop('disabled', false);
                            $('#role-table').DataTable().ajax.reload();
                        }
                    });
                });
            });


        </script>
    @endpush

@endsection
