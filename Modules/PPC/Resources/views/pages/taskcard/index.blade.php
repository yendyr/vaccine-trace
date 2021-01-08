@extends('layouts.master')

@section('page-heading')
        {{-- @can('create', \Modules\HumanResources\Entities\Employee::class) --}}
            <a type="button" id=" " class="btn btn-primary btn-lg" href="/ppc/taskcard/create">
                <i class="fa fa-plus-square"></i> Add New Task Card
            </a>
        {{-- @endcan --}}
@endsection

@section('content')
<div class="ibox">
    <div class="ibox-title text-center">
        <h5>Task Card Datalist</h5>
        <div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
            <a class="fullscreen-link">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>MPD Number</th>
                        <th>Company Task Number</th>
                        <th>Title</th>
                        <th>Task Card Group</th>
                        <th>Task Card Type</th>
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
    </div>
</div>
@endsection