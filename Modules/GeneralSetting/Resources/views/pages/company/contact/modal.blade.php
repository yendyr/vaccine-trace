<!-- Modal -->
<div class="modal fade" id="inputModalContact" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleContact"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputFormContact">
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
                                <label class="col-sm-5 d-flex align-items-center">Email</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email">
                                    <div class="invalid-feedback-email text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Mobile Number</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" id="mobile_number">
                                    <div class="invalid-feedback-mobile_number text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Office Number</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('office_number') is-invalid @enderror" name="office_number" id="office_number">
                                    <div class="invalid-feedback-office_number text-danger font-italic"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Fax Number</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('fax_number') is-invalid @enderror" name="fax_number" id="fax_number">
                                    <div class="invalid-feedback-fax_number text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Other Number</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('other_number') is-invalid @enderror" name="other_number" id="other_number">
                                    <div class="invalid-feedback-other_number text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Website</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('website') is-invalid @enderror" name="website" id="website">
                                    <div class="invalid-feedback-website text-danger font-italic"></div>
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
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveButtonContact">
                        <strong>Save Changes</strong>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>