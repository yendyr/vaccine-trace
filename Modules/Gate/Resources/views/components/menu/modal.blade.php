<!-- Modal -->
<div class="modal fade" id="menuModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="menuForm">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Group</label>
                            <input type="text" class="form-control @error('group') is-invalid @enderror" id="group" name="group">
                            <div class="invalid-feedback-group text-danger"></div>
                        </div><div class="col-md-6">
                            <label>Name/Text</label>
                            <input type="text" class="form-control @error('menu_text') is-invalid @enderror" id="menu_text" name="menu_text">
                            <div class="invalid-feedback-menu_text text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label>Icon Name</label>
                            <input type="text" class="form-control @error('icon_name') is-invalid @enderror" id="menu_icon" name="menu_icon">
                            <div class="invalid-feedback-icon_name text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label>Class</label>
                            <input type="text" class="form-control @error('menu_class') is-invalid @enderror" id="menu_class" name="menu_class">
                            <div class="invalid-feedback-menu_class text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label>Actives</label>
                            <select class="form-control select2_menu_actives @error('menu_actives') is-invalid @enderror" id="menu_actives" name="menu_actives[]"  style="width: 100%;" multiple></select>
                            <div class="invalid-feedback-menu_actives text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label>Parent</label>
                            <select class="form-control m-b select2_menu" id="parent_id" name="parent_id" style="width: 100%;">
                            </select>
                            <div class="invalid-feedback-parent text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label>Link</label>
                            <input type="text" class="form-control @error('menu_link') is-invalid @enderror" id="menu_link" name="menu_link">
                            <div class="invalid-feedback-menu_link text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label>Route</label>
                            <input type="text" class="form-control @error('menu_route') is-invalid @enderror" id="menu_route" name="menu_route">
                            <div class="invalid-feedback-menu_route text-danger"></div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-6">     
                        <label class="col-md-6 d-flex align-items-center">Add</label>
                            <div class="pretty p-icon p-round p-jelly p-bigger" style="font-size: 15pt;">   
                                <input type="checkbox" class="form-control @error('add') is-invalid @enderror" name="add" id="add" />
                                <div class="state p-primary">
                                    <i class="icon fa fa-check"></i>
                                    <label></label>
                                </div>
                                <div class="invalid-feedback-status text-danger font-italic"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-6">     
                        <label class="col-md-6 d-flex align-items-center">Update</label>
                            <div class="pretty p-icon p-round p-jelly p-bigger" style="font-size: 15pt;">   
                                <input type="checkbox" class="form-control @error('update') is-invalid @enderror" name="update" id="update" />
                                <div class="state p-primary">
                                    <i class="icon fa fa-check"></i>
                                    <label></label>
                                </div>
                                <div class="invalid-feedback-status text-danger font-italic"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-6">     
                        <label class="col-md-6 d-flex align-items-center">Delete</label>
                            <div class="pretty p-icon p-round p-jelly p-bigger" style="font-size: 15pt;">   
                                <input type="checkbox" class="form-control @error('delete') is-invalid @enderror" name="delete" id="delete" />
                                <div class="state p-primary">
                                    <i class="icon fa fa-check"></i>
                                    <label></label>
                                </div>
                                <div class="invalid-feedback-status text-danger font-italic"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-6">     
                        <label class="col-md-6 d-flex align-items-center">Print</label>
                            <div class="pretty p-icon p-round p-jelly p-bigger" style="font-size: 15pt;">   
                                <input type="checkbox" class="form-control @error('print') is-invalid @enderror" name="print" id="print" />
                                <div class="state p-primary">
                                    <i class="icon fa fa-check"></i>
                                    <label></label>
                                </div>
                                <div class="invalid-feedback-status text-danger font-italic"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-6">     
                        <label class="col-md-6 d-flex align-items-center">Process</label>
                            <div class="pretty p-icon p-round p-jelly p-bigger" style="font-size: 15pt;">   
                                <input type="checkbox" class="form-control @error('process') is-invalid @enderror" name="process" id="process" />
                                <div class="state p-primary">
                                    <i class="icon fa fa-check"></i>
                                    <label></label>
                                </div>
                                <div class="invalid-feedback-status text-danger font-italic"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">     
                            <label class="col-md-6 d-flex align-items-center">Approval</label>
                            <input class="col-md-12" min="0" type="number" value="" name="approval" name="approval">
                        </div>
                        <div class="col-md-6 col-sm-6 col-6">
                        <label class="col-md-6 d-flex align-items-center">Status</label>
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
                        <strong>Save changes</strong>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

