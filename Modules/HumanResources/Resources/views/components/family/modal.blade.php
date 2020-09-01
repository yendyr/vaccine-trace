<!-- Modal -->
<div class="modal fade" id="familyModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="familyForm">
                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fempidFamily">Employee ID</label>
                            <select class="select2_empidFamily form-control m-b-sm" id="fempidFamily" name="empidFamily"></select>
                            <div class="invalid-feedback-empidFamily text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="ffamid">Family ID</label>
                            <input type="text" class="form-control" id="ffamid" name="famid">
                            <div class="invalid-feedback-famid text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="frelationship">Relationship</label>
                            <select class="select2_relationship form-control m-b-sm" id="frelationship" name="relationship"></select>
                            <div class="invalid-feedback-relationship text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="ffullnameFamily">Full Name</label>
                            <input type="text" class="form-control" id="ffullnameFamily" name="fullnameFamily">
                            <div class="invalid-feedback-fullnameFamily text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fpobFamily">Place of birth</label>
                            <input type="text" class="form-control" id="fpobFamily" name="pobFamily">
                            <div class="invalid-feedback-pobFamily text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fdobFamily">Date of birth</label>
                            <input type="date" class="form-control" id="fdobFamily" name="dobFamily">
                            <div class="invalid-feedback-dobFamily text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fgenderFamily">Gender</label>
                            <select class="form-control m-b " id="fgenderFamily" name="genderFamily">
                                <option value="L">Laki - laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <div class="invalid-feedback-genderFamily text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fmaritalstatusFamily">Marital Status</label>
                            <select class="select2_maritalstatusFamily form-control m-b-sm" id="fmaritalstatusFamily" name="maritalstatusFamily">
                            </select>
                            <div class="invalid-feedback-maritalstatusFamily text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fjobFamily">Job</label>
                            <select class="select2_jobFamily form-control m-b-sm" id="fjobFamily" name="jobFamily">
                            </select>
                            <div class="invalid-feedback-jobFamily text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fedulvlFamily">Education level</label>
                            <select class="select2_edulvlFamily form-control m-b " id="fedulvlFamily" name="edulvlFamily">
                            </select>
                            <div class="invalid-feedback-edulvlFamily text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fedumajor">Education Major</label>
                            <input type="text" class="form-control" id="fedumajor" name="edumajor">
                            <div class="invalid-feedback-edumajor text-danger"></div>
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

