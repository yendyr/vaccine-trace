<!-- Modal Approve -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-bold" id="approveModalLabel">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="d-inline" id="{{ $approveFormId ?? 'approve-form' }}" name="approveForm">
                <div class="modal-body">
                    <div class="row m-b d-flex justify-content-center">
                        <i class="fa fa-check-circle-o fa-5x fa-fw text-success"></i>
                    </div>
                    <div class="row m-b">
                        Approval Notes:
                    </div>
                    <div class="row">
                        <input class="form-control @error('approval_notes') is-invalid @enderror" type="text" id="approval_notes"  name="approval_notes" required>
                        <div class="invalid-feedback-approval_notes text-danger font-italic"></div>
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="{{ $approveModalButtonId ?? 'approve-button' }}" type="submit" class="btn btn-primary">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>