<!-- Modal -->
<div class="modal fade" id="inputModalAccounting" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleAccounting"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputFormAccounting">
                <input type="hidden" id="updateAccounting" name="updateAccounting" class="updateAccounting" value="1">
                <input type="hidden" id="id" name="id" class="id" value="{{ $Company->id }}">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Account Receivable COA</label>
                                <div class="col-sm-7">
                                    <select class="account_receivable_coa_id form-control @error('account_receivable_coa_id') is-invalid @enderror" name="account_receivable_coa_id" id="account_receivable_coa_id">
                                        @if ($Company->account_receivable_coa_id)
                                            <option value="{{ $Company->account_receivable_coa_id }}" selected>
                                                {{ $Company->account_receivable_coa->code }} | {{ $Company->account_receivable_coa->name }}
                                            </option>
                                        @endif
                                    </select>
                                    <div class="invalid-feedback-account_receivable_coa_id text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Sales Discount COA</label>
                                <div class="col-sm-7">
                                    <select class="sales_discount_coa_id form-control @error('sales_discount_coa_id') is-invalid @enderror" name="sales_discount_coa_id" id="sales_discount_coa_id">
                                        @if ($Company->sales_discount_coa_id)
                                            <option value="{{ $Company->sales_discount_coa_id }}" selected>
                                                {{ $Company->sales_discount_coa->code }} | {{ $Company->sales_discount_coa->name }}
                                            </option>
                                        @endif
                                    </select>
                                    <div class="invalid-feedback-sales_discount_coa_id text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Account Payable COA</label>
                                <div class="col-sm-7">
                                    <select class="account_payable_coa_id form-control @error('account_payable_coa_id') is-invalid @enderror" name="account_payable_coa_id" id="account_payable_coa_id">
                                        @if ($Company->account_payable_coa_id)
                                            <option value="{{ $Company->account_payable_coa_id }}" selected>
                                                {{ $Company->account_payable_coa->code }} | {{ $Company->account_payable_coa->name }}
                                            </option>
                                        @endif
                                    </select>
                                    <div class="invalid-feedback-account_payable_coa_id text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Purchase Discount COA</label>
                                <div class="col-sm-7">
                                    <select class="purchase_discount_coa_id form-control @error('purchase_discount_coa_id') is-invalid @enderror" name="purchase_discount_coa_id" id="purchase_discount_coa_id">
                                        @if ($Company->purchase_discount_coa_id)
                                            <option value="{{ $Company->purchase_discount_coa_id }}" selected>
                                                {{ $Company->purchase_discount_coa->code }} | {{ $Company->purchase_discount_coa->name }}
                                            </option>
                                        @endif
                                    </select>
                                    <div class="invalid-feedback-purchase_discount_coa_id text-danger font-italic"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtnAccounting">
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