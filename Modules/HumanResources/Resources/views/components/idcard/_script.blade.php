@push('header-scripts')
    <style>
        .select2-container.select2-container--default.select2-container--open {
            z-index: 9999999 !important;
        }
        .select2{
            width: 100% !important;
        }
    </style>
@endpush
@push('footer-scripts')
    <script>
        var tableIdcard = $('#idcard-table').DataTable({
            processing: true,
            serverSide: false,
            language: {
                emptyTable: "No data existed",
            },
            ajax: {
                url: "/hr/id-card",
                type: "GET",
                dataType: "json",
            },
            columns: [
                { data: 'empid', name: 'empid' },
                { data: 'idcardtype.content', name: 'idcardtype.content', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'idcardno', name: 'idcardno', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'idcarddate', name: 'idcarddate', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'idcardexpdate', name: 'idcardexpdate', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false },
            ]
        });

        $(document).ready(function () {
            $('#idcardForm').find('.select2_empidIdcard').select2({
                placeholder: 'choose empid',
                ajax: {
                    url: "{{route('hr.employee.select2.empid')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#idcardModal')
            });

            $('#create-idcard').click(function () {
                $('#saveBtn').val("create-idcard");
                $('#idcardForm').trigger("reset");
                $("#idcardModal").find('#modalTitle').html("Add new ID Card data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback

                $('#idcardModal').modal('show');
                $("input[value='patch']").remove();
                $('#fempidIdcard').val(null).trigger('change');
                $('#fempidIdcard').attr('disabled', false);
                $('#idcardForm').attr('action', '/hr/id-card');
            });

            $('#idcard-table').on('click', '.editBtn', function () {
                $('#idcardForm').trigger("reset");
                $('#idcardModal').find('#modalTitle').html("Update Id Card data");
                let tr = $(this).closest('tr');
                let data = $('#idcard-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#idcardForm');

                $('#fempidIdcard').attr('disabled', true);
                $('#fempidIdcard').append('<option value="' + data.empid + '" selected>' + data.empid + '</option>');

                $('#fidcardtype').find('option').removeAttr('selected');
                $('#fidcardtype').find('option[value="' + data.idcardtype.value + '"]').attr('selected', '');

                $('#fidcardno').val(data.idcardno);
                $('#fidcarddate').val(data.idcarddate);
                $('#fidcardexpdate').val(data.idcardexpdate);

                $("#idcardForm").find('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $("#idcardForm").find('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $("#idcardForm").find('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-idcard");
                $('#idcardForm').attr('action', '/hr/id-card/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#idcardModal').modal('show');
            });

            $('#idcardForm').on('submit', function (event) {
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
                    beforeSend:function(){
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'start' );
                        $('[class^="invalid-feedback-"]').html('');
                        $("#idcardForm").find('#saveBtn').prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            $("#ibox-idcard").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $("#ibox-idcard").find('#form_result').html(data.success);
                        }
                        $('#idcardModal').modal('hide');
                        tableIdcard.ajax.reload();
                    },
                    error:function(data){
                        let errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function (index, value) {
                                if (value[0] == "The idcardno has already been taken."){
                                    value[0] = 'This idcard no. with choosen empid & idcard type has already been taken';
                                }
                                $('div.invalid-feedback-'+index).html(value);
                            })
                        }
                    },
                    complete:function(){
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'stop' );
                        $("#idcardForm").find('#saveBtn').prop('disabled', false);
                    }
                });
            });
        });

    </script>
@endpush
