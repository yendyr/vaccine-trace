<!-- Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
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
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Purchase Requisition Reference</label>
                                <div class="col-sm-7">
                                    <input type="text" class="purchase_requisition_code form-control" name="purchase_requisition_code" id="purchase_requisition_code" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Item Part Number & Name</label>
                                <div class="col-sm-7">
                                    <input type="text" class="item form-control" name="item" id="item" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Purchase Requisition Remark</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="description" id="description" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Request Quantity</label>
                                <div class="col input-group">
                                    <input type="text" class="form-control" name="request_quantity" id="request_quantity" readonly>
                                    <input type="text" class="unit form-control" name="unit" id="unit" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">In-Stock Quantity</label>
                                <div class="col input-group">
                                    <input type="text" class="form-control" name="available_stock" id="available_stock" readonly>
                                    <input type="text" class="unit form-control" name="unit" id="unit" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Prepared to PO Quantity</label>
                                <div class="col input-group">
                                    <input type="text" class="form-control" name="prepared_to_po_quantity" id="prepared_to_po_quantity" readonly>
                                    <input type="text" class="unit form-control" name="unit" id="unit" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Processed to PO Quantity</label>
                                <div class="col input-group">
                                    <input type="text" class="form-control" name="processed_to_po_quantity" id="processed_to_po_quantity" readonly>
                                    <input type="text" class="unit form-control" name="unit" id="unit" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" id="purchase_order_id" name="purchase_order_id" value="{{ $PurchaseOrder->id ?? '' }}">
                            <input type="hidden" id="purchase_requisition_detail_id" name="purchase_requisition_detail_id">

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Purchase Order Quantity</label>
                                <div class="col input-group">
                                    <input type="number" min="1" class="form-control" name="order_quantity" id="order_quantity" required>
                                    <input type="text" class="form-control" name="order_unit" id="order_unit" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Order Remark</label>
                                <div class="col-sm-7">
                                    <input type="text" min="1" class="form-control" name="order_remark" id="order_remark" required>
                                </div>
                            </div>

                            <div class="form-group row" id="required_delivery_date">
                                <label class="col-sm-5 d-flex align-items-center">Required Delivery Date</label>
                                <div class="col-md-7 input-group date">
                                    <span class="input-group-addon">Date</span>
                                    <input type="text" class="required_delivery_date form-control @error('required_delivery_date') is-invalid @enderror" name="required_delivery_date" id="required_delivery_date" readonly="true">
                                    <div class="invalid-feedback-required_delivery_date text-danger font-italic"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">@ Price Before Tax ({{ $PurchaseOrder->currency->code }})</label>
                                <div class="col input-group">
                                    <input type="number" min="1" class="form-control" name="each_price_before_vat" id="each_price_before_vat" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Tax (%)</label>
                                <div class="col input-group">
                                    <input type="number" min="0" step="0.1" class="form-control" name="vat" id="vat" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Total Price ({{ $PurchaseOrder->currency->code }})</label>
                                <div class="col input-group">
                                    <input type="text" class="form-control font-bold" name="total_price" id="total_price" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtn">
                        <strong id="saveButtonModalText">Save</strong>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@push('header-scripts')
<link href="{{ URL::asset('theme/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<style>
    .select2-container.select2-container--default.select2-container--open {
        z-index: 9999999 !important;
    }
    .select2 {
        width: 100% !important;
    }
</style>
@endpush

@push('footer-scripts')
<script src="{{ URL::asset('theme/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script>
    var mem_required_delivery_date = $('#required_delivery_date .input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
</script>
@endpush