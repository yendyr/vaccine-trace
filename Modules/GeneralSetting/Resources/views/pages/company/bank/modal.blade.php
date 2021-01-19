<!-- Modal -->
<div class="modal fade" id="inputModalBank" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleBank"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputFormBank">
                <input type="hidden" id="id" name="id" class="id">
                <input type="hidden" id="company_id" name="company_id" value="{{ $Company->id }}">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Label</label>
                                <div class="col-sm-7">
                                    <input type="text" class="label form-control @error('label') is-invalid @enderror" name="label" id="label">                            
                                    <div class="invalid-feedback-label text-danger font-italic"></div>                            
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Bank Name</label>
                                <div class="col-sm-7">
                                    <input type="text" class="bank_name form-control @error('bank_name') is-invalid @enderror" name="bank_name" id="bank_name">
                                    <div class="invalid-feedback-bank_name text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Bank Branch</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('bank_branch') is-invalid @enderror" name="bank_branch" id="bank_branch">
                                    <div class="invalid-feedback-bank_branch text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Account Holder Name</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('account_holder_name') is-invalid @enderror" name="account_holder_name" id="account_holder_name">
                                    <div class="invalid-feedback-account_holder_name text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Account Number</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('account_number') is-invalid @enderror" name="account_number" id="account_number">
                                    <div class="invalid-feedback-account_number text-danger font-italic"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Chart of Account</label>
                                <div class="col-sm-7">
                                    <select class="chart_of_account_id form-control @error('chart_of_account_id') is-invalid @enderror" name="chart_of_account_id" id="chart_of_account_id"></select>
                                    <div class="invalid-feedback-chart_of_account_id text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Swift Code</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('swift_code') is-invalid @enderror" name="swift_code" id="swift_code">
                                    <div class="invalid-feedback-swift_code text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Description</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description">
                                    <div class="invalid-feedback-description text-danger font-italic"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Active</label>
                                <div class="col-sm-7">     
                                    <div class="pretty p-icon p-round p-jelly p-bigger" style="font-size: 15pt;">   
                                        <input type="checkbox" class="status form-control @error('status') is-invalid @enderror" name="status" id="status" />
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
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtnBank">
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