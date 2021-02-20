<!-- Modal -->
<div class="modal fade" id="inputModalJournal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleJournal"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputFormJournal">
                <input type="hidden" id="afm_log_id" name="afm_log_id" value="{{ $afmlog->id ?? '' }}">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>From</label>
                            <select class="route_from form-control @error('route_from') is-invalid @enderror" id="route_from" name="route_from"></select>
                            <div class="invalid-feedback-route_from text-danger font-italic"></div>
                        </div>
                        <div class="col-md-6">
                            <label>To</label>
                            <select class="route_to form-control @error('route_to') is-invalid @enderror" id="route_to" name="route_to"></select>
                            <div class="invalid-feedback-route_to text-danger font-italic"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label>Block-Off</label>
                            <div class="input-group block_off">
                                <span class="input-group-prepend">
                                    <span class="input-group-addon">UTC</span>
                                </span>
                                <input type="text" class="form-control @error('block_off') is-invalid @enderror" value="09:30" id="block_off" name="block_off" data-autoclose="true" readonly>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            <div class="invalid-feedback-block_off text-danger font-italic"></div>
                        </div>

                        <div class="col-md-3">
                            <label>Take-Off</label>
                            <div class="input-group take_off">
                                <span class="input-group-prepend">
                                    <span class="input-group-addon">UTC</span>
                                </span>
                                <input type="text" class="form-control @error('take_off') is-invalid @enderror" value="09:30" id="take_off" name="take_off" data-autoclose="true" readonly>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            <div class="invalid-feedback-take_off text-danger font-italic"></div>
                        </div>

                        <div class="col-md-3">
                            <label>Landing</label>
                            <div class="input-group landing">
                                <span class="input-group-prepend">
                                    <span class="input-group-addon">UTC</span>
                                </span>
                                <input type="text" class="form-control @error('landing') is-invalid @enderror" value="09:30" id="landing" name="landing" data-autoclose="true" readonly>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            <div class="invalid-feedback-landing text-danger font-italic"></div>
                        </div>

                        <div class="col-md-3">
                            <label>Block-On</label>
                            <div class="input-group block_on">
                                <span class="input-group-prepend">
                                    <span class="input-group-addon">UTC</span>
                                </span>
                                <input type="text" class="form-control @error('block_on') is-invalid @enderror" value="09:30" id="block_on" name="block_on" data-autoclose="true" readonly>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            <div class="invalid-feedback-block_on text-danger font-italic"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Event Count</label>
                            <input type="number" min=1 value=1 class="form-control @error('sub_total_event') is-invalid @enderror" name="sub_total_event" id="sub_total_event">
                            <div class="invalid-feedback-sub_total_event text-danger font-italic"></div>
                        </div>

                        <div class="col-md-6">
                            <label>Remark</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description">
                            <div class="invalid-feedback-description text-danger font-italic"></div>
                        </div>
                    </div>

                    {{-- <div class="form-group row">
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
                    </div> --}}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveButtonJournal">
                        <strong>Save Changes</strong>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@push('header-scripts')
<link href="{{ URL::asset('theme/css/plugins/clockpicker/bootstrap-clockpicker.min.css') }}" rel="stylesheet">
@endpush

@push('footer-scripts')
<script src="{{ URL::asset('theme/js/plugins/clockpicker/bootstrap-clockpicker.min.js') }}"></script>
@endpush