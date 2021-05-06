<!-- Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputWorkPackageForm">
                <input type="hidden" id="work_order_id" name="work_order_id" value="{{ $work_order?->id }}">
                <input type="hidden" id="id" name="id">

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12 text-success font-bold" id="work_package_info">

                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 d-flex align-items-center">Code</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code">
                            <div class="invalid-feedback-code text-danger font-italic"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 d-flex align-items-center">Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                            <div class="invalid-feedback-name text-danger font-italic"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 d-flex align-items-center">Performance Factor</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control @error('performance_factor') is-invalid @enderror" name="performance_factor" id="performance_factor" step="0.1" min=0>
                            <div class="invalid-feedback-performance_factor text-danger font-italic"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 d-flex align-items-center">Remark</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description">
                            <div class="invalid-feedback-description text-danger font-italic"></div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtn">
                        <strong id="saveButtonModalText">Save Changes</strong>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>