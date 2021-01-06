@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb',
                ['name' => 'Create/Edit Taskcard',
                'href' => '/ppc/taskcard/create',
                ])
                
            <button type="button" class="btn btn-warning btn-lg">
                <i class="fa fa-chevron-circle-left"></i> Back
            </button>
    @endcomponent
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="ibox-title">
            <h5>Required Information Field</h5>
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
            Content 1
        </div>
        {{-- <div class="ibox">
            <div class="ibox-title">
                <h4 class="text-center">Create/Edit Routine Taskcard</h4>

                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="fullscreen-link">
                        <i class="fa fa-expand"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-footer">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <i class="fa fa-info-circle"></i> Required Field
                            </div>
                            <div class="panel-body">
                                <div class="col">
                                    <div class="form-group">
                                        <label>MPD Taskcard Number</label>
                                        <input placeholder="Enter MPD Taskcard Number" class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Company Taskcard Number</label>
                                        <input placeholder="Enter Company Taskcard Number" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Taskcard Number Title</label>
                            <input placeholder="Enter MPD Taskcard Title" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Taskcard Group</label>
                            <select class="form-control" name="taskcard-group">
                                <option>Basic</option>
                                <option>Structure Inspection Program (SIP)</option>
                                <option>Corrosion Preventive and Control Program (CPCP)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="col-lg-6">
        <div class="ibox-title">
            <h5>Optional Information Field</h5>
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
            Content
        </div>
    </div>
</div>
@endsection