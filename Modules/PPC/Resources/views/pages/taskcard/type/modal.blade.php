<!-- Modal -->
<div class="modal fade" id="TaskcardTypeModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" id="TaskcardTypeForm">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Code &nbsp;</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" id="fcode" name="code" >
                            <div class="invalid-feedback-code text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label>Task Card Type Name &nbsp;</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" id="fname" name="name" >
                            <div class="invalid-feedback-name text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Description/Remark</label>
                            <input type="text" class="form-control" id="fdescription" name="description" >
                            <div class="invalid-feedback-description text-danger"></div>
                        </div>
                    </div>                    
                    <div class="form-group row d-flex align-items-center">
                        <div class="col-md-12">
                            {{-- <div class="col-md-6">
                                <label>Status</label>
                                <select class="select2_status form-control m-b" id="fstatus" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <div class="invalid-feedback-status text-danger"></div>
                            </div> --}}
                            <span>Active&nbsp;</span>
                            <input type="checkbox" class="js-switch" id="fstatus" name="status" checked />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary"  data-style="zoom-in" type="submit" id="saveBtn">
                        <strong>Save Changes</strong>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('footer-scripts')
<script>
    var elem = document.querySelector('.js-switch');
    var switchery = new Switchery(elem, { color: '#1AB394' });
</script>
@endpush