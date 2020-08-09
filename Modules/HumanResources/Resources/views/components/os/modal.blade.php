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
                        <div class="form-group col-sm-4">
                            <label class="col-form-label">Org. Structure Level</label>
                            <select class="select2_orglevel form-control m-b ml-2"  id="forglevel" name="orglevel">
                                <option value="1">Direksi</option>
                                <option value="2">General</option>
                                <option value="3">Divisi</option>
                                <option value="4">Bagian</option>
                                <option value="5">Seksi</option>
                                <option value="6">Regu</option>
                                <option value="7">Group</option>
                            </select>
                            <div class="invalid-feedback-orglevel text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label">Org. Structure Code</label>
                            <input type="text" class="form-control" id="forgcode" name="orgcode" >
                            <div class="invalid-feedback-orgcode text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-10">
                            <label class="col-form-label">Org. Structure Name</label>
                            <input type="text" class="form-control" id="forgname" name="orgname" >
                            <div class="invalid-feedback-orgname text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-7">
                            <label class="col-form-label">Org. Structure Parent</label>
                            <select class="select2_orgparent form-control m-b ml-2"  id="forgparent" name="orgparent"></select>
                            <div class="invalid-feedback-orgparent text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label">Status</label>
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
                    <button class="btn btn-primary" type="submit" id="saveBtn"><strong>Save changes</strong></button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

