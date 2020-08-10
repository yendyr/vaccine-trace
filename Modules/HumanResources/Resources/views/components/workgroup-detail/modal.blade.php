<!-- Modal -->
<div class="modal fade" id="workgroupDetailModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="workgroupDetailForm">
                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-sm-8">
                            <label class="col-form-label" for="fwgcode">Workgroup</label>
                            <select class="select2_wgcode form-control m-b-sm" onchange="getShift(this)" id="fwgcode" name="workgroup"></select>
                            <div class="invalid-feedback-workgroup text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fshiftno">Shift No.</label>
                            <select class="select2_shiftno form-control m-b-sm" id="fshiftno" name="shiftno"></select>
                            <div class="invalid-feedback-shiftno text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fdaycode">Daycode</label>
                            <select class="form-control m-b-sm" id="fdaycode" name="daycode">
                                <option value="01">Minggu</option>
                                <option value="02">Senin</option>
                                <option value="03">Selasa</option>
                                <option value="04">Rabu</option>
                                <option value="05">Kamis</option>
                                <option value="06">Jumat</option>
                                <option value="07">Sabtu</option>
                            </select>
                            <div class="invalid-feedback-daycode text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fstdhours">Standard hours</label>
                            <input type="number" class="form-control" id="fstdhours" name="stdhours">
                            <div class="invalid-feedback-stdhours text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fminhours">Minimum hours</label>
                            <input type="number" class="form-control" id="fminhours" name="minhours">
                            <div class="invalid-feedback-minhours text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fwhtimestart">Work Time Start</label>
                            <input class="form-control" id="fwhtimestart" type="time" name="whtimestart">
                            <div class="invalid-feedback-whtimestart text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fwhtimefinish">Work Time Finish</label>
                            <input class="form-control" id="fwhtimefinish" type="time" name="whtimefinish">
                            <div class="invalid-feedback-whtimefinish text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fworktype">Work Type</label>
                            <select class="form-control m-b-sm" id="fworktype" name="worktype">
                                <option value="KB">Kerja Biasa</option>
                                <option value="KL">Kerja Libur</option>
                            </select>
                            <div class="invalid-feedback-worktype text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="frstimestart">Rest Time Start</label>
                            <input class="form-control" id="frstimestart" type="time" name="rstimestart">
                            <div class="invalid-feedback-rstimestart text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="frstimefinish">Rest Time Finish</label>
                            <input class="form-control" id="frstimefinish" type="time" name="rstimefinish">
{{--                            <span class="validity"></span>--}}
                            <div class="invalid-feedback-rstimefinish text-danger"></div>
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

