@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Skill'])
    @can('create', Modules\QualityAssurance\Entities\Skill::class)
        <button type="button" id="createSkill" class="btn btn-primary btn-lg"><i class="fa fa-plus-circle"></i>&nbsp;Create New</button>
    @endcan
    @endcomponent
@endsection

@section('content')
    @component('components.delete-modal', ['name' => 'Skill Datalist'])
    @endcomponent

    @include('qualityassurance::pages.skill.modal')

    @component('components.crud-form.index', ['title' => 'Skill Datalist'])
        @slot('tableContent')
            <div id="form_result" role="alert"></div>
            
            <div class="table-responsive">
                <table id="skill-table" class="table table-hover table-striped text-center">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Skill Name</th>
                            <th>Description/Remark</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Last Updated By</th>
                            <th>Last Updated At</th>
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

    @include('qualityassurance::components.skill._script')

@endsection

@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush