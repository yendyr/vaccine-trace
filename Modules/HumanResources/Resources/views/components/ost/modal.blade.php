<!-- Modal -->
<div class="modal fade" id="ostModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="ostForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Organization Code</label>
                            <select class="select2_orgcode form-control"  id="forgcode" name="orgcode"></select>
                            <div class="invalid-feedback-orgcode text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Title Code</label>
                            <select class="form-control" id="ftitlecode" name="titlecode">
                                <option disabled selected>-- choose --</option>
                                <option value="1">Kepala</option>
                                <option value="2">Wakil Kepala</option>
                                <option value="3">Anggota</option>
                                <option value="4">Staff</option>
                                <option value="5">Operator</option>
                            </select>
                            <div class="invalid-feedback-titlecode text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
<<<<<<< HEAD
                        <div class="form-group col-sm-8">
                            <label class="col-form-label mr-2">Job Title</label>
=======
                        <div class="form-group col-sm-6">
                            <label>Job Title</label>
>>>>>>> 6eace68ffb37426eae970bb549afa01985e595d2
                            <input type="text" class="form-control" id="fjobtitle" name="jobtitle">
                            <div class="invalid-feedback-jobtitle text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Status</label>
                            <select class="form-control" id="fstatus" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <div class="invalid-feedback-status text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Report Organization</label>
                            <select class="select2_rptorg form-control" id="frptorg" name="rptorg"></select>
                            <div class="invalid-feedback-rptorg text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
<<<<<<< HEAD
                            <label class="col-form-label mr-2">Report Title</label>
                            <select class="select2_rpttitle form-control m-b " id="frpttitle" name="rpttitle"></select>
=======
                            <label>Report Title</label>
                            <select class="select2_rpttitle form-control" id="frpttitle" name="rpttitle"></select>
>>>>>>> 6eace68ffb37426eae970bb549afa01985e595d2
                            <div class="invalid-feedback-rpttitle text-danger"></div>
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

