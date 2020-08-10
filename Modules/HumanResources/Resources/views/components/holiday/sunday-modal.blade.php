<div class="modal fade" id="sundayModal" tabindex="-1" role="dialog" aria-labelledby="sundayModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generate Sunday holidays</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="sundayForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-8">
                            <label class="col-form-label" for="fsundayyear">Year</label>
                            <input type="number" class="form-control" id="fsundayyear" name="sundayyear">
                            <div class="invalid-feedback-sundayyear text-danger"></div>
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
