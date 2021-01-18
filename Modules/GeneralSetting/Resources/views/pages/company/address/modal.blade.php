<!-- Modal -->
<div class="modal fade" id="inputModalAddress" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleAddress"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputForm">
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="company_id" name="company_id" value="{{ $Company->id }}">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Label</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('label') is-invalid @enderror" name="label" id="label">                            
                                    <div class="invalid-feedback-label text-danger font-italic"></div>                            
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Name</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                                    <div class="invalid-feedback-name text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Street</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('street') is-invalid @enderror" name="street" id="street">
                                    <div class="invalid-feedback-street text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">City</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id="city">
                                    <div class="invalid-feedback-city text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Province Number</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('province') is-invalid @enderror" name="province" id="province">
                                    <div class="invalid-feedback-province text-danger font-italic"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Country</label>
                                <div class="col-sm-7">
                                    <select class="country form-control @error('country') is-invalid @enderror" name="country" id="country"></select>
                                    <div class="invalid-feedback-country text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Post Code</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('post_code') is-invalid @enderror" name="post_code" id="post_code">
                                    <div class="invalid-feedback-post_code text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Latitude</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" id="latitude">
                                    <div class="invalid-feedback-latitude text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Longitude</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" id="longitude">
                                    <div class="invalid-feedback-longitude text-danger font-italic"></div>
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
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtnAddress">
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