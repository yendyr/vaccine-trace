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
                        <label class="col-sm-5 d-flex align-items-center">ISO</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('iso') is-invalid @enderror" name="iso" id="iso">                            
                            <div class="invalid-feedback-iso text-danger font-italic"></div>                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">ISO-3</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('iso-3') is-invalid @enderror" name="iso3" id="iso3">                            
                            <div class="invalid-feedback-iso-3 text-danger font-italic"></div>                            
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
                        <label class="col-sm-5 d-flex align-items-center">Nice Name</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('nice_name') is-invalid @enderror" name="nice_name" id="nice_name">
                            <div class="invalid-feedback-nice_name text-danger font-italic"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Num. Code</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('num_code') is-invalid @enderror" name="num_code" id="num_code">                            
                            <div class="invalid-feedback-num_code text-danger font-italic"></div>                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Phone Code</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('phone_code') is-invalid @enderror" name="phone_code" id="phone_code">                            
                            <div class="invalid-feedback-phone_code text-danger font-italic"></div>                            
                        </div>
                    </div>                                
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Description/Remark</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description">
                            <div class="invalid-feedback-description text-danger font-italic"></div>
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