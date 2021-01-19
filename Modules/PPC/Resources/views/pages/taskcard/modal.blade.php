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
                                        <li>
                                            <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-1" style="min-height: 75px;"><i class="text-danger fa fa-asterisk fa-2x fa-fw"></i>&nbsp;Required Data
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 75px;"><i class="fa fa-external-link fa-2x fa-fw"></i>&nbsp;Optional
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content ">
                                        <div id="tab-1" class="tab-pane active fadeIn" style="animation-duration: 1.5s">
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
                                                        <select class="taskcard_group form-control @error('taskcard_group') is-invalid @enderror" id="taskcard_group" name="taskcard_group"></select>
                                                        <div class="invalid-feedback-taskcard_group text-danger font-italic"></div>
                                                    </div>
                                                    <div class="col">
                                                        <label>Task Card Type</label>
                                                        <select class="taskcard_type form-control @error('taskcard_type') is-invalid @enderror" id="taskcard_type" name="taskcard_type"></select>
                                                        <div class="invalid-feedback-taskcard_type text-danger font-italic"></div>
                                                    </div>
                                                </div>
                                                <div class="row m-b">
                                                    <div class="col">
                                                        <label>Aircraft Type Effectivity</label>
                                                        <select class="aircraft_type form-control @error('aircraft_type') is-invalid @enderror" name="aircraft_type" id="aircraft_type" multiple="multiple">
                                                        </select>
                                                        <div class="invalid-feedback-aircraft_type text-danger font-italic"></div>
                                                        <span class="text-info font-italic">
                                                            <i class="fa fa-info-circle"></i>
                                                            you can choose multiple value
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row m-b">                
                                                    <div class="col-lg-12">
                                                        <div class="panel panel-danger">
                                                            <div class="panel-heading">
                                                                <i class="fa fa-exclamation-circle fw"></i>
                                                                &nbsp;Control Parameter (Interval)
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
                                                                                <span class="input-group-addon">Day</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group" id="threshold_date">
                                                                        <div class="input-group date">
                                                                            <span class="input-group-addon">Exact Date</span>
                                                                            <input type="text" class="form-control" value="03/04/2021">
                                                                        </div>
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
                                                                                <span class="input-group-addon">Day</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group" id="repeat_date">
                                                                            <div class="input-group date">
                                                                                <span class="input-group-addon">Exact Date</span>
                                                                                <input type="text" class="form-control" value="03/04/2021">
                                                                            </div>
                                                                            </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row m-b">
                                                                    <div class="col">
                                                                        <label>Interval Control Method</label>
                                                                            <select class="interval_control_method form-control" name="taskcard-type">
                                                                                <option value="1">Which One Comes First</option>
                                                                                <option value="2">Which One Comes Last</option>
                                                                            </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tab-2" class="tab-pane fadeIn" style="animation-duration: 1.5s">
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
                                                        <select class="work_area form-control @error('work_area') is-invalid @enderror" name="work_area" id="work_area">
                                                        </select>
                                                        <div class="invalid-feedback-work_area text-danger font-italic"></div>
                                                    </div>
                                                    <div class="col">
                                                        <label>Access</label>
                                                        <select class="access form-control @error('access') is-invalid @enderror" name="access" id="access" multiple="multiple">
                                                        </select>
                                                        <div class="invalid-feedback-access text-danger font-italic"></div>
                                                        <span class="text-info font-italic">
                                                            <i class="fa fa-info-circle"></i>
                                                            you can choose multiple value
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row m-b">
                                                    <div class="col">
                                                        <label>Zone</label>
                                                        <select class="zone form-control @error('zone') is-invalid @enderror" name="zone" id="zone" multiple="multiple">
                                                        </select>
                                                        <div class="invalid-feedback-zone text-danger font-italic"></div>
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
                                                        <select class="document_library form-control @error('document_library') is-invalid @enderror" name="document_library" id="document_library" multiple="multiple">
                                                        </select>
                                                        <div class="invalid-feedback-document_library text-danger font-italic"></div>
                                                        <span class="text-info font-italic">
                                                            <i class="fa fa-info-circle"></i>
                                                            you can choose multiple value
                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <label>Manual Affected</label>
                                                        <select class="manual_affected form-control @error('manual_affected') is-invalid @enderror" name="manual_affected" id="manual_affected" multiple="multiple">
                                                        </select>
                                                        <div class="invalid-feedback-manual_affected text-danger font-italic"></div>
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
                                                        <select class="scheduled_priority form-control" name="scheduled_priority">
                                                            <option value="1">Next Check / Workshop Visit</option>
                                                            <option value="2">Next Heavy Maintenance Visit</option>
                                                            <option value="3">As Scheduled</option>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <label>Recurrence</label>
                                                        <select class="recurrence form-control" name="recurrence">
                                                            <option value="1">One Time</option>
                                                            <option value="2">As Required</option>
                                                            <option value="3">Repetitive</option>
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
<link href="{{ URL::asset('theme/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<style>
    .select2-container.select2-container--default.select2-container--open {
        z-index: 9999999 !important;
    }
    .select2 {
        width: 100% !important;
    }
</style>
@endpush

@push('footer-scripts')
<script src="{{ URL::asset('theme/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script>
    var mem_threshold = $('#threshold_date .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    var mem_repeat = $('#repeat_date .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
</script>
@endpush