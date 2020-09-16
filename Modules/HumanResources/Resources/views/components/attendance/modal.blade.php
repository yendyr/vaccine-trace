<!-- Modal -->
<div class="modal fade" id="attendanceModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="attendanceForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-form-label" for="fempidAttendance">Employee ID</label>
                            <select class="select2_empidAttendance form-control m-b-sm" id="fempidAttendance" name="empidAttendance">
                            </select>
                            <div class="invalid-feedback-empidAttendance text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fattddate">Attendance Date</label>
                            <input type="date" class="form-control" id="fattddate" name="attddate">
                            <div class="invalid-feedback-attddate text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fattdtime">Attendance Time</label>
                            <input class="form-control" id="fattdtime" type="time" name="attdtime">
                            <div class="invalid-feedback-attdtime text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-8">
                            <label class="col-form-label" for="fattdtype">Attendance Type</label>
                            <select class="select2_attdtype form-control m-b-sm" id="fattdtype" name="attdtype">
                            </select>
                            <div class="invalid-feedback-attdtype text-danger"></div>
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

