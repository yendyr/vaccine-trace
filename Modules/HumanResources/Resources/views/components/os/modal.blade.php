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
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Organization Level</label>
                        <div class="col-sm-6">
                            <select class="select2_orglevel form-control m-b ml-2"  id="forglevel" name="orglevel"></select>
                            <div class="invalid-feedback-orglevel text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Organization Code</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="forgcode" name="orgcode" value="${if(isAdd)} ${else} ${orgcode} ${/if}">
                            <div class="invalid-feedback-orgcode text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Organization Parent</label>
                        <div class="col-sm-6">
                            <select class="select2_orgparent form-control m-b ml-2"  id="forgparent" name="orgparent"></select>
                            <div class="invalid-feedback-orgparent text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Organization Name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="forgname" name="orgname" value="${if(isAdd)} ${else} ${orgname} ${/if}">
                            <div class="invalid-feedback-orgname text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-6">
                            <select class="form-control m-b " id="fstatus" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <div class="invalid-feedback-status text-danger"></div>
                        </div>
                    </div>
                </div>

{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>--}}
{{--                    <button class="btn btn-primary" type="submit" id="saveBtn"><strong>Save changes</strong></button>--}}
{{--                </div>--}}
            </form>
            </div>
        </div>
    </div>
</div>

