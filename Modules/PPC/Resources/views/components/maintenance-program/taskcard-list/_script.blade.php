@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = '/ppc/maintenance-program-detail';
    var tableId = '#taskcard-table';
    var saveButtonId = '#saveButtonDetail';
    var inputFormId = '#inputFormDetail';
    var editButtonClass = '.editButtonDetail';
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //



    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "/ppc/taskcard/?aircraft_type_id=" + "{{ $MaintenanceProgram->aircraft_type->id }}",
        },
        columns: [
            { data: 'mpd_number', 
                    "render": function ( data, type, row, meta ) {
                    return '<a target="_blank" href="/ppc/taskcard/' + row.id + '">' + row.mpd_number + '</a>'; }},
            { data: 'title', name: 'Title' },
            { data: 'group_structure', name: 'Group' },
            { data: 'taskcard_type.name', name: 'Task Type' },
            { data: 'instruction_count', name: 'Instruction/Task Total' },
            { data: 'manhours_total', name: 'Manhours Total' },
            { data: 'aircraft_type_name', name: 'Aircraft Type' },
            { data: 'skills', name: 'Skill' },
            { data: 'created_at', name: 'Created At' },
            { data: 'action', name: 'Action', orderable: false },
        ]
    });




    $('.aircraft_type_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose A/C Type',
        allowClear: true,
        ajax: {
            url: "/ppc/maintenance-program-detail/dual_list_box",
            dataType: 'json',
        },
    });

    


    



    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    $(editButtonClass).click(function (e) {
        $(modalTitleId).html("Edit Aircraft Configuration");
        
        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo(inputFormId);

        var id = $(this).data('id');
        $(inputFormId).attr('action', actionUrl + '/' + id);

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

                setTimeout(location.reload.bind(location), 2000);
            },
            complete: function () {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'stop' );
                $(saveButtonId). prop('disabled', false);
            }
        }); 
    });
    // ----------------- END "SUBMIT FORM" BUTTON SCRIPT ------------- //
});
</script>
@endpush