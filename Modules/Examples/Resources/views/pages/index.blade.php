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

    @include('examples::components.example._script')

@endsection
