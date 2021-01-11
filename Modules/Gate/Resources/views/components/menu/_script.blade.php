@push('footer-scripts')
<script src="{{URL::asset('theme/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{URL::asset('theme/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

<script>
    $(document).ready(function() {
        var menuId;

        var table = $('#menu-table').DataTable({
            dom: '<"top"<"row"<"col-md-6"B><"col-md-6"f>>>t<"bottom"<"row"<"col-md-2"l><"col-md-4"i><"col-md-6"p>>>',
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('gate.menu.index')}}",
            },
            buttons: [
                {
                    attr: { id: 'createMenu' },
                    text: '<i class="fa fa-plus-circle"></i>&nbsp;<strong>Menu</strong>',
                    className: 'btn btn-primary'
                }
            ],
            columns: [
                // { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                {
                    title: 'Name',
                    data: 'menu_text',
                    name: 'menu_text'
                },
                {
                    title: 'Group',
                    data: 'group',
                    name: 'group'
                },
                {
                    title: 'Icon',
                    data: 'icon',
                    name: 'icon'
                },
                {
                    title: 'Class',
                    data: 'menu_class',
                    name: 'menu_class'
                },
                {
                    title: 'Actives',
                    data: 'actives',
                    name: 'menu_actives'
                },
                {
                    title: 'Parent',
                    data: 'parent',
                    name: 'parent'
                },
                {
                    title: 'Link',
                    data: 'menu_link',
                    name: 'menu_link'
                },
                {
                    title: 'Route',
                    data: 'menu_route',
                    name: 'menu_route'
                },
                {
                    title: 'Status',
                    data: 'status',
                    name: 'status'
                },
                {
                    title: 'Action',
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
            ]
        });

        $('.select2_menu').select2({
            allowClear: true,
            theme: 'bootstrap4',
            placeholder: 'Choose a menu',
            ajax: {
                delay: 250,
                url: "{{route('gate.menu.select2.all')}}",
                data: function (params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }
                    return query;
                },
                dataType: 'json',
            },
            dropdownParent: $('#menuModal')
        });

        $('.select2_menu_actives').select2({
            tags: true,
            allowClear: true,
            theme: 'bootstrap4',
            tokenSeparators: [','],
            placeholder: 'Write the classess',
            dropdownParent: $('#menuModal')
        });

        $('#createMenu').click(function() {
            $('select').empty();
            $('#saveBtn').val("create-menu");
            $('#menuForm').trigger("reset");
            $('#modalTitle').html("Add New Menu");
            $('[class^="invalid-feedback-"]').html(''); //delete html all alert with pre-string invalid-feedback
            $('#menuModal').modal('show');
            $('#menuForm').attr('action', '/gate/menu');
            $("input[value='patch']").remove();
        });

        table.on('click', '.editBtn', function() {
            $('#menuForm').trigger("reset");
            $('#modalTitle').html("Edit Menu");
            menuId = $(this).val();
            let tr = $(this).closest('tr');
            let data = table.row(tr).data();

            $('<input>').attr({
                type: 'hidden',
                name: '_method',
                value: 'patch'
            }).prependTo('#menuForm');

            $.each(data, function(index, value) {
                if ($('#' + index).length > 0) {
                    if($('#' + index).is('input')){
                        $('#' + index).val(value);
                    }else{
                        if ( $('#' + index).is('select') ) {
                            if ($('#' + index).hasClass("select2-hidden-accessible")) {
                                // select2
                                if (isJson(value)) {
                                    // for multiplle value
                                    let values = JSON.parse(value);
                                    if (value !== null && values.length > 0) {
                                        $('#' + index).empty();
                                        $.each(values, function(key, value) {
                                            let data = { id: value, text: value };
                                            if ($('#' + index).find("option[value='" + data.id + "']").length) {
                                                $('#' + index).val(data.id).trigger('change');
                                            } else {
                                                // Create a DOM Option and pre-select by default
                                                var newOption = new Option(data.text, data.id, true, true);
                                                // Append it to the select
                                                $('#' + index).append(newOption).trigger('change');
                                            }
                                        });

                                    }
                                }
                            }else{
                                $('#' + index).val(value);
                            }
                        }
                    }
                }
            });

            $("#parent_id").val(null).trigger('change');
            if( data.parent_id !== null && data.parent !== null) {
                $('#parent_id').append('<option value="' + data.parent_id + '" selected>' + data.parent + '</option>');
            }

            $('#saveBtn').val("edit-menu");
            $('#menuForm').attr('action', '/gate/menu/' + data.id);

            $('[class^="invalid-feedback-"]').html(''); //delete html all alert with pre-string invalid-feedback
            $('#menuModal').modal('show');
        });

        $('#menuForm').on('submit', function(event) {
            event.preventDefault();
            let url_action = $(this).attr('action');
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content")
                },
                url: url_action,
                method: "POST",
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    let laddaBtn = $('.ladda-button-submit').ladda();
                    laddaBtn.ladda('start');
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
                    if (data.status) {
                        $('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                        $('#form_result').html(data.status);
                    }
                    $('#menuModal').modal('hide');
                    $('#menu-table').DataTable().ajax.reload();
                },
                complete: function() {
                    let laddaBtn = $('.ladda-button-submit').ladda();
                    laddaBtn.ladda('stop');
                    $('#saveBtn').prop('disabled', false);
                }
            });
        });

        table.on('click', '.deleteBtn', function() {
            menuId = $(this).val();
            $('#deleteModal').modal('show');
            $('#delete-form').attr('action', "/gate/menu/" + menuId);
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
                type: "DELETE", //bisa method
                beforeSend: function() {
                    $('#delete-button').text('Deleting...');
                    $('#delete-button').prop('disabled', true);
                },
                error: function(data) {
                    if (data.error) {
                        $('#form_result').attr('class', 'alert alert-danger fade show font-weight-bold');
                        $('#form_result').html(data.error);
                    }
                },
                success: function(data) {
                    if (data.status) {
                        $('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                        $('#form_result').html(data.status);
                    }
                },
                complete: function(data) {
                    $('#delete-button').text('Delete');
                    $('#deleteModal').modal('hide');
                    $('#delete-button').prop('disabled', false);
                    $('#menu-table').DataTable().ajax.reload();
                }
            });
        });
    });
</script>
@endpush