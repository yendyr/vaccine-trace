<!-- Modal -->
<div class="modal fade" id="osModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="formModal">
            <form method="post" id="osForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Org. Structure Level</label>
                            <select class="select2_orglevel form-control"  id="forglevel" name="orglevel">
                            </select>
                            <div class="invalid-feedback-orglevel text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Org. Structure Code</label>
                            <input type="text" class="form-control" id="forgcode" name="orgcode" >
                            <div class="invalid-feedback-orgcode text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Org. Structure Name</label>
                            <input type="text" class="form-control" id="forgname" name="orgname" >
                            <div class="invalid-feedback-orgname text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Org. Structure Parent</label>
                            <select class="select2_orgparent form-control"  id="forgparent" name="orgparent"></select>
                            <div class="invalid-feedback-orgparent text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Status</label>
                            <select class="form-control" id="fstatus" name="status">
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
</div>

