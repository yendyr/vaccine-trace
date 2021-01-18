@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/generalsetting/company-detail-address/';
        var inputModalId = '#inputModalAddress';
        var modalTitleId = '#modalTitleAddress';
        var saveButtonId = '#saveBtnAddress';
        var inputFormId = '#inputFormAddress';
        var editButtonId = '#editButtonAddress';
        var deleteButtonId = '#deleteButtonAddress';

        $('#createAddress').click(function () {
            showCreateModal (inputModalId, modalTitleId, 'Create New Address', saveButtonId, inputFormId, actionUrl);
        });

        $('.editBtn').click(function (e) {
            $('#modalTitle').html("Edit Address");
            $(inputFormId).trigger("reset");
            
            $('<input>').attr({
                type: 'hidden',
                name: '_method',
                value: 'patch'
            }).prependTo('#inputForm');

            var id = $(this).data('id');
            $.get(actionUrl + id, function (data) {
                $('#id').val(id);
                $('#label').val(data.label);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#mobile_number').val(data.mobile_number);
                $('#office_number').val(data.office_number);
                $('#fax_number').val(data.fax_number);
                $('#other_number').val(data.other_number);
                $('#website').val(data.website);               
                if (data.status == '1') {
                    $('#status').prop('checked', true);
                }
                else {
                    $('#status').prop('checked', false);
                }

                $(inputFormId).attr('action', actionUrl + id);
            });

            $('#saveBtn').val("edit");
            $('[class^="invalid-feedback-"]').html('');  // clearing validation
            $('#inputModal').modal('show');
        });

        $(inputFormId).on('submit', function (event) {
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
                },
                complete: function () {
                    let l = $( '.ladda-button-submit' ).ladda();
                    l.ladda( 'stop' );
                    $('#saveBtn'). prop('disabled', false);
                }
            }); 

            setTimeout(location.reload.bind(location), 2000);
        });

        $('.deleteBtn').click(function () {
            rowId = $(this).val();
            $('#deleteModal').modal('show');
            $('#delete-form').attr('action', actionUrl + rowId);
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

            setTimeout(location.reload.bind(location), 2000);
        });
    });
</script>
@endpush