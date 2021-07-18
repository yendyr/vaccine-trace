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
                        <label class="col-md-5 d-flex align-items-center">Tanggal Vaksinasi</label>
                        <div class="col-md-7">
                            <div class="form-group" id="date">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="date form-control @error('date') is-invalid @enderror" name="date" id="date" readonly="true" required>
                                    <div class="invalid-feedback-date text-danger font-italic"></div>
                                </div>
                            </div>                           
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Satuan</label>
                        <div class="col-sm-7">
                            <select class="squad_id form-control @error('squad_id') is-invalid @enderror" id="squad_id" name="squad_id" required></select>
                            <div class="invalid-feedback-squad_id text-danger font-italic"></div>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Kategori Partisipan</label>
                        <div class="col-sm-7">
                            <select class="category form-control @error('category') is-invalid @enderror" name="category" id="category" required>
                                <option value="TNI">TNI</option>
                                <option value="KBT">KBT</option>
                                <option value="Umum">Umum</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <div class="invalid-feedback-category text-danger font-italic"></div>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Total Harian</label>
                        <div class="col-sm-7">
                            <input type="number" min="0" class="form-control @error('total') is-invalid @enderror" name="total" id="total" required>
                            <div class="invalid-feedback-total text-danger font-italic"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtn">
                        <strong>Simpan</strong>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('footer-scripts')
<script src="{{ URL::asset('theme/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script>
    var mem_date = $('#date .input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
</script>
@endpush

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