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
            <h5>Required Information Field <span class="text-danger">*</span></h5>
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
            <div class="row m-b">
                <div class="col">
                    <label>MPD Taskcard Number</label>
                    <input class="form-control">
                </div>
                <div class="col">
                    <label>Taskcard Title</label>
                    <input class="form-control">
                </div>
            </div>
            <div class="row m-b">
                <div class="col">
                    <label>Taskcard Group</label>
                    <select class="select2 form-control" name="taskcard-group">
                        <option>Basic</option>
                        <option>Structure Inspection Program (SIP)</option>
                        <option>Corrosion Preventive and Control Program (CPCP)</option>
                    </select>
                </div>
                <div class="col">
                    <label>Taskcard Type</label>
                    <select class="select2 form-control" name="taskcard-type">
                        <option>Inspection</option>
                        <option>Service</option>
                        <option>Visual Check</option>
                    </select>
                </div>
            </div>
            <div class="row m-b">
                <div class="col">
                    <label>Aircraft Type Effectivity</label>
                    <select class="select2 form-control" name="taskcard-aircraft" multiple="multiple">
                        <option>Boeing 737-900ER</option>
                        <option>Boeing 737-800NG</option>
                        <option>Airbus A320-300</option>
                    </select>
                    <span class="text-info font-italic">
                        <i class="fa fa-info-circle"></i>
                        you can chose multiple value
                    </span>
                </div>
            </div>
            <div class="row m-b">                
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Interval to be Controlled
                        </div>
                        <div class="panel-body">
                            <div class="row m-b">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col">
                                            <label>Threshold</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><small>Flight Hour (FH)</small></span>
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <input type="number" class="form-control">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><small>Flight Cycle (FC)</small></span>
                                                </div>
                                            </div>                                            
                                            <div class="input-group">
                                                <input type="number" class="form-control">
                                                <div class="input-group-append">
                                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Daily Based</button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Day(s)</a>
                                                        <a class="dropdown-item" href="#">Month(s)</a>
                                                        <a class="dropdown-item" href="#">Year(s)</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i><small>&nbsp;Exact Date Based</small></span><input type="text" class="form-control" value="03/04/2014">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col">
                                            <label>Repeat</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><small>Flight Hour (FH)</small></span>
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <input type="number" class="form-control">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><small>Flight Cycle (FC)</small></span>
                                                </div>
                                            </div>                                            
                                            <div class="input-group">
                                                <input type="number" class="form-control">
                                                <div class="input-group-append">
                                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Daily Based</button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Day(s)</a>
                                                        <a class="dropdown-item" href="#">Month(s)</a>
                                                        <a class="dropdown-item" href="#">Year(s)</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i><small>&nbsp;Exact Date Based</small></span><input type="text" class="form-control" value="03/04/2014">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col">
                                    <label>Interval Control Method</label>
                                        <select class="select2 form-control" name="taskcard-type">
                                            <option>Which One Comes First</option>
                                            <option>Which One Comes Last</option>
                                        </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
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
            <div class="row m-b">
                <div class="col">
                    <label>Company Taskcard Number</label>
                    <input class="form-control">
                </div>
                <div class="col">
                    <label>ATA</label>
                    <input class="form-control">
                </div>
            </div>
            <div class="row m-b">
                <div class="col">
                    <label>Version</label>
                    <input class="form-control">
                </div>
                <div class="col">
                    <label>Revision</label>
                    <input class="form-control">
                </div>
                <div class="col">
                    <label>Effectivity</label>
                    <input class="form-control">
                </div>
            </div>
            <div class="row m-b">
                <div class="col">
                    <label>Work Area</label>
                    <select class="select2 form-control" name="taskcard-workarea">
                        <option>AC Dist Bay</option>
                        <option>AFT Cargo Bay</option>
                        <option>Cabin</option>
                    </select>
                </div>
                <div class="col">
                    <label>Access</label>
                    <select class="select2 form-control" name="taskcard-access" multiple="multiple">
                        <option>291AT</option>
                        <option>293AT</option>
                        <option>325CL</option>
                    </select>
                    <span class="text-info font-italic">
                        <i class="fa fa-info-circle"></i>
                        you can chose multiple value
                    </span>
                </div>
            </div>
            <div class="row m-b">
                <div class="col">
                    <label>Zone</label>
                    <select class="select2 form-control" name="taskcard-zone" multiple="multiple">
                        <option>101</option>
                        <option>102</option>
                        <option>103</option>
                    </select>
                    <span class="text-info font-italic">
                        <i class="fa fa-info-circle"></i>
                        you can chose multiple value
                    </span>
                </div>
                <div class="col">
                    <label>Source</label>
                    <input class="form-control">
                </div>
            </div>
            <div class="row m-b">
                <div class="col">
                    <label>Document Library</label>
                    <select class="select2 form-control" name="taskcard-document-library" multiple="multiple">
                        <option>Free Input</option>
                        <option>Free Input 1</option>
                        <option>Free Input 2</option>
                    </select>
                    <span class="text-info font-italic">
                        <i class="fa fa-info-circle"></i>
                        you can chose multiple value
                    </span>
                </div>
                <div class="col">
                    <label>Manual Affected</label>
                    <select class="select2 form-control" name="taskcard-manual-affected" multiple="multiple">
                        <option>AMM</option>
                        <option>CMM</option>
                        <option>IPC</option>
                    </select>
                    <span class="text-info font-italic">
                        <i class="fa fa-info-circle"></i>
                        you can chose multiple value
                    </span>
                </div>
            </div>
            <div class="row m-b">
                <div class="col">
                    <label>Reference</label>
                    <input class="form-control">
                </div>
            </div>
            <div class="row m-b">
                <div class="col">
                    <label>Scheduled Priority</label>
                    <select class="select2 form-control" name="taskcard-scheduled-priority">
                        <option>Next Check / Workshop Visit</option>
                        <option>Next Heavy Maintenance Visit</option>
                        <option>As Scheduled</option>
                    </select>
                </div>
                <div class="col">
                    <label>Recurrence</label>
                    <select class="select2 form-control" name="taskcard-recurrence">
                        <option>One Time</option>
                        <option>As Required</option>
                        <option>Repetitive</option>
                    </select>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@push('footer-scripts')
<script>
   $(".select2").select2({
        theme: 'bootstrap4',
    }); 
</script>
@endpush