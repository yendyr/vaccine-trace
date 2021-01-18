<!-- Modal Delete -->
<div class="modal fade" id="{{ $deleteModalId ?? 'deleteModal' }}" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-bold">Delete Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                Are you sure to delete this data?
            </div>
            <div class="modal-footer">
                <form class="d-inline" id="{{ $deleteFormId ?? 'delete-form' }}" name="deleteForm">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="{{ $deleteModalButtonId ?? 'delete-button' }}" type="submit" data-style="zoom-in" class="ladda-button ladda-button-submit btn btn-danger">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>