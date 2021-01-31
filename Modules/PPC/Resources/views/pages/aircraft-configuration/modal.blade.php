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
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Aircraft Type</label>
                                <div class="col-sm-7">
                                    <select class="aircraft_type_id form-control @error('aircraft_type_id') is-invalid @enderror" name="aircraft_type_id" id="aircraft_type_id"></select>
                                    <div class="invalid-feedback-aircraft_type_id text-danger font-italic"></div>
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
                                <label class="col-sm-5 d-flex align-items-center">Registration</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('registration') is-invalid @enderror" name="registration" id="registration">
                                    <div class="invalid-feedback-registration text-danger font-italic"></div>
                                </div>
                            </div>
        
                            <div class="form-group row" id="manufactured_date">
                                <div class="col-md-12 input-group date">
                                    <span class="input-group-addon">Manufactured Date</span>
                                    <input type="text" class="form-control @error('manufactured_date') is-invalid @enderror" name="manufactured_date" id="manufactured_date">
                                    <div class="invalid-feedback-manufactured_date text-danger font-italic"></div>
                                </div>
                            </div>
        
                            <div class="form-group row" id="received_date">
                                <div class="col-md-12 input-group date">
                                    <span class="input-group-addon">Received Date</span>
                                    <input type="text" class="form-control @error('received_date') is-invalid @enderror" name="received_date" id="received_date">
                                    <div class="invalid-feedback-received_date text-danger font-italic"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Max Take-Off Weight</label>
                                <div class="col-sm-7 input-group">
                                    <input type="number" min="0" class="form-control @error('max_takeoff_weight') is-invalid @enderror" name="max_takeoff_weight" id="max_takeoff_weight">
                                    <div class="input-group-append">
                                        <select class="max_takeoff_weight_unit_id form-control @error('max_takeoff_weight_unit_id') is-invalid @enderror" name="max_takeoff_weight_unit_id" id="max_takeoff_weight_unit_id">
                                            <option value="Day">Day</option>
                                            <option value="Month">Month</option>
                                            <option value="Year">Year</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback-max_takeoff_weight text-danger font-italic"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Max Landing Weight</label>
                                <div class="col-sm-7 input-group">
                                    <input type="number" min="0" class="form-control @error('max_landing_weight') is-invalid @enderror" name="max_landing_weight" id="max_landing_weight">
                                    <div class="input-group-append">
                                        <select class="max_landing_weight_unit_id form-control @error('max_landing_weight_unit_id') is-invalid @enderror" name="max_landing_weight_unit_id" id="max_landing_weight_unit_id">
                                            <option value="Day">Day</option>
                                            <option value="Month">Month</option>
                                            <option value="Year">Year</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback-max_landing_weight text-danger font-italic"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Max Landing Weight</label>
                                <div class="col-sm-7 input-group">
                                    <input type="number" min="0" class="form-control @error('max_zero_fuel_weight') is-invalid @enderror" name="max_zero_fuel_weight" id="max_zero_fuel_weight">
                                    <div class="input-group-append">
                                        <select class="max_zero_fuel_weight_unit_id form-control @error('max_zero_fuel_weight_unit_id') is-invalid @enderror" name="max_zero_fuel_weight_unit_id" id="max_zero_fuel_weight_unit_id">
                                            <option value="Day">Day</option>
                                            <option value="Month">Month</option>
                                            <option value="Year">Year</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback-max_zero_fuel_weight text-danger font-italic"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Description/Remark</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description">
                                    <div class="invalid-feedback-description text-danger font-italic"></div>
                                </div>
                            </div>
        
                            <div class="form-group row" id="duplicated_from">
                                <label class="col-sm-5 d-flex align-items-center">Copy Configuration from Template</label>
                                <div class="col-sm-7">
                                    <select class="duplicated_from form-control @error('duplicated_from') is-invalid @enderror" name="duplicated_from" id="duplicated_from"></select>
                                    <div class="invalid-feedback-duplicated_from text-danger font-italic"></div>
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
    var mem_manufactured_date = $('#manufactured_date .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    var mem_received_date = $('#received_date .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
</script>
@endpush