<!-- Modal -->
<div class="modal fade" id="inputModalInterval" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleInterval"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputFormInterval">
                <input type="hidden" id="updateInterval" name="updateInterval" class="updateInterval" value="1">
                <input type="hidden" name="id" class="id" value="{{ $Taskcard->id }}">
                <div class="modal-body">
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
                                            <div class="input-group">
                                            <input type="number" min="0" class="form-control @error('threshold_flight_hour') is-invalid @enderror" name="threshold_flight_hour" id="threshold_flight_hour" value="{{ $Taskcard->threshold_flight_hour ?? '' }}">
                                            <div class="input-group-append">
                                                <span class="input-group-addon">FH</span>
                                            </div>
                                            <div class="invalid-feedback-threshold_flight_hour text-danger font-italic"></div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                            <input type="number" min="0" class="form-control @error('threshold_flight_cycle') is-invalid @enderror" name="threshold_flight_cycle" id="threshold_flight_cycle" value="{{ $Taskcard->threshold_flight_cycle ?? '' }}">
                                            <div class="input-group-append">
                                                <span class="input-group-addon">FC</span>
                                            </div>
                                            <div class="invalid-feedback-threshold_flight_cycle text-danger font-italic"></div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <input type="number" min="0" class="form-control @error('threshold_daily') is-invalid @enderror" name="threshold_daily" id="threshold_daily" value="{{ $Taskcard->threshold_daily ?? '' }}">
                                                <div class="input-group-append">
                                                    <select class="threshold_daily_unit form-control @error('threshold_daily_unit') is-invalid @enderror" name="threshold_daily_unit" id="threshold_daily_unit">
                                                        <option value="Day" @if ($Taskcard->threshold_daily_unit == 'Day') selected @endif>Day</option>
                                                        <option value="Month" @if ($Taskcard->threshold_daily_unit == 'Month') selected @endif>Month</option>
                                                        <option value="Year" @if ($Taskcard->threshold_daily_unit == 'Year') selected @endif>Year</option>
                                                    </select>
                                                </div>
                                                <div class="invalid-feedback-threshold_daily text-danger font-italic"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" id="threshold_date">
                                            <div class="input-group date">
                                                <span class="input-group-addon">Exact Date</span>
                                                <input type="text" class="form-control @error('threshold_date') is-invalid @enderror" name="threshold_date" id="threshold_date" value="{{ $Taskcard->threshold_date ?? '' }}" readonly>
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
                                    <div class="row m-b">
                                        <div class="col">
                                            <div class="input-group">
                                            <input type="number" min="0" class="form-control @error('repeat_flight_hour') is-invalid @enderror" name="repeat_flight_hour" id="repeat_flight_hour" value="{{ $Taskcard->repeat_flight_hour ?? '' }}">
                                            <div class="input-group-append">
                                                <span class="input-group-addon">FH</span>
                                            </div>
                                            <div class="invalid-feedback-repeat_flight_hour text-danger font-italic"></div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                            <input type="number" min="0" class="form-control @error('repeat_flight_cycle') is-invalid @enderror" name="repeat_flight_cycle" id="repeat_flight_cycle" value="{{ $Taskcard->repeat_flight_cycle ?? '' }}">
                                            <div class="input-group-append">
                                                <span class="input-group-addon">FC</span>
                                            </div>
                                            <div class="invalid-feedback-repeat_flight_cycle text-danger font-italic"></div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <input type="number" min="0" class="form-control @error('repeat_daily') is-invalid @enderror" name="repeat_daily" id="repeat_daily" value="{{ $Taskcard->repeat_daily ?? '' }}">
                                                <div class="input-group-append">
                                                    <select class="repeat_daily_unit form-control @error('repeat_daily_unit') is-invalid @enderror" name="repeat_daily_unit" id="repeat_daily_unit">
                                                        <option value="Day" @if ($Taskcard->repeat_daily_unit == 'Day') selected @endif>Day</option>
                                                        <option value="Month" @if ($Taskcard->repeat_daily_unit == 'Month') selected @endif>Month</option>
                                                        <option value="Year" @if ($Taskcard->repeat_daily_unit == 'Year') selected @endif>Year</option>
                                                    </select>
                                                </div>
                                                <div class="invalid-feedback-repeat_daily text-danger font-italic"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" id="repeat_date">
                                            <div class="input-group date">
                                                <span class="input-group-addon">Exact Date</span>
                                                <input type="text" class="form-control @error('repeat_date') is-invalid @enderror" name="repeat_date" id="repeat_date" value="{{ $Taskcard->repeat_date ?? '' }}" readonly>
                                                <div class="invalid-feedback-repeat_date text-danger font-italic"></div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-b">
                                        <div class="col">
                                            <label>Interval Control Method</label>
                                            <select class="interval_control_method form-control @error('interval_control_method') is-invalid @enderror" name="interval_control_method" id="interval_control_method">
                                                <option value="Which One Comes First"
                                                @if ($Taskcard->interval_control_method == 'Which One Comes First') selected @endif>Which One Comes First</option>
                                                <option value="Which One Comes Last" @if ($Taskcard->interval_control_method == 'Which One Comes Last') selected @endif>Which One Comes Last</option>
                                            </select>
                                            <div class="invalid-feedback-interval_control_method text-danger font-italic"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtnInterval">
                        <strong>Save Changes</strong>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('header-scripts')
    <link href="{{ URL::asset('theme/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
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
</script>
@endpush