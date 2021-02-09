<!-- Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                                        <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-1" style="min-height: 50px;"><i class="text-danger fa fa-asterisk fa-2x fa-fw"></i>&nbsp;Required Data
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 50px;"><i class="text-warning fa fa-external-link fa-2x fa-fw"></i>&nbsp;Optional
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content ">
                                    <div id="tab-1" class="tab-pane active fadeIn" style="animation-duration: 1.5s">
                                        <div class="panel-body">
                                            <div class="row m-b">
                                                <div class="col-md-6">
                                                    <label>Aircraft</label>
                                                    <select class="aircraft_configuration_id form-control @error('aircraft_configuration_id') is-invalid @enderror" id="aircraft_configuration_id" name="aircraft_configuration_id"></select>
                                                    <div class="invalid-feedback-aircraft_configuration_id text-danger font-italic"></div>
                                                </div>   

                                                <div class="col-md-6">
                                                    <label>Transaction Date</label>
                                                    <div class="form-group" id="transaction_date" style="width: 100%;">
                                                        <div class="input-group date">
                                                            <span class="input-group-addon">Date</span>
                                                            <input type="text" class="transaction_date form-control @error('transaction_date') is-invalid @enderror" name="transaction_date" id="transaction_date" readonly="true" required>
                                                        </div>
                                                        <div class="invalid-feedback-transaction_date text-danger font-italic"></div>
                                                    </div>
                                                </div> 
                                            </div> 
                                                
                                            <div class="row m-b">
                                                <div class="col-md-6">
                                                    <label>Continuos from Page</label>
                                                    <input type="text" class="form-control @error('previous_page_number') is-invalid @enderror" id="previous_page_number" name="previous_page_number"></select>
                                                    <div class="invalid-feedback-previous_page_number text-danger font-italic"></div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label>Current Page Number</label>
                                                    <input type="text" class="form-control @error('page_number') is-invalid @enderror" id="page_number" name="page_number" required></select>
                                                    <div class="invalid-feedback-page_number text-danger font-italic"></div>
                                                </div>
                                            </div>

                                            <div class="row m-b">
                                                <div class="col-md-6">
                                                    <label>Last Inspection Date</label>
                                                    <div class="form-group" id="last_inspection" style="width: 100%;">
                                                        <div class="input-group date">
                                                            <span class="input-group-addon">Date</span>
                                                            <input type="text" class="last_inspection form-control @error('last_inspection') is-invalid @enderror" name="last_inspection" id="last_inspection" readonly="true">
                                                            <div class="invalid-feedback-last_inspection text-danger font-italic"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label>Next Inspection Date</label>
                                                    <div class="form-group" id="next_inspection" style="width: 100%;">
                                                        <div class="input-group date">
                                                            <span class="input-group-addon">Date</span>
                                                            <input type="text" class="next_inspection form-control @error('next_inspection') is-invalid @enderror" name="next_inspection" id="next_inspection" readonly="true">
                                                            <div class="invalid-feedback-next_inspection text-danger font-italic"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tab-2" class="tab-pane fadeIn" style="animation-duration: 1.5s">
                                        <div class="panel-body">
                                            <div class="row m-b">
                                                <div class="col-md-12">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">
                                                            <i class="fa fa-arrow-circle-o-left"></i> &nbsp;Pre-Flight Check
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="row m-b">
                                                                <div class="col-md-3">
                                                                    <label>Check Date</label>
                                                                    <div class="form-group" id="pre_flight_check_date" style="width: 100%;">
                                                                        <div class="input-group date">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </span>
                                                                            <input type="text" class="pre_flight_check_date form-control @error('pre_flight_check_date') is-invalid @enderror" name="pre_flight_check_date" id="pre_flight_check_date" readonly="true">
                                                                            <div class="invalid-feedback-pre_flight_check_date text-danger font-italic"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label>Place</label>
                                                                    <input type="text" class="form-control @error('pre_flight_check_place') is-invalid @enderror" id="pre_flight_check_place" name="pre_flight_check_place"></select>
                                                                    <div class="invalid-feedback-pre_flight_check_place text-danger font-italic"></div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label>Nearest Known Airport</label>
                                                                    <select class="pre_flight_check_nearest_airport_id form-control @error('pre_flight_check_nearest_airport_id') is-invalid @enderror" id="pre_flight_check_nearest_airport_id" name="pre_flight_check_nearest_airport_id"></select>
                                                                    <div class="invalid-feedback-pre_flight_check_nearest_airport_id text-danger font-italic"></div>
                                                                </div> 
                                                            </div>

                                                            <div class="row m-b">
                                                                <div class="col-md-6">
                                                                    <label>Checked by</label>
                                                                    <select class="pre_flight_check_person_id form-control @error('pre_flight_check_person_id') is-invalid @enderror" id="pre_flight_check_person_id" name="pre_flight_check_person_id"></select>
                                                                    <div class="invalid-feedback-pre_flight_check_person_id text-danger font-italic"></div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label>Compressor Wash Done</label>
                                                                    <select class="pre_flight_check_compressor_wash form-control @error('pre_flight_check_compressor_wash') is-invalid @enderror" name="pre_flight_check_compressor_wash" id="pre_flight_check_compressor_wash">
                                                                        <option value="Yes">Yes</option>
                                                                        <option value="No">No</option>
                                                                    </select>
                                                                    <div class="invalid-feedback-pre_flight_check_compressor_wash text-danger font-italic"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row m-b">
                                                <div class="col-md-12">
                                                    <div class="panel panel-success">
                                                        <div class="panel-heading">
                                                            <i class="fa fa-arrow-circle-o-right"></i> &nbsp;Post-Flight Check
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="row m-b">
                                                                <div class="col-md-3">
                                                                    <label>Check Date</label>
                                                                    <div class="form-group" id="post_flight_check_date" style="width: 100%;">
                                                                        <div class="input-group date">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </span>
                                                                            <input type="text" class="post_flight_check_date form-control @error('post_flight_check_date') is-invalid @enderror" name="post_flight_check_date" id="post_flight_check_date" readonly="true">
                                                                            <div class="invalid-feedback-post_flight_check_date text-danger font-italic"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label>Place</label>
                                                                    <input type="text" class="form-control @error('post_flight_check_place') is-invalid @enderror" id="post_flight_check_place" name="post_flight_check_place"></select>
                                                                    <div class="invalid-feedback-post_flight_check_place text-danger font-italic"></div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label>Nearest Known Airport</label>
                                                                    <select class="post_flight_check_nearest_airport_id form-control @error('post_flight_check_nearest_airport_id') is-invalid @enderror" id="post_flight_check_nearest_airport_id" name="post_flight_check_nearest_airport_id"></select>
                                                                    <div class="invalid-feedback-post_flight_check_nearest_airport_id text-danger font-italic"></div>
                                                                </div> 
                                                            </div>

                                                            <div class="row m-b">
                                                                <div class="col-md-6">
                                                                    <label>Checked by</label>
                                                                    <select class="post_flight_check_person_id form-control @error('post_flight_check_person_id') is-invalid @enderror" id="post_flight_check_person_id" name="post_flight_check_person_id"></select>
                                                                    <div class="invalid-feedback-post_flight_check_person_id text-danger font-italic"></div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label>Compressor Wash Done</label>
                                                                    <select class="post_flight_check_compressor_wash form-control @error('post_flight_check_compressor_wash') is-invalid @enderror" name="post_flight_check_compressor_wash" id="post_flight_check_compressor_wash">
                                                                        <option value="Yes">Yes</option>
                                                                        <option value="No">No</option>
                                                                    </select>
                                                                    <div class="invalid-feedback-post_flight_check_compressor_wash text-danger font-italic"></div>
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
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #fff;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtn">
                        <strong>Save Changes</strong>
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
    var mem_transaction_date = $('#transaction_date .input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    var mem_last_inspection = $('#last_inspection .input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    var mem_next_inspection = $('#next_inspection .input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    var mem_pre_flight_check_date = $('#pre_flight_check_date .input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    var mem_post_flight_check_date = $('#post_flight_check_date .input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
</script>
@endpush