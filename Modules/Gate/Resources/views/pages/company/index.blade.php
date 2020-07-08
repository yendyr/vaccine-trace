@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Company'])
        <li class="breadcrumb-item active">
            <a href="/gate/company">Company</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('components.deleteModal', ['name' => 'Company data'])
    @endcomponent

    @component('gate::components.index', ['title' => 'Companies data'])

        @slot('tableContent')
        <div class="table-responsive">
            <table id="company-table" class="table table-hover text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Email</th>
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
        <div class="col-md-4 offset-md-4 center">
            <a href="{{ route('gate.company.create')}}" class="btn btn-block btn-primary"><strong>Add Company</strong></a>
        </div>
        @endslot
    @endcomponent

    @push('footer-scripts')
        <script>
            $(document).ready(function () {
                $('#company-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('gate.company.index')}}",
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'company_name', name: 'name'  },
                        { data: 'code', name: 'code'  },
                        { data: 'email', name: 'email' },
                        { data: 'action', name: 'action', orderable: false },
                    ]
                });
            });

            var companyId;

            $(document).on('click', '.delete', function () {
                companyId = $(this).attr('id');
                $('#deleteModal').modal('show');
                $('#delete-form').attr('action', "company/"+ companyId);
            });

            function deletion() {
                $('#delete-button').click(function () {
                    $("form[name='deleteForm']").submit();
                });
            }

        </script>
    @endpush

@endsection
