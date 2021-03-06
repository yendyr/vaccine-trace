@push('footer-scripts')
<script>
    function showCreateModal(modalTitle, inputFormId, actionUrl, inputModalId = null) {
        this.modalTitle = modalTitle;
        this.inputFormId = inputFormId;
        this.actionUrl = actionUrl;

        $('#modalTitle').html(modalTitle);
        $(inputFormId).attr('action', actionUrl);
        $('#saveBtn').val("create");
        $(inputFormId).trigger("reset");
        $('select').not('[name$="_length"]').val(null).trigger('change');

        if (inputModalId == null)
            $('#inputModal').modal('show');
        else
            $(inputModalId).modal('show');
        $("input[value='patch']").remove();
    }

    function showCreateModalDynamic(inputModalId, modalTitleId, modalTitle, saveButtonId, inputFormId, actionUrl) {
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
        $('select').not('[name$="_length"]').val(null).trigger('change');
        $('[class^="invalid-feedback-"]').html('');
        $(inputModalId).modal('show');
        $("input[value='patch']").remove();
    }

    function submitButtonProcess(targetTableId, inputFormId) {
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
            beforeSend: function() {
                let l = $('.ladda-button-submit').ladda();
                l.ladda('start');
                $('[class^="invalid-feedback-"]').html('');
                $('#saveBtn').prop('disabled', true);
            },
            error: function(data) {
                let errors = data.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(index, value) {
                        $('div.invalid-feedback-' + index).html(value);
                    })
                }
            },
            success: function(data) {
                if (data.success) {
                    generateToast('success', data.success);
                } else if (data.error) {
                    swal.fire({
                        titleText: "Action Failed",
                        text: data.error,
                        icon: "error",
                    });
                }

                $('#inputModal').modal('hide');
                if ($(targetTableId).length !== 0) {
                    $(targetTableId).DataTable().ajax.reload(null, true);
                }

                if (data.redirectUrl && data.success && targetTableId == null) {
                    setTimeout(function() {
                        window.location.href = data.redirectUrl;
                    }, 3000);    
                }
            },
            complete: function() {
                let l = $('.ladda-button-submit').ladda();
                l.ladda('stop');
                $('#saveBtn').prop('disabled', false);
            }
        });
    }

    function submitButtonProcessDynamic(targetTableId, inputFormId, inputModalId) {
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
            beforeSend: function() {
                let l = $('.ladda-button-submit').ladda();
                l.ladda('start');
                $('[class^="invalid-feedback-"]').html('');
                $('#saveBtn').prop('disabled', true);
            },
            error: function(data) {
                let errors = data.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(index, value) {
                        $('div.invalid-feedback-' + index).html(value);
                    })
                }
            },
            success: function(data) {
                if (data.success) {
                    generateToast('success', data.success);
                }
                $(inputModalId).modal('hide');
                if ($(targetTableId).length !== 0) {
                    $(targetTableId).DataTable().ajax.reload(null, true);
                }
                
                if (data.redirectUrl && data.success && targetTableId == null) {
                    setTimeout(function() {
                        window.location.href = data.redirectUrl;
                    }, 3000);    
                }
            },
            complete: function() {
                let l = $('.ladda-button-submit').ladda();
                l.ladda('stop');
                $('#saveBtn').prop('disabled', false);
            }
        });
    }

    function deleteButtonProcess(datatabelObject, targetTableId, actionUrl) {
        this.datatabelObject = datatabelObject;
        this.targetTableId = targetTableId;
        this.actionUrl = actionUrl;

        datatabelObject.on('click', '.deleteBtn', function() {
            rowId = $(this).val();
            $('#deleteModal').modal('show');
            $('#delete-form').attr('action', actionUrl + '/' + rowId);
        });

        $('#delete-form').on('submit', function(e) {
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
                beforeSend: function() {
                    let l = $('.ladda-button-submit').ladda();
                    l.ladda('start');
                    $('[class^="invalid-feedback-"]').html('');
                    $('#delete-button').text('Deleting...');
                    $('#delete-button').prop('disabled', true);
                },
                error: function(data) {
                    if (data.error) {
                        generateToast('error', data.error);
                    }
                },
                success: function(data) {
                    if (data.success) {
                        generateToast('success', data.success);
                    } else if (data.error) {
                        swal.fire({
                            titleText: "Action Failed",
                            text: data.error,
                            icon: "error",
                        });
                    }
                },
                complete: function(data) {
                    let l = $('.ladda-button-submit').ladda();
                    l.ladda('stop');
                    $('#delete-button').text('Delete');
                    $('#deleteModal').modal('hide');
                    $('#delete-button').prop('disabled', false);
                    if ($(targetTableId).length !== 0) {
                        $(targetTableId).DataTable().ajax.reload(null, true);
                    }

                    if (data.redirectUrl && data.success && targetTableId == null) {
                        setTimeout(function() {
                            window.location.href = data.redirectUrl;
                        }, 3000);    
                    }
                }
            });
        });
    }

    function approveButtonProcess(datatabelObject, targetTableId, actionUrl) {
        this.datatabelObject = datatabelObject;
        this.targetTableId = targetTableId;
        this.actionUrl = actionUrl;

        datatabelObject.on('click', '.approveBtn', function() {
            rowId = $(this).val();
            $('#approve-form').trigger("reset");
            $('#approveModal').modal('show');
            $('#approve-form').attr('action', actionUrl + '/' + rowId + '/approve');
        });

        $('#approve-form').on('submit', function(e) {
            e.preventDefault();
            let url_action = $(this).attr('action');
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content")
                },
                url: url_action,
                type: "POST",
                data: $('#approve-form').serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('#approve-button').text('Approving...');
                    $('#approve-button').prop('disabled', true);
                },
                error: function(data) {
                    if (data.error) {
                        generateToast('error', data.error);
                    }
                },
                success: function(data) {
                    if (data.success) {
                        generateToast('success', data.success);
                    } else if (data.error) {
                        swal.fire({
                            titleText: "Action Failed",
                            text: data.error,
                            icon: "error",
                        });
                    }
                },
                complete: function(data) {
                    $('#approve-button').text('Approve');
                    $('#approveModal').modal('hide');
                    $('#approve-button').prop('disabled', false);
                    if ($(targetTableId).length !== 0) {
                        $(targetTableId).DataTable().ajax.reload(null, true);
                    }

                    if (data.redirectUrl && data.success && targetTableId == null) {
                        setTimeout(function() {
                            window.location.href = data.redirectUrl;
                        }, 3000);    
                    }
                }
            });
        });
    }

    function generateButtonProcess(datatabelObject, targetTableId, actionUrl) {
        this.datatabelObject = datatabelObject;
        this.targetTableId = targetTableId;
        this.actionUrl = actionUrl;

        datatabelObject.on('click', '.generateBtn', function() {
            rowId = $(this).val();
            $('#generate-form').trigger("reset");
            $('#generateModal').modal('show');
            $('#generate-form').attr('action', actionUrl + '/' + rowId + '/generate');
        });

        $('#generate-form').on('submit', function(e) {
            e.preventDefault();
            let url_action = $(this).attr('action');
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content")
                },
                url: url_action,
                type: "POST",
                data: $('#generate-form').serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('#generate-button').text('Approving...');
                    $('#generate-button').prop('disabled', true);
                },
                error: function(data) {
                    if (data.error) {
                        generateToast('error', data.error);
                    }
                },
                success: function(data) {
                    if (data.success) {
                        generateToast('success', data.success);
                    } else if (data.error) {
                        swal.fire({
                            titleText: "Action Failed",
                            text: data.error,
                            icon: "error",
                        });
                    }
                },
                complete: function(data) {
                    $('#generate-button').text('Approve');
                    $('#generateModal').modal('hide');
                    $('#generate-button').prop('disabled', false);
                    if ($(targetTableId).length !== 0) {
                        $(targetTableId).DataTable().ajax.reload(null, true);
                    }

                    if (data.redirectUrl && data.success && targetTableId == null) {
                        setTimeout(function() {
                            window.location.href = data.redirectUrl;
                        }, 3000);    
                    }
                }
            });
        });
    }

    function clearForm(inputFormId) {
        this.inputFormId = inputFormId;

        $(inputFormId).trigger("reset");
        $('select').not('[name$="_length"]').val(null).trigger('change');
        $('[class^="invalid-feedback-"]').html('');
    }

    function formatNumber(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>
@endpush