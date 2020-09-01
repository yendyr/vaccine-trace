<!-- Modal -->
<div class="modal fade" id="addressModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="addressForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fempidAddress">Employee ID</label>
                            <select class="select2_empidAddress form-control m-b-sm" id="fempidAddress" name="empidAddress"
                            onchange="getFamid(this)"></select>
                            <div class="invalid-feedback-empidAddress text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="ffamidAddress">Family ID</label>
                            <select class="select2_famidAddress form-control m-b-sm" id="ffamidAddress" name="famidAddress"></select>
                            <div class="invalid-feedback-famidAddress text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="faddrid">Address ID</label>
                            <input type="text" class="form-control" id="faddrid" name="addrid">
                            <div class="invalid-feedback-addrid text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-7">
                            <label class="col-form-label" for="fstreet">Street</label>
                            <input type="text" class="form-control" id="fstreet" name="street">
                            <div class="invalid-feedback-street text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4 offset-sm-1">
                            <label class="col-form-label" for="farea">Area</label>
                            <input type="text" class="form-control" id="farea" name="area">
                            <div class="invalid-feedback-area text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fcity">City</label>
                            <input type="text" class="form-control" id="fcity" name="city">
                            <div class="invalid-feedback-city text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fstate">State</label>
                            <input type="text" class="form-control" id="fstate" name="state">
                            <div class="invalid-feedback-state text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fcountry">Country</label>
                            <input type="text" class="form-control" id="fcountry" name="country">
                            <div class="invalid-feedback-country text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fpostcode">Post Code</label>
                            <input type="text" class="form-control" id="fpostcode" name="postcode">
                            <div class="invalid-feedback-postcode text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4 offset-sm-1">
                            <label class="col-form-label" for="ftel01">Phone 1</label>
                            <input type="text" class="form-control" id="ftel01" name="tel01">
                            <div class="invalid-feedback-tel01 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="ftel02">Phone 2</label>
                            <input type="text" class="form-control" id="ftel02" name="tel02">
                            <div class="invalid-feedback-tel02 text-danger"></div>
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

