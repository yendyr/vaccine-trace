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
                                <ul class="nav nav-tabs">
                                    <li>
                                        <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-0" style="min-height: 50px;"><i class="text-danger fa fa-asterisk fa-2x fa-fw"></i>&nbsp;Required Basic Data
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-1" style="min-height: 50px;"><i class="text-danger fa fa-asterisk fa-2x fa-fw"></i>&nbsp;Required Interval Data
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 50px;"><i class="text-warning fa fa-external-link fa-2x fa-fw"></i>&nbsp;Optional
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content ">
                                    <div id="tab-0" class="tab-pane active fadeIn" style="animation-duration: 1.5s">
                                        <div class="panel-body">
                                            <div class="row m-b">
                                                <div class="col">
                                                    <label>MPD/Manufacturer Task Card Number</label>
                                                    <input type="text" class="form-control @error('mpd_number') is-invalid @enderror" name="mpd_number" id="mpd_number">                            
                                                    <div class="invalid-feedback-mpd_number text-danger font-italic"></div>
                                                </div>
                                                <div class="col">
                                                    <label>Task Card Title</label>
                                                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title">                            
                                                    <div class="invalid-feedback-title text-danger font-italic"></div>
                                                </div>
                                                <div class="col">
                                                    <label>Task Card Tag</label>
                                                    <select class="tag_id form-control @error('tag_id') is-invalid @enderror" id="tag_id" name="tag_id[]" multiple="multiple"></select>
                                                    <div class="invalid-feedback-tag_id text-danger font-italic"></div>
                                                    <span class="text-info font-italic">
                                                        <i class="fa fa-info-circle"></i>
                                                        you can choose multiple value
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row m-b">
                                                <div class="col">
                                                    <label>Task Card Group</label>
                                                    <select class="taskcard_group_id form-control @error('taskcard_group_id') is-invalid @enderror" id="taskcard_group_id" name="taskcard_group_id"></select>
                                                    <div class="invalid-feedback-taskcard_group_id text-danger font-italic"></div>
                                                </div>
                                                <div class="col">
                                                    <label>Task Card Type</label>
                                                    <select class="taskcard_type_id form-control @error('taskcard_type_id') is-invalid @enderror" id="taskcard_type_id" name="taskcard_type_id"></select>
                                                    <div class="invalid-feedback-taskcard_type_id text-danger font-italic"></div>
                                                </div>
                                                <div class="col">
                                                    <label>Compliance Type</label>
                                                    <select class="compliance form-control @error('compliance') is-invalid @enderror" name="compliance" id="compliance">
                                                        <option value="Information">Information</option>
                                                        <option value="Optional">Optional</option>
                                                        <option value="Recomended">Recomended</option>
                                                        <option value="Mandatory">Mandatory</option>
                                                    </select>
                                                    <div class="invalid-feedback-compliance text-danger font-italic"></div>
                                                </div>
                                            </div>
                                            <div class="row m-b">
                                                <div class="col">
                                                    <label>Aircraft Type Effectivity</label>
                                                    <select class="aircraft_type_id form-control @error('aircraft_type_id') is-invalid @enderror" name="aircraft_type_id[]" id="aircraft_type_id" multiple="multiple">
                                                    </select>
                                                    <div class="invalid-feedback-aircraft_type_id text-danger font-italic"></div>
                                                    <span class="text-info font-italic">
                                                        <i class="fa fa-info-circle"></i>
                                                        you can choose multiple value
                                                    </span>
                                                </div>

                                                <div class="col">
                                                    <label>Affected Item/Component Part Number</label>
                                                    <select class="affected_item_id form-control @error('affected_item_id') is-invalid @enderror" name="affected_item_id[]" id="affected_item_id" multiple="multiple">
                                                    </select>
                                                    <div class="invalid-feedback-affected_item_id text-danger font-italic"></div>
                                                    <span class="text-info font-italic">
                                                        <i class="fa fa-info-circle"></i>
                                                        you can choose multiple value
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="tab-1" class="tab-pane fadeIn" style="animation-duration: 1.5s">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col">
                                                    <label>Threshold</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="input-group">
                                                    <input type="number" min="0" class="form-control @error('threshold_flight_hour') is-invalid @enderror" name="threshold_flight_hour" id="threshold_flight_hour">
                                                    <div class="input-group-append">
                                                        <span class="input-group-addon">FH</span>
                                                    </div>
                                                    <div class="invalid-feedback-threshold_flight_hour text-danger font-italic"></div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group">
                                                    <input type="number" min="0" class="form-control @error('threshold_flight_cycle') is-invalid @enderror" name="threshold_flight_cycle" id="threshold_flight_cycle">
                                                    <div class="input-group-append">
                                                        <span class="input-group-addon">FC</span>
                                                    </div>
                                                    <div class="invalid-feedback-threshold_flight_cycle text-danger font-italic"></div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group">
                                                        <input type="number" min="0" class="form-control @error('threshold_daily') is-invalid @enderror" name="threshold_daily" id="threshold_daily">
                                                        <div class="input-group-append">
                                                            <select class="threshold_daily_unit form-control @error('threshold_daily_unit') is-invalid @enderror" name="threshold_daily_unit" id="threshold_daily_unit">
                                                                <option value="Day">Day</option>
                                                                <option value="Month">Month</option>
                                                                <option value="Year">Year</option>
                                                            </select>
                                                        </div>
                                                        <div class="invalid-feedback-threshold_daily_unit text-danger font-italic"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group" id="threshold_date">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon">Exact Date</span>
                                                        <input type="text" class="threshold_date form-control @error('threshold_date') is-invalid @enderror" name="threshold_date" id="threshold_date" readonly="true">
                                                        <div class="invalid-feedback-threshold_date text-danger font-italic"></div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <label>Repeat</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="input-group">
                                                    <input type="number" min="0" class="form-control @error('repeat_flight_hour') is-invalid @enderror" name="repeat_flight_hour" id="repeat_flight_hour">
                                                    <div class="input-group-append">
                                                        <span class="input-group-addon">FH</span>
                                                    </div>
                                                    <div class="invalid-feedback-repeat_flight_hour text-danger font-italic"></div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group">
                                                    <input type="number" min="0" class="form-control @error('repeat_flight_cycle') is-invalid @enderror" name="repeat_flight_cycle" id="repeat_flight_cycle">
                                                    <div class="input-group-append">
                                                        <span class="input-group-addon">FC</span>
                                                    </div>
                                                    <div class="invalid-feedback-repeat_flight_cycle text-danger font-italic"></div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group">
                                                        <input type="number" min="0" class="form-control @error('repeat_daily') is-invalid @enderror" name="repeat_daily" id="repeat_daily">
                                                        <div class="input-group-append">
                                                            <select class="repeat_daily_unit form-control @error('repeat_daily_unit') is-invalid @enderror" name="repeat_daily_unit" id="repeat_daily_unit">
                                                                <option value="Day">Day</option>
                                                                <option value="Month">Month</option>
                                                                <option value="Year">Year</option>
                                                            </select>
                                                        </div>
                                                        <div class="invalid-feedback-repeat_daily_unit text-danger font-italic"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group" id="repeat_date">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon">Exact Date</span>
                                                        <input type="text" class="repeat_date form-control @error('repeat_date') is-invalid @enderror" name="repeat_date" id="repeat_date" readonly="true">
                                                        <div class="invalid-feedback-repeat_date text-danger font-italic"></div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <label>Interval Control Method</label>
                                                    <select class="interval_control_method form-control @error('interval_control_method') is-invalid @enderror" name="interval_control_method" id="interval_control_method">
                                                        <option value="Which One Comes First">Which One Comes First</option>
                                                        <option value="Which One Comes Last">Which One Comes Last</option>
                                                    </select>
                                                    <div class="invalid-feedback-interval_control_method text-danger font-italic"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tab-2" class="tab-pane fadeIn" style="animation-duration: 1.5s">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col">
                                                    <label>Company/Local Task Card Number</label>
                                                    <input type="text" class="form-control @error('company_number') is-invalid @enderror" name="company_number" id="company_number">                            
                                                    <div class="invalid-feedback-company_number text-danger font-italic"></div>
                                                </div>
                                                <div class="col">
                                                    <label>ATA</label>
                                                    <input type="text" class="form-control @error('ata') is-invalid @enderror" name="ata" id="ata">                            
                                                    <div class="invalid-feedback-ata text-danger font-italic"></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group" id="issued_date">
                                                    <label>Issued Date</label>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon">Issued Date</span>
                                                        <input type="text" class="issued_date form-control @error('issued_date') is-invalid @enderror" name="issued_date" id="issued_date" readonly="true">
                                                        <div class="invalid-feedback-issued_date text-danger font-italic"></div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row m-b">
                                                <div class="col">
                                                    <label>Version</label>
                                                    <input type="text" class="form-control @error('version') is-invalid @enderror" name="version" id="version">                            
                                                    <div class="invalid-feedback-version text-danger font-italic"></div>
                                                </div>
                                                <div class="col">
                                                    <label>Revision</label>
                                                    <input type="text" class="form-control @error('revision') is-invalid @enderror" name="revision" id="revision">                            
                                                    <div class="invalid-feedback-revision text-danger font-italic"></div>
                                                </div>
                                                <div class="col">
                                                    <label>Effectivity</label>
                                                    <input type="text" class="form-control @error('effectivity') is-invalid @enderror" name="effectivity" id="effectivity">                            
                                                    <div class="invalid-feedback-effectivity text-danger font-italic"></div>
                                                </div>
                                            </div>
                                            <div class="row m-b">
                                                <div class="col">
                                                    <label>Work Area</label>
                                                    <select class="taskcard_workarea_id form-control @error('taskcard_workarea_id') is-invalid @enderror" name="taskcard_workarea_id" id="taskcard_workarea_id">
                                                    </select>
                                                    <div class="invalid-feedback-taskcard_workarea_id text-danger font-italic"></div>
                                                </div>
                                                <div class="col">
                                                    <label>Access</label>
                                                    <select class="taskcard_access_id form-control @error('taskcard_access_id') is-invalid @enderror" name="taskcard_access_id[]" id="taskcard_access_id" multiple="multiple">
                                                    </select>
                                                    <div class="invalid-feedback-taskcard_access_id text-danger font-italic"></div>
                                                    <span class="text-info font-italic">
                                                        <i class="fa fa-info-circle"></i>
                                                        you can choose multiple value
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row m-b">
                                                <div class="col">
                                                    <label>Zone</label>
                                                    <select class="taskcard_zone_id form-control @error('taskcard_zone_id') is-invalid @enderror" name="taskcard_zone_id[]" id="taskcard_zone_id" multiple="multiple">
                                                    </select>
                                                    <div class="invalid-feedback-taskcard_zone_id text-danger font-italic"></div>
                                                    <span class="text-info font-italic">
                                                        <i class="fa fa-info-circle"></i>
                                                        you can choose multiple value
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <label>Source</label>
                                                    <input type="text" class="form-control @error('source') is-invalid @enderror" name="source" id="source">                            
                                                    <div class="invalid-feedback-source text-danger font-italic"></div>
                                                </div>
                                            </div>
                                            <div class="row m-b">
                                                <div class="col">
                                                    <label>Document Library</label>
                                                    <select class="taskcard_document_library_id form-control @error('taskcard_document_library_id') is-invalid @enderror" name="taskcard_document_library_id[]" id="taskcard_document_library_id" multiple="multiple">
                                                    </select>
                                                    <div class="invalid-feedback-taskcard_document_library_id text-danger font-italic"></div>
                                                    <span class="text-info font-italic">
                                                        <i class="fa fa-info-circle"></i>
                                                        you can choose multiple value
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <label>Affected Manual</label>
                                                    <select class="taskcard_affected_manual_id form-control @error('taskcard_affected_manual_id') is-invalid @enderror" name="taskcard_affected_manual_id[]" id="taskcard_affected_manual_id" multiple="multiple">
                                                    </select>
                                                    <div class="invalid-feedback-taskcard_affected_manual_id text-danger font-italic"></div>
                                                    <span class="text-info font-italic">
                                                        <i class="fa fa-info-circle"></i>
                                                        you can choose multiple value
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row m-b">
                                                <div class="col">
                                                    <label>Reference</label>
                                                    <input type="text" class="form-control @error('reference') is-invalid @enderror" name="reference" id="reference">                            
                                                    <div class="invalid-feedback-reference text-danger font-italic"></div>
                                                </div>
                                                <div class="col">
                                                    <label>Document Attach (*.PDF)</label>
                                                    <div class="custom-file">
                                                        <input id="file_attachment" type="file" class="custom-file-input" name="file_attachment">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row m-b">
                                                <div class="col">
                                                    <label>Scheduled Priority</label>
                                                    <select class="scheduled_priority form-control @error('scheduled_priority') is-invalid @enderror" name="scheduled_priority" id="scheduled_priority">
                                                        <option value="Next Check / Workshop Visit">Next Check / Workshop Visit</option>
                                                        <option value="Next Heavy Maintenance Visit">Next Heavy Maintenance Visit</option>
                                                        <option value="As Scheduled">As Scheduled</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label>Recurrence</label>
                                                    <select class="recurrence form-control @error('recurrence') is-invalid @enderror" name="recurrence" id="recurrence">
                                                        <option value="One Time">One Time</option>
                                                        <option value="As Required">As Required</option>
                                                        <option value="Repetitive">Repetitive</option>
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

                <div class="modal-footer" style="background-color: #fff;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtn">
                        <strong>Save New</strong>                        
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
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    var mem_repeat = $('#repeat_date .input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    var mem_issued = $('#issued_date .input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
</script>
@endpush