<!-- Modal -->
<div class="modal fade" id="whourModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="whourForm">
                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-sm-12" id="data-daterange">
                            <label class="font-normal">Date Range</label>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="form-control-sm form-control" name="datestart" value="{{date('Y/m/d')}}"/>
                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control-sm form-control" name="datefinish" value="{{date('Y/m/d')}}"/>
                                <div class="invalid-feedback-datefinish text-danger"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="col-form-label" for="fempidWhour">Employee ID</label>
                            <select class="select2_empidWhour form-control m-b-sm" id="fempidWhour" name="empidWhour"></select>
                            <div class="invalid-feedback-empidWhour text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4 offset-sm-2">
                            <label class="col-form-label" for="fstatus">Status</label>
                            <select class="form-control m-b-sm" id="fstatus" name="status">
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

