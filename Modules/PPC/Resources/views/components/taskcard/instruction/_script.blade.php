@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = '/ppc/taskcard-detail-instruction';
    var createNewButtonId = '#createNewButtonInstruction';
    var inputModalId = '#inputModalInstruction';
    var modalTitleId = '#modalTitleInstruction';
    var saveButtonId = '#saveButtonInstruction';
    var inputFormId = '#inputFormInstruction';
    var editButtonClass = '.editButtonInstruction';
    var deleteButtonClass = '.deleteButtonInstruction';
    var deleteModalId = '#deleteModalInstruction';
    var deleteFormId = '#deleteFormInstruction';
    var deleteModalButtonId = '#deleteModalButtonInstruction';
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //




    $('.taskcard_workarea_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Work Area',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.taskcard-workarea.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });

    $('.skill_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Skill',
        allowClear: true,
        ajax: {
            url: "{{ route('qualityassurance.skill.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });

    $('.engineering_level_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Level',
        allowClear: true,
        ajax: {
            url: "{{ route('qualityassurance.engineering-level.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });

    $('.task_release_level_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Level',
        allowClear: true,
        ajax: {
            url: "{{ route('qualityassurance.task-release-level.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });




    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $(createNewButtonId).click(function () {            
        showCreateModalDynamic (inputModalId, modalTitleId, 'Create New Task/Instruction', saveButtonId, inputFormId, actionUrl);
        clearForm();
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //




    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    $(editButtonClass).click(function (e) {
        clearForm();
        $(modalTitleId).html("Edit Task/Instruction");
        $(inputFormId).trigger("reset");
        
        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo(inputFormId);

        var id = $(this).data('id');
        $.get(actionUrl + '/' + id, function (data) {
            $('.id').val(id);
            $('#sequence').val(data.sequence);
            $('#instruction_code').val(data.instruction_code);
            $('#manhours_estimation').val(data.manhours_estimation);
            $('#performance_factor').val(data.performance_factor);
            $('#manpower_quantity').val(data.manpower_quantity);
            $("#instruction").summernote("code", data.instruction);
            
            $(".taskcard_workarea_id").val(null).trigger('change');
            if (data.taskcard_workarea != null) {
                $('.taskcard_workarea_id').append('<option value="' + data.taskcard_workarea_id + '" selected>' + data.taskcard_workarea.name + '</option>');
            }

            $(".engineering_level_id").val(null).trigger('change');
            if (data.engineering_level != null) {
                $('.engineering_level_id').append('<option value="' + data.engineering_level_id + '" selected>' + data.engineering_level.name + '</option>');
            }

            $(".task_release_level_id").val(null).trigger('change');
            if (data.task_release_level != null) {
                $('.task_release_level_id').append('<option value="' + data.task_release_level_id + '" selected>' + data.task_release_level.name + '</option>');
            }

            if (data.skills != null) {
                $.each(data.skills, function(index, value) {
                    var option = new Option(data.skills[index].name, data.skills[index].id, true, true);
                    $("#skill_id").append(option);
                });
            }

            $(inputFormId).attr('action', actionUrl + '/' + id);
        });

        $(saveButtonId).val("edit");
        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $(inputModalId).modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //





    // ----------------- "SUBMIT FORM" BUTTON SCRIPT ------------- //
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
                $(saveButtonId).prop('disabled', true);
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
            },
            complete: function () {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'stop' );
                $(saveButtonId). prop('disabled', false);
            }
        }); 

        setTimeout(location.reload.bind(location), 2000);
    });
    // ----------------- END "SUBMIT FORM" BUTTON SCRIPT ------------- //




    // ----------------- "DELETE" BUTTON  SCRIPT ------------- //
    $(deleteButtonClass).click(function () {
        rowId = $(this).val();
        $(deleteModalId).modal('show');
        $(deleteFormId).attr('action', actionUrl + '/' + rowId);
    });

    $(deleteFormId).on('submit', function (e) {
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
                $(deleteModalButtonId).text('Deleting...');
                $(deleteModalButtonId).prop('disabled', true);
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
                $(deleteModalButtonId).text('Delete');
                $(deleteModalId).modal('hide');
                $(deleteModalButtonId).prop('disabled', false);
                $(targetTableId).DataTable().ajax.reload();
            }
        });

        setTimeout(location.reload.bind(location), 2000);
    });
    // ----------------- END "DELETE" BUTTON  SCRIPT ------------- //




    function clearForm()
    {
        $('#sequence').val('');
        $('#instruction_code').val('');
        $('#manhours_estimation').val('');
        $('#performance_factor').val('');
        $('#manpower_quantity').val('');
        $("#instruction").summernote("code", '');
        $(".taskcard_workarea_id").val(null).trigger('change');
        $(".engineering_level_id").val(null).trigger('change');
        $(".task_release_level_id").val(null).trigger('change');
        $('#skill_id').empty().trigger("change");
    }
});
</script>
@endpush