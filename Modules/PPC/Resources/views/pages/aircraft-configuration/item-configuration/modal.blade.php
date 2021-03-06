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
                <input type="hidden" id="aircraft_configuration_id" name="aircraft_configuration_id" value="{{ $AircraftConfiguration->id ?? '' }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Item Code/Name</label>
                                <div class="col-sm-7">
                                    <select class="item_id form-control @error('item_id') is-invalid @enderror" name="item_id" id="item_id"></select>
                                    <div class="invalid-feedback-item_id text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Serial Number</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('serial_number') is-invalid @enderror" name="serial_number" id="serial_number">
                                    <div class="invalid-feedback-serial_number text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Alias Name</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('alias_name') is-invalid @enderror" name="alias_name" id="alias_name">
                                    <div class="invalid-feedback-alias_name text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Remark</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description">
                                    <div class="invalid-feedback-description text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Highlight this Item</label>
                                <div class="col-sm-7">     
                                    <div class="pretty p-icon p-round p-jelly p-bigger" style="font-size: 15pt;">   
                                        <input type="checkbox" class="form-control @error('highlight') is-invalid @enderror" name="highlight" id="highlight" />
                                        <div class="state p-primary">
                                            <i class="icon fa fa-check"></i>
                                            <label></label>
                                        </div>
                                        <div class="invalid-feedback-highlight text-danger font-italic"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Parent Item</label>
                                <div class="col-sm-7">
                                    <select class="parent_coding form-control @error('parent_coding') is-invalid @enderror" name="parent_coding" id="parent_coding"></select>
                                    <div class="invalid-feedback-parent_coding text-danger font-italic"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Active</label>
                                <div class="col-sm-7">     
                                    <div class="pretty p-icon p-round p-jelly p-bigger" style="font-size: 15pt;">   
                                        <input type="checkbox" class="form-control @error('status') is-invalid @enderror" name="status" id="status" />
                                        <div class="state p-primary">
                                            <i class="icon fa fa-check"></i>
                                            <label></label>
                                        </div>
                                        <div class="invalid-feedback-status text-danger font-italic"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Initial Flight Hour Aging</label>
                                <div class="col-sm-7">
                                    <input type="number" min="0" class="form-control @error('initial_flight_hour') is-invalid @enderror" name="initial_flight_hour" id="initial_flight_hour">
                                    <div class="invalid-feedback-initial_flight_hour text-danger font-italic"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Initial Block Hour Aging</label>
                                <div class="col-sm-7">
                                    <input type="number" min="0" class="form-control @error('initial_block_hour') is-invalid @enderror" name="initial_block_hour" id="initial_block_hour">
                                    <div class="invalid-feedback-initial_block_hour text-danger font-italic"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Initial Flight Cycle Aging</label>
                                <div class="col-sm-7">
                                    <input type="number" min="0" class="form-control @error('initial_flight_cycle') is-invalid @enderror" name="initial_flight_cycle" id="initial_flight_cycle">
                                    <div class="invalid-feedback-initial_flight_cycle text-danger font-italic"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Initial Flight Event Aging</label>
                                <div class="col-sm-7">
                                    <input type="number" min="0" class="form-control @error('initial_flight_event') is-invalid @enderror" name="initial_flight_event" id="initial_flight_event">
                                    <div class="invalid-feedback-initial_flight_event text-danger font-italic"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row" id="initial_start_date">
                                <div class="col-md-12 input-group date">
                                    <span class="input-group-addon">Initial Start Date</span>
                                    <input type="text" class="initial_start_date form-control @error('initial_start_date') is-invalid @enderror" name="initial_start_date" id="initial_start_date" readonly>
                                    <div class="invalid-feedback-initial_start_date text-danger font-italic"></div>
                                </div>
                            </div>

                            <div class="form-group row" id="expired_date">
                                <div class="col-md-12 input-group date">
                                    <span class="input-group-addon">Expired Date</span>
                                    <input type="text" class="expired_date form-control @error('expired_date') is-invalid @enderror" name="expired_date" id="expired_date" readonly>
                                    <div class="invalid-feedback-expired_date text-danger font-italic"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="modal-footer">
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
    var mem_initial_start_date = $('#initial_start_date .input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
    var mem_expired_date = $('#expired_date .input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
</script>
@endpush