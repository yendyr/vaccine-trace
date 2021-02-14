<!-- Modal -->
<div class="modal fade" tabindex="-1" id="inputModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-8">
                            <label class="col-form-label" for="fempidLquota">Employee ID</label>
                            <select class="select2_empidLquota form-control m-b-sm" id="fempidLquota" name="empidLquota">
                            </select>
                            <div class="invalid-feedback-empidLquota text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fquotayear">Leave quota year</label>
                            <input class="form-control" id="fquotayear" type="text" name="quotayear">
                            <div class="invalid-feedback-quotayear text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fquotacode">Leave quota code</label>
                            <select class="select2_quotacode form-control m-b-sm" id="fquotacode" name="quotacode">
                            </select>
                            <div class="invalid-feedback-quotacode text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fquotaqty">Leave quota quantity</label>
                            <input class="form-control" id="fquotaqty" type="text" name="quotaqty">
                            <div class="invalid-feedback-quotaqty text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fquotastartdate">Quota start date</label>
                            <input type="date" class="form-control" id="fquotastartdate" name="quotastartdate">
                            <div class="invalid-feedback-quotastartdate text-danger"></div>
                        </div><div class="form-group col-sm-6">
                            <label class="col-form-label" for="fquotaexpdate">Quota exp date</label>
                            <input type="date" class="form-control" id="fquotaexpdate" name="quotaexpdate">
                            <div class="invalid-feedback-quotaexpdate text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-8">
                            <label class="col-form-label" for="fremark">Remark</label>
                            <input class="form-control" id="fremark" type="text" name="remark">
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

