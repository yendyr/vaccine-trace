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
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Code</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" readonly>                            
                                    <div class="invalid-feedback-code text-danger font-italic"></div>                            
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Item Name</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" readonly>
                                    <div class="invalid-feedback-name text-danger font-italic"></div>
                                </div>
                            </div>    
                            <div class="form-group row m-b">
                                <label class="col-sm-5 d-flex align-items-center">Description/Remark</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" readonly>
                                    <div class="invalid-feedback-description text-danger font-italic"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row m-b">
                                <div class="col-md-12">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            <i class="fa fa-folder"></i>&nbsp;COA Binding
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group row">
                                                <label class="col-sm-5 d-flex align-items-center">Sales</label>
                                                <div class="col-sm-7">
                                                    <select class="sales_coa_id form-control @error('sales_coa_id') is-invalid @enderror" id="sales_coa_id" name="sales_coa_id"></select>
                                                    <div class="invalid-feedback-sales_coa_id text-danger font-italic"></div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-5 d-flex align-items-center">Inventory</label>
                                                <div class="col-sm-7">
                                                    <select class="inventory_coa_id form-control @error('inventory_coa_id') is-invalid @enderror" id="inventory_coa_id" name="inventory_coa_id"></select>
                                                    <div class="invalid-feedback-inventory_coa_id text-danger font-italic"></div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-5 d-flex align-items-center">Cost</label>
                                                <div class="col-sm-7">
                                                    <select class="cost_coa_id form-control @error('cost_coa_id') is-invalid @enderror" id="cost_coa_id" name="cost_coa_id"></select>
                                                    <div class="invalid-feedback-cost_coa_id text-danger font-italic"></div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-5 d-flex align-items-center">Inventory Adjustment</label>
                                                <div class="col-sm-7">
                                                    <select class="inventory_adjustment_coa_id form-control @error('inventory_adjustment_coa_id') is-invalid @enderror" id="inventory_adjustment_coa_id" name="inventory_adjustment_coa_id"></select>
                                                    <div class="invalid-feedback-inventory_adjustment_coa_id text-danger font-italic"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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