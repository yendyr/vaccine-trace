<!-- Modal -->
<div class="modal fade" id="workgroupModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="workgroupForm">
                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fworkgroup">Work Group</label>
                            <input type="text" class="form-control" id="fworkgroup" name="workgroup" >
                            <div class="invalid-feedback-workgroup text-danger"></div>
                        </div>
                        <div class="form-group col-sm-8">
                            <label class="col-form-label" for="fworkname">Work Name</label>
                            <input type="text" class="form-control" id="fworkname" name="workname" >
                            <div class="invalid-feedback-workname text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fshiftstatus">Shift Status</label>
                            <select class="form-control m-b " id="fshiftstatus" name="shiftstatus" onchange="workgroupSetShift(this)">
                                <option value="Y">Shft</option>
                                <option value="N">Non Shift</option>
                            </select>
                            <div class="invalid-feedback-shiftstatus text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fshiftrolling">Shift Rolling</label>
                            <input type="text" class="form-control" id="fshiftrolling" name="shiftrolling" placeholder="ex: 123">
                            <div class="invalid-feedback-shiftrolling text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="frangerolling">Range Rolling</label>
                            <input type="number" class="form-control" id="frangerolling" name="rangerolling" placeholder="(day)">
                            <div class="invalid-feedback-rangerolling text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="froundtime">Round Time</label>
                            <input type="number" class="form-control" id="froundtime" name="roundtime" placeholder="(minute)">
                            <div class="invalid-feedback-roundtime text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fworkfinger">Work Finger</label>
                            <select class="form-control m-b " id="fworkfinger" name="workfinger">
                                <option value="1">Required</option>
                                <option value="0">Not required</option>
                            </select>
                            <div class="invalid-feedback-workfinger text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="frestfinger">Rest Finger</label>
                            <select class="form-control m-b " id="frestfinger" name="restfinger">
                                <option value="0">Not required</option>
                                <option value="1">Required</option>
                            </select>
                            <div class="invalid-feedback-restfinger text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-8">
                            <label class="col-form-label" for="fremark">Remark</label>
                            <input type="text" class="form-control" id="fremark" name="remark">
                            <div class="invalid-feedback-remark text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fstatus">Status</label>
                            <select class="form-control m-b " id="fstatus" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <div class="invalid-feedback-status text-danger"></div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary"  data-style="zoom-in" type="submit" id="saveBtn">
                        <strong>Save changes</strong>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

