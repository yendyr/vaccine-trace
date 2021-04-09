<!-- Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
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
                        <label class="col-sm-5 d-flex align-items-center">Transaction Code</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" readonly value="Generated After Saved">
                            <div class="invalid-feedback-code text-danger font-italic"></div>
                        </div>
                    </div>

                    <div class="form-group row" id="transaction_date">
                        <label class="col-sm-5 d-flex align-items-center">Transaction Date</label>
                        <div class="col-md-7 input-group date">
                            <span class="input-group-addon">Date</span>
                            <input type="text" class="transaction_date form-control @error('transaction_date') is-invalid @enderror" name="transaction_date" id="transaction_date" readonly="true" required>
                            <div class="invalid-feedback-transaction_date text-danger font-italic"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Warehouse Origin</label>
                        <div class="col-sm-7">
                            <select class="warehouse_origin form-control @error('warehouse_origin') is-invalid @enderror" name="warehouse_origin" id="warehouse_origin" required></select>
                            <div class="invalid-feedback-warehouse_origin text-danger font-italic"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Warehouse Destination</label>
                        <div class="col-sm-7">
                            <select class="warehouse_destination form-control @error('warehouse_destination') is-invalid @enderror" name="warehouse_destination" id="warehouse_destination" required></select>
                            <div class="invalid-feedback-warehouse_destination text-danger font-italic"></div>
                        </div>
                    </div>  

                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Remark</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" required>
                            <div class="invalid-feedback-description text-danger font-italic"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtn">
                        <strong>Save</strong>
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
    var mem_transaction_date = $('#transaction_date .input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
</script>
@endpush