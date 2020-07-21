<!-- Modal -->
<div class="modal fade" id="userPasswordModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="user-password-form" action="" method="POST">
                <div class="modal-body">
                    <div class="form-group row"><label class="col-sm-3 col-form-label">Current Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control " id="fcurrent" name="current">
                            <div class="invalid-feedback-current text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row"><label class="col-sm-3 col-form-label">New Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control " id="fnew" name="new">
                            <div class="invalid-feedback-new text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row"><label class="col-sm-3 col-form-label">Confirm Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control " id="fconfirm" name="confirm">
                            <div class="invalid-feedback-confirm text-danger"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="btn btn-primary" type="submit" id="savePassBtn"><strong>Save password</strong></button>
                </div>

            </form>


        </div>
    </div>
</div>

{{--TOAST--}}
{{--<div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">--}}
{{--    <div class="toast" style="position: absolute; top: 0; right: 0;">--}}
{{--        <div class="toast-header">--}}
{{--            <img src="..." class="rounded mr-2" alt="...">--}}
{{--            <strong class="mr-auto">Success Alert</strong>--}}
{{--            <small>notification</small>--}}
{{--            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">--}}
{{--                <span aria-hidden="true">&times;</span>--}}
{{--            </button>--}}
{{--        </div>--}}
{{--        <div class="toast-body text-success">--}}
{{--            Password changed successfully!--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

