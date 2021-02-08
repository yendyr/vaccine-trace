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

            <form method="post" id="inputForm">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Role Name</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('role_name') is-invalid @enderror" name="role_name" id="role_name" readonly>
                            <div class="invalid-feedback-name text-danger font-italic"></div>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Code</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code">                            
                            <div class="invalid-feedback-code text-danger font-italic"></div>                            
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Role Name Alias</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('role_name_alias') is-invalid @enderror" name="role_name_alias" id="role_name_alias">                            
                            <div class="invalid-feedback-role_name_alias text-danger font-italic"></div>                            
                        </div>
                    </div> 
                    <div class="form-group row m-b">
                        <label class="col-sm-5 d-flex align-items-center">Description/Remark</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description">
                            <div class="invalid-feedback-description text-danger font-italic"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 d-flex align-items-center">Authorize as In-Flight Role</label>
                        <div class="col-sm-7">     
                            <div class="pretty p-icon p-round p-jelly p-bigger" style="font-size: 15pt;">   
                                <input type="checkbox" class="form-control @error('is_in_flight_role') is-invalid @enderror" name="is_in_flight_role" id="is_in_flight_role" />
                                <div class="state p-primary">
                                    <i class="icon fa fa-check"></i>
                                    <label></label>
                                </div>
                                <div class="invalid-feedback-is_in_flight_role text-danger font-italic"></div>
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