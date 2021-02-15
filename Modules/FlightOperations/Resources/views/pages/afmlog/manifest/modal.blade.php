<!-- Modal -->
<div class="modal fade" id="inputModalManifest" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleManifest"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputFormManifest">
                <input type="hidden" id="afm_log_id" name="afm_log_id" value="{{ $afmlog->id ?? '' }}">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Person</label>
                            <input type="text" class="form-control @error('person') is-invalid @enderror" name="person" id="person">
                            <div class="invalid-feedback-person text-danger font-italic"></div>
                        </div>
                        <div class="col-md-6">
                            <label>Pax</label>
                            <input type="text" class="form-control @error('pax') is-invalid @enderror" name="pax" id="pax">
                            <div class="invalid-feedback-pax text-danger font-italic"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Cargo Weight</label>
                            <input type="text" class="form-control @error('cargo_weight') is-invalid @enderror" name="cargo_weight" id="cargo_weight">
                            <div class="invalid-feedback-cargo_weight text-danger font-italic"></div>
                        </div>

                        <div class="col-md-6">
                            <label>Cargo Weight Unit</label>
                            <select class="cargo_weight_unit_id form-control @error('cargo_weight_unit_id') is-invalid @enderror" id="cargo_weight_unit_id" name="cargo_weight_unit_id"></select>
                            <div class="invalid-feedback-cargo_weight_unit_id text-danger font-italic"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>PCM Number</label>
                            <input type="text" class="form-control @error('pcm_number') is-invalid @enderror" name="pcm_number" id="pcm_number">
                            <div class="invalid-feedback-pcm_number text-danger font-italic"></div>
                        </div>
                        <div class="col-md-6">
                            <label>CM Number</label>
                            <input type="text" class="form-control @error('cm_number') is-invalid @enderror" name="cm_number" id="cm_number">
                            <div class="invalid-feedback-cm_number text-danger font-italic"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Remark</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description">
                            <div class="invalid-feedback-description text-danger font-italic"></div>
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
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveButtonManifest">
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