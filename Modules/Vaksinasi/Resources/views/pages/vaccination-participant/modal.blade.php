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
                        <label class="col-sm-5 d-flex align-items-center">Tanggal Vaksinasi</label>
                        <div class="col-sm-7">
                            <div class="form-group" id="date">
                                <div class="input-group date">
                                    <span class="input-group-addon">Date</span>
                                    <input type="text" class="date form-control @error('date') is-invalid @enderror" name="date" id="date" readonly="true" required>
                                    <div class="invalid-feedback-date text-danger font-italic"></div>
                                </div>
                            </div>                           
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Jenis Identitas</label>
                        <div class="col-sm-7">
                            <select class="id_type form-control @error('id_type') is-invalid @enderror" name="id_type" id="id_type">
                                <option value="KTP">KTP</option>
                                <option value="SIM">SIM</option>
                                <option value="Paspor">Paspor</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <div class="invalid-feedback-id_type text-danger font-italic"></div>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Nomor Identitas</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('id_number') is-invalid @enderror" name="id_number" id="id_number" required>
                            <div class="invalid-feedback-id_number text-danger font-italic"></div>
                        </div>
                    </div>         
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Satuan</label>
                        <div class="col-sm-7">
                            <select class="squad_id form-control @error('squad_id') is-invalid @enderror" id="squad_id" name="squad_id"></select>
                            <div class="invalid-feedback-squad_id text-danger font-italic"></div>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Kategori Partisipan</label>
                        <div class="col-sm-7">
                            <select class="category form-control @error('category') is-invalid @enderror" name="category" id="category">
                                <option value="TNI">TNI</option>
                                <option value="KBT">KBT</option>
                                <option value="Umum">Umum</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <div class="invalid-feedback-category text-danger font-italic"></div>
                        </div>
                    </div>           
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Nama Partisipan</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required>
                            <div class="invalid-feedback-name text-danger font-italic"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Alamat</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address">
                            <div class="invalid-feedback-address text-danger font-italic"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Jenis Vaksin</label>
                        <div class="col-sm-7">
                            <select class="vaccine_used form-control @error('vaccine_used') is-invalid @enderror" name="vaccine_used" id="vaccine_used">
                                <option value="SinoVac">SinoVac</option>
                                <option value="AstraZeneca">AstraZeneca</option>
                                <option value="Moderna">Moderna</option>
                                <option value="Sinopharm">Sinopharm</option>
                                <option value="CanSino">CanSino</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <div class="invalid-feedback-vaccine_used text-danger font-italic"></div>
                        </div>
                    </div>   
                    {{-- <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Aktif</label>
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
<style>
    .select2-container.select2-container--default.select2-container--open {
        z-index: 9999999 !important;
    }
    .select2 {
        width: 100% !important;
    }
</style>
@endpush