<!-- Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="d-inline" id="{{ $executeFormId ?? 'execute-form' }}" name="executeForm">
                @csrf
                <input type="hidden" name="_method" value="patch">
                <div class="modal-body">
                    <div class="row m-b d-flex justify-content-center">
                        <i class="fa fa-check-circle-o fa-5x fa-fw text-success"></i>
                    </div>
                    <div class="row m-b">
                        Execution Notes:
                    </div>
                    <div class="row">
                        <input class="form-control @error('execution_notes') is-invalid @enderror" type="text" id="execution_notes"  name="execution_notes" required>
                        <div class="invalid-feedback-execution_notes text-danger font-italic"></div>
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="{{ $executeModalButtonId ?? 'execute-button' }}" type="submit" class="btn btn-primary">Execute</button>
                </div>
            </form>

        </div>
    </div>
</div>