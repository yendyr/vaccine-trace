<!-- Modal -->
<div class="modal fade" id="inputModalDiscrepancy" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleDiscrepancy"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputFormDiscrepancy">
                <input type="hidden" id="afm_log_id" name="afm_log_id" value="{{ $afmlog->id ?? '' }}">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title">
                            <div class="invalid-feedback-title text-danger font-italic"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Description</label>
                            <input type="text" class="form-control @error('discrepancy_description') is-invalid @enderror" name="discrepancy_description" id="discrepancy_description">
                            <div class="invalid-feedback-discrepancy_description text-danger font-italic"></div>
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
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveButtonDiscrepancy">
                        <strong>Save Changes</strong>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>