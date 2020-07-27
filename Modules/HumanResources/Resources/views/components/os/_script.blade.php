@push('header-scripts')
    <!-- Syncfusion Essential JS 2 Styles -->
    <link rel="stylesheet" href="https://cdn.syncfusion.com/ej2/material.css">
    <link href="//cdn.syncfusion.com/ej2/ej2-splitbuttons/styles/material.css" rel="stylesheet">
    <script src="https://cdn.syncfusion.com/ej2/dist/ej2.min.js" type="text/javascript"></script>

@endpush

@push('footer-scripts')
    <script>
        {{--$(document).ready(function () {--}}
        {{--    var ostId;--}}

        {{--    var table = $('#ost-table').DataTable({--}}
        {{--        processing: true,--}}
        {{--        serverSide: true,--}}
        {{--        ajax: {--}}
        {{--            url: "{{ route('hr.ost.index')}}",--}}
        {{--        },--}}
        {{--        columns: [--}}
        {{--            { data: 'titlecode', name: 'titlecode' },--}}
        {{--            { data: 'jobtitle', name: 'jobtitle' },--}}
        {{--            { data: 'rptorg.name', name: 'rptorg', defaultContent: "<p class='text-muted'>none</p>" },--}}
        {{--            { data: 'rpttitle.title', name: 'rpttitle', defaultContent: "<p class='text-muted'>none</p>" },--}}
        {{--            { data: 'status', name: 'status' },--}}
        {{--            { data: 'action', name: 'action', orderable: false },--}}
        {{--            { data: 'orgcode', name: 'orgcode', visible: false },--}}
        {{--        ]--}}
        {{--    });--}}

        {{--    $('.select2_orgparent').select2({--}}
        {{--        placeholder: 'choose here',--}}
        {{--        ajax: {--}}
        {{--            url: "{{route('hr.os.select2.orgcode')}}",--}}
        {{--            dataType: 'json',--}}
        {{--        },--}}
        {{--        dropdownParent: $('#osForm')--}}
        {{--    });--}}
        {{--    $('#createOST').click(function () {--}}
        {{--        $('#saveBtn').val("create-os");--}}
        {{--        $('#ostForm').trigger("reset");--}}
        {{--        $('#modalTitle').html("Add New Organization Structure data");--}}
        {{--        $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback--}}
        {{--        $('#ostModal').modal('show');--}}
        {{--        $('#ostForm').attr('action', '/hr/ost');--}}
        {{--        $("input[value='patch']").remove();--}}
        {{--    });--}}

        {{--    table.on('click', '.editBtn', function () {--}}
        {{--        $('#ostForm').trigger("reset");--}}
        {{--        $('#modalTitle').html("Update Organization Structure data");--}}
        {{--        ostId= $(this).val();--}}
        {{--        let tr = $(this).closest('tr');--}}
        {{--        let data = table.row(tr).data();--}}

        {{--        $('<input>').attr({--}}
        {{--            type: 'hidden',--}}
        {{--            name: '_method',--}}
        {{--            value: 'patch'--}}
        {{--        }).prependTo('#ostForm');--}}

        {{--        $('#forgcode').empty();--}}
        {{--        $('#forgcode').append('<option value="' + data.orgcode.code + '" selected>' + data.orgcode.code + ' - ' + data.orgcode.name + '</option>');--}}

        {{--        $('#ftitlecode').find('option').removeAttr('selected');--}}
        {{--        if (data.titlecode == 1){--}}
        {{--            $('#ftitlecode').find('option[value="1"]').attr('selected', '');--}}
        {{--        }else if (data.titlecode == 2){--}}
        {{--            $('#ftitlecode').find('option[value="2"]').attr('selected', '');--}}
        {{--        }else if (data.titlecode == 3){--}}
        {{--            $('#ftitlecode').find('option[value="3"]').attr('selected', '');--}}
        {{--        }else if (data.titlecode == 4){--}}
        {{--            $('#ftitlecode').find('option[value="4"]').attr('selected', '');--}}
        {{--        }else if (data.titlecode == 5){--}}
        {{--            $('#ftitlecode').find('option[value="5"]').attr('selected', '');--}}
        {{--        }--}}

        {{--        $('#fjobtitle').val(data.jobtitle);--}}

        {{--        if (data.rptorg == null){--}}
        {{--            $('#frptorg').append('<option value="' + 0 + '" selected>none</option>');--}}
        {{--        } else{--}}
        {{--            $('#frptorg').append('<option value="' + data.rptorg.code + '" selected>' + data.rptorg.code + ' - ' + data.rptorg.name + '</option>');--}}
        {{--        }--}}

        {{--        if (data.rpttitle == null){--}}
        {{--            $('#frpttitle').append('<option value="' + 0 + '" selected>none</option>');--}}
        {{--        } else{--}}
        {{--            $('#frpttitle').append('<option value="' + data.rpttitle.code + '" selected>' + data.rpttitle.title + '</option>');--}}
        {{--        }--}}

        {{--        $('#fstatus').find('option').removeAttr('selected');--}}
        {{--        if (data.status == '<p class="text-success">Active</p>'){--}}
        {{--            $('#fstatus').find('option[value="1"]').attr('selected', '');--}}
        {{--        }else{--}}
        {{--            $('#fstatus').find('option[value="0"]').attr('selected', '');--}}
        {{--        }--}}

        {{--        $('#saveBtn').val("edit-ost");--}}
        {{--        $('#ostForm').attr('action', '/hr/ost/' + data.id);--}}

        {{--        $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback--}}
        {{--        $('#ostModal').modal('show');--}}
        {{--    });--}}

        {{--    $('#ostForm').on('submit', function (event) {--}}
        {{--        event.preventDefault();--}}
        {{--        let url_action = $(this).attr('action');--}}
        {{--        $.ajax({--}}
        {{--            headers: {--}}
        {{--                "X-CSRF-TOKEN": $(--}}
        {{--                    'meta[name="csrf-token"]'--}}
        {{--                ).attr("content")--}}
        {{--            },--}}
        {{--            url: url_action,--}}
        {{--            method: "POST",--}}
        {{--            data: $(this).serialize(),--}}
        {{--            dataType: 'json',--}}
        {{--            beforeSend:function(){--}}
        {{--                $('#saveBtn').html('<strong>Saving...</strong>');--}}
        {{--                $('#saveBtn').prop('disabled', true);--}}
        {{--            },--}}
        {{--            success:function(data){--}}
        {{--                if (data.success) {--}}
        {{--                    $('#form_result').attr('class', 'alert alert-success alert-dismissable fade show font-weight-bold');--}}
        {{--                    $('#form_result').html(data.success +--}}
        {{--                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +--}}
        {{--                        '    <span aria-hidden="true">&times;</span>\n' +--}}
        {{--                        '  </button>');--}}
        {{--                }--}}
        {{--                $('#ostModal').modal('hide');--}}
        {{--                $('#ost-table').DataTable().ajax.reload();--}}
        {{--            },--}}
        {{--            error:function(data){--}}
        {{--                let errors = data.responseJSON.errors;--}}
        {{--                if (errors) {--}}
        {{--                    $.each(errors, function (index, value) {--}}
        {{--                        $('div.invalid-feedback-'+index).html(value);--}}
        {{--                    })--}}
        {{--                }--}}
        {{--            },--}}
        {{--            complete:function(){--}}
        {{--                $('#saveBtn').prop('disabled', false);--}}
        {{--                console.log($('#saveBtn').attr('value'));--}}
        {{--                $('#saveBtn').html('<strong>Save Changes</strong>');--}}
        {{--            }--}}
        {{--        });--}}
        {{--    });--}}
        {{--});--}}

    </script>
@endpush
