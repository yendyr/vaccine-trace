@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb',
                ['name' => 'Routine Taskcard',
                'href' => '/ppc/taskcard/routine',
                ])
        {{-- @can('create', \Modules\HumanResources\Entities\Employee::class) --}}
            <button type="button" id=" " class="btn btn-primary btn-lg">
                <i class="fa fa-plus-square"></i> Add New Routine Taskcard
            </button>
        {{-- @endcan --}}
    @endcomponent
@endsection

@section('content')

    @component('gate::components.index', ['title' => 'Routine Taskcard Datalist'])
        @slot('tableContent')
        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>MPD Number</th>
                        <th>Company Task Number</th>
                        <th>Title</th>
                        <th>Taskcard Group</th>
                        <th>Taskcard Type</th>
                        <th>Aircraft Type</th>
                        <th>Skill</th>
                        <th>Manhours Est.</th>
                        <th>Access</th>
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
        @endslot
    @endcomponent

    @push('footer-scripts')
        <script>
            $(document).ready(function () {
                var table = $('#company-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('gate.company.index')}}",
                    },
                    columns: [
                        { data: 'company_name', name: 'name'  },
                        { data: 'code', name: 'code'  },
                        { data: 'email', name: 'email' },
                        { data: 'status', name: 'status' },
                        { data: 'action', name: 'action', orderable: false },
                    ]
                });

                var companyId;
                table.on('click', '.delete', function () {
                    companyId = $(this).attr('id');
                    $('#deleteModal').modal('show');
                    $('#delete-form').attr('action', "company/"+ companyId);
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
                            $('#company-table').DataTable().ajax.reload();
                        }
                    });
                });
            });


        </script>
    @endpush

@endsection