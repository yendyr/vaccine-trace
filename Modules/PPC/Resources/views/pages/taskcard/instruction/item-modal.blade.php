<!-- Modal -->
<div class="modal fade" id="inputModalItem" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleItem"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputFormItem">
                <input type="hidden" name="taskcard_id" value="{{ $Taskcard->id }}">
                <input type="hidden" id="taskcard_detail_instruction_id" name="taskcard_detail_instruction_id" value="">

                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-4 d-flex align-items-center">Code / Item Name</label>
                        <div class="col-sm-8">
                            <select class="item_id form-control @error('item_id') is-invalid @enderror" id="item_id" name="item_id"></select>
                            <div class="invalid-feedback-item_id text-danger font-italic"></div>                           
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 d-flex align-items-center">Quantity</label>
                        <div class="col-sm-8">
                            <input type="number" min='1' class="form-control @error('quantity') is-invalid @enderror" name="quantity" id="quantity">
                            <div class="invalid-feedback-quantity text-danger font-italic"></div>
                        </div>
                    </div>      
                    {{-- <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Unit</label>
                        <div class="col-sm-7">
                            <select class="unit_id form-control @error('unit_id') is-invalid @enderror" id="unit_id" name="unit_id"></select>
                            <div class="invalid-feedback-unit_id text-danger font-italic"></div>                           
                        </div>
                    </div>       --}}
                    <div class="form-group row">
                        <label class="col-sm-4 d-flex align-items-center">Remark</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description">
                            <div class="invalid-feedback-description text-danger font-italic"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveButtonItem">
                        <strong>Save Changes</strong>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>