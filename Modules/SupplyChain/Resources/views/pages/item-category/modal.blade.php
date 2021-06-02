<!-- Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputForm">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Code</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code">                            
                            <div class="invalid-feedback-code text-danger font-italic"></div>                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Item Category Name</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                            <div class="invalid-feedback-name text-danger font-italic"></div>
                        </div>
                    </div>            
                    {{-- <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Unit Class</label>
                        <div class="col-sm-7">
                            <select class="unit_class_id form-control @error('unit_class_id') is-invalid @enderror" id="unit_class_id" name="unit_class_id"></select>
                            <div class="invalid-feedback-unit_class_id text-danger font-italic"></div>
                        </div>
                    </div>             --}}
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Description/Remark</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description">
                            <div class="invalid-feedback-description text-danger font-italic"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Item Type</label>
                        <div class="col-sm-7">
                            <select class="item_type form-control @error('item_type') is-invalid @enderror" name="item_type" id="item_type">
                                <option value="Purchased Item">Purchased Item</option>
                                <option value="Manufactured Item">Manufactured Item</option>
                                <option value="Service">Service</option>
                            </select>
                            <div class="invalid-feedback-item_type text-danger font-italic"></div>
                            <span class="text-success font-italic">
                                <i class="fa fa-info-circle"></i>
                                &nbsp;if you choose "Service", it's mean non-stockable item type.
                            </span>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
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
                    </div> --}}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtn">
                        <strong>Save Changes</strong>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('header-scripts')
<style>
    .select2-container.select2-container--default.select2-container--open {
        z-index: 9999999 !important;
    }
    .select2 {
        width: 100% !important;
    }
</style>
@endpush