<!-- Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputForm">
                <div class="modal-body" style="background-color: #eee;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tabs-container">        
                                <div class="tabs-left">
                                    <ul class="nav nav-tabs">
                                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Required Data</a></li>
                                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Optional</a></li>
                                    </ul>
                                    <div class="tab-content ">
                                        <div id="tab-1" class="tab-pane active">
                                            <div class="panel-body">
                                                <div class="row m-b">
                                                    <div class="col">
                                                        <label>MPD Task Card Number</label>
                                                        <input class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label>Task Card Title</label>
                                                        <input class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row m-b">
                                                    <div class="col">
                                                        <label>Task Card Group</label>
                                                        <select class="select2 form-control" name="taskcard-group">
                                                            <option>Basic</option>
                                                            <option>Structure Inspection Program (SIP)</option>
                                                            <option>Corrosion Preventive and Control Program (CPCP)</option>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <label>Task Card Type</label>
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
                                                            you can choose multiple value
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row m-b">                
                                                    <div class="col-lg-12">
                                                        <div class="panel panel-success">
                                                            <div class="panel-heading">
                                                                <i class="fa fa-history"></i>
                                                                &nbsp;Interval to be Controlled
                                                            </div>
                                                            <div class="panel-body" style="margin: 0px; width: 100%">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label>Threshold</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row m-b">
                                                                    <div class="col">
                                                                        <input type="number" class="form-control" placeholder="Flight Hour (FH)">
                                                                    </div>
                                                                    <div class="col">
                                                                        <input type="number" class="form-control" placeholder="Flight Cycle (FC)">
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="input-group">
                                                                            <input type="number" class="form-control">
                                                                            <div class="input-group-append">
                                                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Day Count
                                                                            </button>
                                                                                <div class="dropdown-menu">
                                                                                    <a class="dropdown-item" href="#">Day(s)</a>
                                                                                    <a class="dropdown-item" href="#">Month(s)</a>
                                                                                    <a class="dropdown-item" href="#">Year(s)</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="input-group date">
                                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i><small>&nbsp;Exact Date Based</small></span><input type="text" class="form-control" value="03/04/2014">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label>Repeat</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row m-b">
                                                                    <div class="col">
                                                                        <input type="number" class="form-control" placeholder="Flight Hour (FH)">
                                                                    </div>
                                                                    <div class="col">
                                                                        <input type="number" class="form-control" placeholder="Flight Cycle (FC)">
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="input-group">
                                                                            <input type="number" class="form-control">
                                                                            <div class="input-group-append">
                                                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Day Count
                                                                            </button>
                                                                                <div class="dropdown-menu">
                                                                                    <a class="dropdown-item" href="#">Day(s)</a>
                                                                                    <a class="dropdown-item" href="#">Month(s)</a>
                                                                                    <a class="dropdown-item" href="#">Year(s)</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="input-group date">
                                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i><small>&nbsp;Exact Date Based</small></span><input type="text" class="form-control" value="03/04/2014">
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
                                        <div id="tab-2" class="tab-pane">
                                            <div class="panel-body">
                                                <div class="row m-b">
                                                    <div class="col">
                                                        <label>Company Task Card Number</label>
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
                                                            you can choose multiple value
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
                                                            you can choose multiple value
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
                                                            you can choose multiple value
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
                                                            you can choose multiple value
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row m-b">
                                                    <div class="col">
                                                        <label>Reference</label>
                                                        <input class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label>Document Attach (*.PDF)</label>
                                                        <div class="custom-file">
                                                            <input id="inputGroupFile01" type="file" class="custom-file-input">
                                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                        </div>
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
                                </div>            
                            </div>                              
                        </div>                        
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #fff;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtn">
                        <strong>Save and Next &nbsp;
                            <i class="fa fa-arrow-right"></i>
                        </strong>                        
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('header-scripts')
<style>
    .select2-container.select2-container--default.select2-container--open {
        z-index: 9999999 !important;
    }
    .select2 {
        width: 100% !important;
    }
</style>
@endpush