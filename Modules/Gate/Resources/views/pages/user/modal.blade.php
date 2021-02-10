<!-- Modal -->
<div class="modal fade" id="inputModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputForm">
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
                        {{-- <div class="col-md-6">
                            <label>Company</label>
                            <select class="select2_company form-control m-b " id="fcompany" name="company">
                            </select>
                            <div class="invalid-feedback-company text-danger"></div>
                        </div> --}}
                        <div class="col-md-6">
                            <label>Assign to Employee</label>
                            <select class="employee_id form-control m-b" id="employee_id" name="employee_id">
                            </select>
                            <div class="invalid-feedback-employee_id text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label>Role</label>
                            <select class="select2_role form-control m-b " id="frole" name="role">
                            </select>
                            <div class="invalid-feedback-role text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Active</label>
                        <div class="col-sm-7">     
                            <div class="pretty p-icon p-round p-jelly p-bigger" style="font-size: 15pt;">   
                                <input type="checkbox" class="form-control @error('status') is-invalid @enderror" name="status" id="status" />
                                <div class="state p-primary">
                                    <i class="icon fa fa-check"></i>
                                    <label></label>
                                </div>
                                <div class="invalid-feedback-status text-danger font-italic"></div>
                            </div>
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