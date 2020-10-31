<!-- Modal -->
<div class="modal fade" id="requestModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="requestForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-5">
                            <label class="col-form-label" for="fempidRequest">Employee ID</label>
                            <select class="select2_empidRequest form-control m-b-sm" id="fempidRequest" name="empidRequest"></select>
                            <div class="invalid-feedback-empidRequest text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fworkdate">Work Date</label>
                            <input type="date" class="form-control" id="fworkdate" name="workdate">
                            <div class="invalid-feedback-workdate text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fshiftno">Shiftno</label>
                            <select class="select2_shiftno form-control m-b-sm" id="fshiftno" name="shiftno"></select>
                            <div class="invalid-feedback-shiftno text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fempidRequest">Request Code</label>
                            <select class="select2_reqcode form-control m-b-sm" id="freqcode" name="reqcode"></select>
                            <div class="invalid-feedback-reqcode text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fempidRequest">Request Type</label>
                            <select class="select2_reqtype form-control m-b-sm" id="freqtype" name="reqtype"></select>
                            <div class="invalid-feedback-reqtype text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-8">
                            <label class="col-form-label" for="fremark">Remark</label>
                            <input type="text" class="form-control" id="fremark" name="remark">
                            <div class="invalid-feedback-remark text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fwhdatestart">Work Date Start</label>
                            <input type="date" class="form-control" id="fwhdatestart" name="whdatestart">
                            <div class="invalid-feedback-whdatestart text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fwhtimestart">Work Time Start</label>
                            <input class="form-control" id="fwhtimestart" type="time" name="whtimestart">
                            <div class="invalid-feedback-whtimestart text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fwhdatefinish">Work Date Finish</label>
                            <input type="date" class="form-control" id="fwhdatefinish" name="whdatefinish">
                            <div class="invalid-feedback-whdatefinish text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fwhtimefinish">Work Time Finish</label>
                            <input class="form-control" id="fwhtimefinish" type="time" name="whtimefinish">
                            <div class="invalid-feedback-whtimefinish text-danger"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="frsdatestart">Rest Date start</label>
                            <input type="date" class="form-control" id="frsdatestart" name="rsdatestart">
                            <div class="invalid-feedback-rsdatestart text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="frstimestart">Rest Time Start</label>
                            <input class="form-control" id="frstimestart" type="time" name="rstimestart">
                            <div class="invalid-feedback-rstimestart text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="frsdatefinish">Rest Date finish</label>
                            <input type="date" class="form-control" id="frsdatefinish" name="rsdatefinish">
                            <div class="invalid-feedback-rsdatefinish text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="frstimefinish">Rest Time finish</label>
                            <input class="form-control" id="frstimefinish" type="time" name="rstimefinish">
                            <div class="invalid-feedback-rstimefinish text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-5">
                            <label class="col-form-label" for="fworkstatus">Work Status</label>
                            <select class="select2_workstatus form-control m-b-sm" id="fworkstatus" name="workstatus"></select>
                            <div class="invalid-feedback-workstatus text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fquotayear">Quota Year</label>
                            <input type="text" class="form-control" id="fquotayear" name="quotayear">
                            <div class="invalid-feedback-quotayear text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fstatus">Status</label>
                            <select class="form-control m-b-sm" id="fstatus" name="status">
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

