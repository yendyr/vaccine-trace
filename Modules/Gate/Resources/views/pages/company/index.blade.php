@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Company Datalist'])
    @endcomponent

    @component('components.crud-form.index', ['title' => 'Company Datalist'])
        @slot('tableContent')
            <div id="form_result"></div>
            <div class="p-4 d-flex justify-content-end" style="font-size:14px;">
                @can('create', Modules\Gate\Entities\Company::class)
                    <a href="{{ route('gate.company.create')}}" class="btn btn-primary"><i class="fa fa-plus-circle"></i>&nbsp;<strong>Company</strong></a>
                @endcan
            </div>
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

@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush