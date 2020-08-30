<!-- Modal -->
<div class="modal fade" id="educationModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="educationForm">
                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fempid">Employee ID</label>
                            <select class="select2_empid form-control m-b-sm" id="fempid" name="empid"></select>
                            <div class="invalid-feedback-empid text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fidcardtype">Instantion Name</label>
                            <input type="text" class="form-control" id="finstname" name="instname">
                            <div class="invalid-feedback-instname text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fstartperiod">Start Period</label>
                            <input type="text" class="form-control" id="fstartperiod" name="startperiod">
                            <div class="invalid-feedback-startperiod text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="ffinishperiod">Finish Period</label>
                            <input type="text" class="form-control" id="ffinishperiod" name="finishperiod">
                            <div class="invalid-feedback-finishperiod text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fcity">City</label>
                            <input type="text" class="form-control" id="fcity" name="city">
                            <div class="invalid-feedback-city text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fstate">State</label>
                            <input type="text" class="form-control" id="fstate" name="state">
                            <div class="invalid-feedback-state text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fcountry">Country</label>
                            <input type="text" class="form-control" id="fcountry" name="country">
                            <div class="invalid-feedback-country text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fmajor01">Major 1</label>
                            <input type="text" class="form-control" id="fmajor01" name="major01">
                            <div class="invalid-feedback-major01 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fmajor02">Major 2</label>
                            <input type="text" class="form-control" id="fmajor02" name="major02">
                            <div class="invalid-feedback-major02 text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fminor01">Minor 1</label>
                            <input type="text" class="form-control" id="fminor01" name="minor01">
                            <div class="invalid-feedback-minor01 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fminor02">Minor 2</label>
                            <input type="text" class="form-control" id="fminor02" name="minor02">
                            <div class="invalid-feedback-minor02 text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fedulvl">Education level</label>
                            <select class="select2_edulvl form-control m-b " id="fedulvl" name="edulvl">
                            </select>
                            <div class="invalid-feedback-edulvl text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fstatus">Status</label>
                            <select class="form-control m-b " id="fstatus" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <div class="invalid-feedback-status text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-form-label" for="fremark">Remark</label>
                            <input type="text" class="form-control" id="fremark" name="remark">
                            <div class="invalid-feedback-remark text-danger"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                        <button class="ladda-button ladda-button-submit btn btn-primary"  data-style="zoom-in" type="submit" id="saveBtn">
                            <strong>Save changes</strong>
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>
</div>

