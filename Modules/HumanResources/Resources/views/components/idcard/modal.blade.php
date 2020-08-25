<!-- Modal -->
<div class="modal fade" id="idcardModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="idcardForm">
                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fempid">Employee ID</label>
                            <select class="select2_empid form-control m-b-sm" id="fempid" name="empid"></select>
                            <div class="invalid-feedback-empid text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fidcardtype">ID Card type</label>
                            <select class="form-control m-b " id="fidcardtype" name="idcardtype">
                                <option value="1">KTP</option>
                                <option value="2">SIM</option>
                                <option value="3">Passport</option>
                                <option value="4">NPWP</option>
                            </select>
                            <div class="invalid-feedback-idcardtype text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-8">
                            <label class="col-form-label" for="fidcardno">ID Card no.</label>
                            <input type="text" class="form-control" id="fidcardno" name="idcardno">
                            <div class="invalid-feedback-idcardno text-danger"></div>
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

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fidcarddate">ID Card date</label>
                            <input type="date" class="form-control" id="fidcarddate" name="idcarddate">
                            <div class="invalid-feedback-idcarddate text-danger"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fidcardexpdate">ID Card exp date</label>
                            <input type="date" class="form-control" id="fidcardexpdate" name="idcardexpdate">
                            <div class="invalid-feedback-idcardexpdate text-danger"></div>
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

