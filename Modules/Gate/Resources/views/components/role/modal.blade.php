<!-- Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="roleForm">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Role Name</label>
                            <input type="text" class="form-control @error('role_name') is-invalid @enderror" id="frolename" name="role_name">
                            <div class="invalid-feedback-role_name text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
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

