@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Company'])
        <li class="breadcrumb-item active">
            <a href="/gate/company">Company</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('components.delete-modal', ['name' => 'Company data'])
    @endcomponent

    @component('gate::components.index', ['title' => 'Companies data'])
        @slot('tableContent')
        <div id="form_result"></div>

        <div class="table-responsive">
            <table id="company-table" class="table table-hover text-center">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Email</th>
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
        @can('create', Modules\Gate\Entities\Company::class)
            <div class="col-md-4 offset-md-4 center">
                <a href="{{ route('gate.company.create')}}" class="btn btn-block btn-primary"><strong>Add Company</strong></a>
            </div>
        @endcan
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
                                $('#form_result').attr('class', 'alert alert-danger alert-dismissable fade show font-weight-bold');
                                $('#form_result').html(data.error +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                    '    <span aria-hidden="true">&times;</span>\n' +
                                    '  </button>');
                            }
                        },
                        success:function(data){
                            if (data.success){
                                $('#form_result').attr('class', 'alert alert-success alert-dismissable fade show font-weight-bold');
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
                            $('#company-table').DataTable().ajax.reload();
                        }
                    });
                });
            });


        </script>
    @endpush

@endsection
