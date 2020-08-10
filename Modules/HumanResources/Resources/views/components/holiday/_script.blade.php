@push('footer-scripts')
    <script>

        var table = $('#holiday-table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                emptyTable: "No data existed",
            },
            selected: true,
            ajax: {
                url: "/hr/holiday",
                type: "GET",
                dataType: "json",
            },
            columns: [
                { data: 'holidaycode.name', name: 'holidaycode.name' },
                { data: 'holidayyear', name: 'holidayyear' },
                { data: 'holidaydate.name', name: 'holidaydate.name' },
                { data: 'remark', name: 'remark', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false },
            ]
        });

        $(document).ready(function () {
            $('.select2_holidaycode').select2({
                placeholder: 'choose code',
                ajax: {
                    url: "{{route('hr.holiday.select2.code')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#holidayModal')
            });

            $('#create-holiday').click(function () {
                $('#saveBtn').val("create-workgroup");
                $('#holidayForm').trigger("reset");
                $("#holidayModal").find('#modalTitle').html("Add new Holiday data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $(".select2_holidaycode").val(null).trigger('change');

                $('#holidayModal').modal('show');
                $("input[value='patch']").remove();
                $('#holidayForm').attr('action', '/hr/holiday');
            });

            $('#holiday-table').on('click', '.editBtn', function () {
                $('#holidayForm').trigger("reset");
                $('#holidayModal').find('#modalTitle').html("Update Holiday data");
                let tr = $(this).closest('tr');
                let data = $('#holiday-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#holidayForm');

                $('#fholidayyear').val(data.holidayyear);
                $('#fholidaycode').find('option').removeAttr('selected');
                $('#fholidaycode').append('<option value="' + data.holidaycode.value + '" selected>' +
                    data.holidaycode.name + '</option>'
                );
                $('#fholidaydate').val(data.holidaydate.value);
                $('#fremark').val(data.remark);

                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-workgroup");
                $('#holidayForm').attr('action', '/hr/holiday/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#holidayModal').modal('show');
            });

            $('#holidayForm').on('submit', function (event) {
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
                        $("#holidayForm").find('#saveBtn').prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            $("#ibox-holiday").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $("#ibox-holiday").find('#form_result').html(data.success);
                        }
                        $('#holidayModal').modal('hide');
                        table.ajax.reload();
                    },
                    error:function(data){
                        let errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function (index, value) {
                                if (value[0] == "The holidaycode has already been taken."){
                                    value[0] = 'This holiday with choosen date & year has already been taken';
                                }
                                if (value[0] == "The selected holidayyear is invalid."){
                                    value[0] = 'This year must be same with year at Date';
                                }
                                $('div.invalid-feedback-'+index).html(value);
                            })
                        }
                    },
                    complete:function(){
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'stop' );
                        $("#holidayForm").find('#saveBtn').prop('disabled', false);
                    }
                });
            });

            $('#sundayForm').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $(
                            'meta[name="csrf-token"]'
                        ).attr("content")
                    },
                    url: '/hr/holiday/sundays',
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend:function(){
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'start' );
                        $('[class^="invalid-feedback-"]').html('');
                        $("#sundayForm").find('#saveBtn').prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            $("#ibox-holiday").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $("#ibox-holiday").find('#form_result').html(data.success);
                        }
                        $('#sundayModal').modal('hide');
                        table.ajax.reload();
                    },
                    error:function(data){
                        let errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function (index, value) {
                                $('div.invalid-feedback-'+index).html(value);
                            })
                        }
                    },
                    complete:function(){
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'stop' );
                        $('#sundayForm').trigger("reset");
                        $("#sundayForm").find('#saveBtn').prop('disabled', false);
                    }
                });
            });

        });

    </script>
@endpush
