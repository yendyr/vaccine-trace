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
        var tableAttd = $('#attendance-table').DataTable({
            processing: true,
            serverSide: false,
            scrollX: true,
            language: {
                emptyTable: "No data existed for Attendance",
            },
            height: 180,
            ajax: {
                url: "/hr/attendance",
                type: "GET",
                dataType: "json",
            },
            columns: [
                { data: 'empid', name: 'empid' },
                { data: 'attdtype', name: 'attdtype', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'attddate', name: 'attddate', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'attdtime', name: 'attdtime', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'deviceid', name: 'deviceid', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'inputon', name: 'inputon', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'status', name: 'status' },
            ]
        });

        $(document).ready(function () {
            $('.select2_attdtype').select2({
                placeholder: 'choose Attendance type',
                ajax: {
                    url: "{{route('hr.attendance.select2.type')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#attendanceModal')
            });

            $('#attendanceForm').find('.select2_empidAttendance').select2({
                placeholder: 'choose Emp ID',
                ajax: {
                    url: "{{route('hr.employee.select2.empid')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#attendanceModal')
            });

            $('#create-attendance').click(function () {
                $('#saveBtn').val("create-attendance");
                $('#attendanceForm').trigger("reset");
                $("#attendanceModal").find('#modalTitle').html("Add new Attendance data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback

                $('#fempidAttendance').val(null).trigger('change');
                $('#fempidAttendance').attr('disabled', false);
                $('#fattdtype').val(null).trigger('change');
                $('#fattdtype').attr('disabled', false);
                $('#attendanceModal').modal('show');
                $('#attendanceForm').attr('action', '/hr/attendance');
            });

            $('#attendance-table').on('click', '.editBtn', function () {
                $('#attendanceForm').trigger("reset");
                $('#attendanceModal').find('#modalTitle').html("Update Attendance data");
                let tr = $(this).closest('tr');
                let data = $('#attendance-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#attendanceForm');

                $('#attendanceModal').modal('show');
            });

            $('#attendanceForm').on('submit', function (event) {
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
                        $("#attendanceForm").find('#saveBtn').prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            $("#ibox-attendance").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $("#ibox-attendance").find('#form_result').html(data.success);
                        }
                        $('#attendanceModal').modal('hide');
                        $('#attendance-table').DataTable().ajax.reload();
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
                        $("#attendanceForm").find('#saveBtn').prop('disabled', false);
                    }
                });
            });
        });
    </script>

@endpush
