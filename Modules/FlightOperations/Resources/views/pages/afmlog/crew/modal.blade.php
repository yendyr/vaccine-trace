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
                <input type="hidden" id="afm_log_id" name="afm_log_id" value="{{ $afmlog->id ?? '' }}">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Crew Name</label>
                        <div class="col-sm-7">
                            <select class="employee_id form-control @error('employee_id') is-invalid @enderror" name="employee_id" id="employee_id"></select>
                            <div class="invalid-feedback-employee_id text-danger font-italic"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">In-Flight Role</label>
                        <div class="col-sm-7">
                            <select class="role_id form-control @error('role_id') is-invalid @enderror" name="role_id" id="role_id"></select>
                            <div class="invalid-feedback-role_id text-danger font-italic"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Remark</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('crew_description') is-invalid @enderror" name="crew_description" id="crew_description">
                            <div class="invalid-feedback-crew_description text-danger font-italic"></div>
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
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtn">
                        <strong>Save Changes</strong>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>