<!-- Modal -->
<div class="modal fade" id="holidayModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="holidayForm">
                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-sm-8">
                            <label class="col-form-label" for="fholidaydate">Date</label>
                            <input type="date" class="form-control" id="fholidaydate" name="holidaydate">
                            <div class="invalid-feedback-holidaydate text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fholidayyear">Year</label>
                            <input type="number" class="form-control" id="fholidayyear" name="holidayyear">
                            <div class="invalid-feedback-holidayyear text-danger"></div>
                        </div>
                        <div class="form-group col-sm-7">
                            <label class="col-form-label" for="fholidaycode">Code</label>
                            <select class="select2_holidaycode form-control m-b-sm" id="fholidaycode" name="holidaycode"></select>
                            <div class="invalid-feedback-holidaycode text-danger"></div>
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

