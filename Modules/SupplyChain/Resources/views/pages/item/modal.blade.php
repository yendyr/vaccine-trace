<!-- Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Code</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code">                            
                                    <div class="invalid-feedback-code text-danger font-italic"></div>                            
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Item Name</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                                    <div class="invalid-feedback-name text-danger font-italic"></div>
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Model</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('model') is-invalid @enderror" name="model" id="model">
                                    <div class="invalid-feedback-model text-danger font-italic"></div>
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Type</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                                    <div class="invalid-feedback-type text-danger font-italic"></div>
                                </div>
                            </div>         
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Description/Remark</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description">
                                    <div class="invalid-feedback-description text-danger font-italic"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Category</label>
                                <div class="col-sm-7">
                                    <select class="category_id form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id"></select>
                                    <div class="invalid-feedback-category_id text-danger font-italic"></div>
                                </div>
                            </div>            
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Primary Unit</label>
                                <div class="col-sm-7">
                                    <select class="primary_unit_id form-control @error('primary_unit_id') is-invalid @enderror" id="primary_unit_id" name="primary_unit_id"></select>
                                    <div class="invalid-feedback-primary_unit_id text-danger font-italic"></div>
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Reorder Stock Level</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control @error('reorder_stock_level') is-invalid @enderror" name="reorder_stock_level" id="reorder_stock_level" min="0">
                                    <div class="invalid-feedback-reorder_stock_level text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Manufacturer</label>
                                <div class="col-sm-7">
                                    <select class="manufacturer_id form-control @error('manufacturer_id') is-invalid @enderror" id="manufacturer_id" name="manufacturer_id"></select>
                                    <div class="invalid-feedback-manufacturer_id text-danger font-italic"></div>
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
                    </div>
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