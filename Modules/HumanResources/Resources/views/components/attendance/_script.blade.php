@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

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
        $(document).ready(function () {
            var actionUrl = '/hr/attendance';
            var tableId = '#attendance-table';
            var inputFormId = '#attendanceForm';

            var tableAttd = $('#attendance-table').DataTable({
                processing: true,
                serverSide: false,
                searchDelay: 1500,
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
                    { data: 'empid', defaultContent: '-' },
                    { data: 'attdtype.content', defaultContent: '-' },
                    { data: 'attddate', defaultContent: '-' },
                    { data: 'attdtime', defaultContent: '-' },
                    { data: 'deviceid', defaultContent: '-' },
                    { data: 'inputon', defaultContent: '-' },
                    { data: 'status', defaultContent: '-' },
                    { data: 'action', orderable: false },
                ]
            });
            var tableAttdValidate = $('#validation-in-table').DataTable({
                processing: true,
                serverSide: false,
                scrollX: true,
                language: {
                    emptyTable: "No data existed for Attendance",
                },
                height: 180,
                ajax: {
                    url: "/hr/attendance/datatable?param=in",
                    type: "GET",
                    dataType: "json",
                },
                columns: [
                    { data: 'empid', name: 'empid' },
                    { data: 'attdtype.content', name: 'attdtype.content', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'attddate', name: 'attddate', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'attdtime', name: 'attdtime', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'deviceid', name: 'deviceid', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'inputon', name: 'inputon', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'status', name: 'status' },
                ]
            });
            var tableAttdValidate = $('#validation-out-table').DataTable({
                processing: true,
                serverSide: false,
                scrollX: true,
                language: {
                    emptyTable: "No data existed for Attendance",
                },
                height: 180,
                ajax: {
                    url: "/hr/attendance/datatable?param=out",
                    type: "GET",
                    dataType: "json",
                },
                columns: [
                    { data: 'empid', name: 'empid' },
                    { data: 'attdtype.content', name: 'attdtype.content', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'attddate', name: 'attddate', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'attdtime', name: 'attdtime', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'deviceid', name: 'deviceid', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'inputon', name: 'inputon', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'status', name: 'status' },
                ]
            });

            $('.select2_attdtype').select2({
                theme: 'bootstrap4',
                placeholder: 'choose Attendance type',
                ajax: {
                    url: "{{route('hr.attendance.select2.type')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#attendanceModal')
            });

            $('#attendanceForm').find('.select2_empidAttendance').select2({
                theme: 'bootstrap4',
                placeholder: 'choose Emp ID',
                ajax: {
                    url: "{{route('hr.employee.select2.empid')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#attendanceModal')
            });

            $('#validate-attendance').click(function () {
                swal.fire({
                    title: "Are you sure?",
                    text: "If you sure to validate all attendance data, you won't be able to restore the validated attendance data",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#1a9905",
                    confirmButtonText: "Yes, i'm sure!"
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content")
                            },
                            url: '/hr/attendance/validate',
                            type: "POST",
                            error: function(data){
                                if (data.error) {
                                    swal.fire({
                                        title: 'Failed when validating data',
                                        text: data.error,
                                        icon: 'error',
                                        closeOnConfirm: false
                                    })
                                }
                            },
                            success:function(data){
                                if (data.success) {
                                    swal.fire({
                                        title: 'Successfully validated',
                                        text: data.success,
                                        icon: 'success',
                                        closeOnEscape: true
                                    })
                                }else if(data.error){
                                    swal.fire({
                                        title: 'Failed when validating data',
                                        text: data.error,
                                        icon: 'warning',
                                        closeOnEscape: true
                                    })
                                }
                                $('#validation-in-table').DataTable().ajax.reload();
                                $('#validation-out-table').DataTable().ajax.reload();
                            }
                        });
                    } else {
                        swal.fire("Cancelled", "no data changed", "info");
                    }
                })
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
                showCreateModal ('Add New Attendance', inputFormId, actionUrl, '#attendanceModal');
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

                $('#fempidAttendance').attr('disabled', true);
                $('#fempidAttendance').append('<option value="' + data.empid + '" selected>' + data.empid + '</option>');

                $('#fattddate').val(data.attddate);
                $('#fattdtime').val(data.attdtime);
                $('#fattdtype').append('<option value="' + data.attdtype.value + '" selected>' + data.attdtype.content + '</option>');

                $("#educationForm").find('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $("#educationForm").find('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $("#educationForm").find('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-education");
                $('#attendanceForm').attr('action', '/hr/attendance/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
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
                        if(data.warning){
                            $("#ibox-attendance").find('#form_result').attr('class', 'alert alert-warning fade show font-weight-bold');
                            $("#ibox-attendance").find('#form_result').html(data.warning);
                        }
                        if(data.error){
                            $("#ibox-attendance").find('#form_result').attr('class', 'alert alert-danger fade show font-weight-bold');
                            $("#ibox-attendance").find('#form_result').html(data.error);
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

            $('#attendance-table').on('click', '.deleteBtn', function () {
                let tr = $(this).closest('tr');
                let data = $('#attendance-table').DataTable().row(tr).data();
                $('#deleteModal').modal('show');
                $('#delete-form').attr('action', "/hr/attendance/"+ data.id);
            });
            deleteButtonProcess (tableAttd, tableId, actionUrl);

        });
    </script>

@endpush
