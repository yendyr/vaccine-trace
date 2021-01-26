@push('footer-scripts')
<script>
    function showCreateModal (modalTitle, inputFormId, actionUrl) {
        this.modalTitle = modalTitle;
        this.inputFormId = inputFormId;
        this.actionUrl = actionUrl;

        $('#modalTitle').html(modalTitle);
        $(inputFormId).attr('action', actionUrl);
        $('#saveBtn').val("create");
        $(inputFormId).trigger("reset");
        $('[class^="invalid-feedback-"]').html('');
        $('#inputModal').modal('show');                
        $("input[value='patch']").remove();
    }

    function showCreateModalDynamic (inputModalId, modalTitleId, modalTitle, saveButtonId, inputFormId, actionUrl) {
        this.inputModalId = inputModalId;
        this.modalTitleId = modalTitleId;
        this.modalTitle = modalTitle;
        this.saveButtonId = saveButtonId;
        this.inputFormId = inputFormId;
        this.actionUrl = actionUrl;

        $(modalTitleId).html(modalTitle);
        $(inputFormId).attr('action', actionUrl);
        $(saveButtonId).val("create");
        $(inputFormId).trigger("reset");
        $('[class^="invalid-feedback-"]').html('');
        $(inputModalId).modal('show');                
        $("input[value='patch']").remove();
    }

    function submitButtonProcess (targetTableId, inputFormId) {
        this.targetTableId = targetTableId;
        this.inputFormId = inputFormId;

        event.preventDefault();
        let url_action = $(inputFormId).attr('action');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $(
                    'meta[name="csrf-token"]'
                ).attr("content")
            },
            url: url_action,
            method: "POST",
            data: $(inputFormId).serialize(),
            dataType: 'json',
            beforeSend:function(){
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'start' );
                $('[class^="invalid-feedback-"]').html('');
                $('#saveBtn').prop('disabled', true);
            },
            error: function(data){
                let errors = data.responseJSON.errors;
                if (errors) {
                    $.each(errors, function (index, value) {
                        $('div.invalid-feedback-'+index).html(value);
                    })
                }
            },
            success: function (data) {
                if (data.success) {
                    generateToast ('success', data.success);                            
                }
                $('#inputModal').modal('hide');
                $(targetTableId).DataTable().ajax.reload();
            },
            complete: function () {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'stop' );
                $('#saveBtn'). prop('disabled', false);
            }
        });
    }

    function submitButtonProcessDynamic (targetTableId, inputFormId, inputModalId) {
        this.targetTableId = targetTableId;
        this.inputFormId = inputFormId;
        this.inputModalId = inputModalId;

        event.preventDefault();
        let url_action = $(inputFormId).attr('action');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $(
                    'meta[name="csrf-token"]'
                ).attr("content")
            },
            url: url_action,
            method: "POST",
            data: $(inputFormId).serialize(),
            dataType: 'json',
            beforeSend:function(){
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'start' );
                $('[class^="invalid-feedback-"]').html('');
                $('#saveBtn').prop('disabled', true);
            },
            error: function(data){
                let errors = data.responseJSON.errors;
                if (errors) {
                    $.each(errors, function (index, value) {
                        $('div.invalid-feedback-'+index).html(value);
                    })
                }
            },
            success: function (data) {
                if (data.success) {
                    generateToast ('success', data.success);                            
                }
                $(inputModalId).modal('hide');
                $(targetTableId).DataTable().ajax.reload();
            },
            complete: function () {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'stop' );
                $('#saveBtn'). prop('disabled', false);
            }
        });
    }

    function deleteButtonProcess (datatabelObject, targetTableId, actionUrl) {
        this.datatabelObject = datatabelObject;
        this.targetTableId = targetTableId;
        this.actionUrl = actionUrl;

        datatabelObject.on('click', '.deleteBtn', function () {
            rowId = $(this).val();
            $('#deleteModal').modal('show');
            $('#delete-form').attr('action', actionUrl + '/' + rowId);
        });

        $('#delete-form').on('submit', function (e) {
            e.preventDefault();
            let url_action = $(this).attr('action');
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content")
                },
                url: url_action,
                type: "DELETE",
                beforeSend:function(){
                    $('#delete-button').text('Deleting...');
                    $('#delete-button').prop('disabled', true);
                },
                error: function(data){
                    if (data.error) {
                        generateToast ('error', data.error);
                    }
                },
                success:function(data){
                    if (data.success){
                        generateToast ('success', data.success);
                    }
                },
                complete: function(data) {
                    $('#delete-button').text('Delete');
                    $('#deleteModal').modal('hide');
                    $('#delete-button').prop('disabled', false);
                    $(targetTableId).DataTable().ajax.reload();
                }
            });
        });
    }
</script>
@endpush