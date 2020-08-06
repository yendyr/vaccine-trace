<!-- Modal -->
<div class="modal fade" id="userModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" id="userForm">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Username</label>
                            <input type="text" class="form-control " id="fusername" name="username" >
                            <div class="invalid-feedback-username text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" class="form-control " id="fname" name="name" >
                            <div class="invalid-feedback-name text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Email</label>
                            <input type="email" class="form-control " id="femail" name="email" >
                            <div class="invalid-feedback-email text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label>Password</label>
                            <input type="password" class="form-control " id="fpassword" name="password">
                            <div class="invalid-feedback-password text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Company</label>
                            <select class="select2_company form-control m-b " id="fcompany" name="company">
                            </select>
                            <div class="invalid-feedback-company text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label>Role</label>
                            <select class="select2_role form-control m-b " id="frole" name="role">
                            </select>
                            <div class="invalid-feedback-role text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row">
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

