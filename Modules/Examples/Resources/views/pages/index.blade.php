@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Example'])
        <li class="breadcrumb-item active">
            <a href="/examples/example">Example</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('components.delete-modal', ['name' => 'Example data'])
    @endcomponent

    @include('components.approve-modal')

    @include('examples::components.example.modal')

    @component('examples::components.index', ['title' => 'Examples data'])
        @slot('tableContent')
            <div id="form_result" role="alert"></div>

            <div class="table-responsive">
                <table id="example-table" class="table table-hover text-center">
                    <thead>
                        <tr class="text-center">
                            <th>Name</th>
                            <th>Code</th>
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
            @can('create', Modules\Examples\Entities\Example::class)
                <div class="col-md-4 offset-md-4 center">
                    <button type="button" id="createExample" class="btn btn-block btn-primary"><strong>Add Example Data</strong></button>
                </div>
            @endcan
        @endslot
    @endcomponent

    @push('footer-scripts')
        <script>
            $(document).ready(function () {
                var exampleId;

                var table = $('#example-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('examples.example.index')}}",
                    },
                    columns: [
                        // { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'name', name: 'name' },
                        { data: 'code', name: 'code' },
                        { data: 'status', name: 'status' },
                        { data: 'action', name: 'action', orderable: false },
                    ]
                });

                $('#createExample').click(function () {
                    $('#saveBtn').val("create-example");
                    $('#exampleForm').trigger("reset");
                    $('#modalTitle').html("Add New Example data");
                    $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                    $('#exampleModal').modal('show');
                    $('#exampleForm').attr('action', '/examples/example');
                    $("input[value='patch']").remove();
                });

                table.on('click', '.editBtn', function () {
                    $('#exampleForm').trigger("reset");
                    $('#modalTitle').html("Edit Example");
                    exampleId= $(this).val();
                    let tr = $(this).closest('tr');
                    let data = table.row(tr).data();

                    $('<input>').attr({
                        type: 'hidden',
                        name: '_method',
                        value: 'patch'
                    }).prependTo('#exampleForm');

                    $('#fname').val(data.name);
                    $('#fcode').val(data.code);
                    $('#fstatus').find('option').removeAttr('selected');
                    if (data.status == '<p class="text-success">Active</p>'){
                        $('#fstatus').find('option[value="1"]').attr('selected', '');
                    }else{
                        $('#fstatus').find('option[value="0"]').attr('selected', '');
                    }

                    $('#saveBtn').val("edit-example");
                    $('#exampleForm').attr('action', '/examples/example/' + data.id);

                    $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                    $('#exampleModal').modal('show');
                });

                $('#exampleForm').on('submit', function (event) {
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
                            $('#saveBtn').prop('disabled', true);
                        },
                        success:function(data){
                            if (data.success) {
                                $('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                                $('#form_result').html(data.success +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                    '    <span aria-hidden="true">&times;</span>\n' +
                                    '  </button>');
                            }
                            $('#exampleModal').modal('hide');
                            $('#example-table').DataTable().ajax.reload();
                        },
                        error:function(data){
                            let errors = data.responseJSON.errors;
                            if (errors) {
                                $.each(errors, function (index, value) {
                                    $('div.invalid-feedback-'+index).html(value);
                                })
                            }
                        },
                        complete:function(){
                            $('#saveBtn').prop('disabled', false);
                            $('#saveBtn').html('<strong>Save Changes</strong>');
                        }
                    });
                });

                table.on('click', '.deleteBtn', function () {
                    exampleId = $(this).val();
                    $('#deleteModal').modal('show');
                    $('#delete-form').attr('action', "/examples/example/"+ exampleId);
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
                            $('#example-table').DataTable().ajax.reload();
                        }
                    });
                });

                $('[data-toggle="tooltip"]').tooltip();

                table.on('click', '.approveBtn', function () {
                    exampleId = $(this).val();
                    $('#approveModal').modal('show');
                    $('#approve-form').attr('action', "/examples/example/approve/"+ exampleId);
                    let titleApprove = $(this).attr('title');
                    $('div.approve-content').html('Are you sure want to ' + titleApprove + ' this Example data?');
                });

                $('#approve-form').on('submit', function (e) {
                    e.preventDefault();
                    let url_action = $(this).attr('action');
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $(
                                'meta[name="csrf-token"]'
                            ).attr("content")
                        },
                        url: url_action,
                        beforeSend:function(){
                            $('#approve-button').text('Approving...');
                            $('#approve-button').prop('disabled', true);
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
                        complete:function(){
                            $('#approve-button').text('Approve');
                            $('#approveModal').modal('hide');
                            $('#approve-button').prop('disabled', false);
                            $('#example-table').DataTable().ajax.reload();
                        }
                    });
                });
            });

        </script>
    @endpush

@endsection
