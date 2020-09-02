@push('header-scripts')
    <style>
        .select2-container.select2-container--default.select2-container--open {
            z-index: 9999999 !important;
        }
        .select2{
            width: 100% !important;
        }

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" integrity="sha512-rxThY3LYIfYsVCWPCW9dB0k+e3RZB39f23ylUYTEuZMDrN/vRqLdaCBo/FbvVT6uC2r0ObfPzotsfKF9Qc5W5g==" crossorigin="anonymous" />
@endpush

@push('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>

    <script>
        var tableEducation = $('#education-table').DataTable({
            processing: true,
            serverSide: false,
            scrollX: true,
            language: {
                emptyTable: "No data existed",
            },
            ajax: {
                url: "/hr/education",
                type: "GET",
                dataType: "json",
            },
            columns: [
                { data: 'empid', name: 'empid' },
                { data: 'instname', name: 'instname', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'startperiod', name: 'startperiod', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'finishperiod', name: 'finishperiod', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'city', name: 'city', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'state', name: 'state', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'country', name: 'country', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'major', name: 'major', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'minor', name: 'minor', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'edulvl', name: 'edulvl', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'remark', name: 'remark', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false },
            ]
        });

        $(document).ready(function () {
            $('#educationForm').find('.select2_empidEducation').select2({
                placeholder: 'choose Emp ID',
                ajax: {
                    url: "{{route('hr.employee.select2.empid')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#educationModal')
            });

            $('.select2_edulvlEducation').select2({
                placeholder: 'choose edu level',
                ajax: {
                    url: "{{route('hr.education.select2.edulvl')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#educationModal')
            });

            $("#ffinishperiod, #fstartperiod").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            });

            $('#create-education').click(function () {
                $('#saveBtn').val("create-education");
                $('#educationForm').trigger("reset");
                $("#educationModal").find('#modalTitle').html("Add new Education data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback

                $('#educationModal').modal('show');
                $("input[value='patch']").remove();
                $('#fempidEducation').val(null).trigger('change');
                $('#fempidEducation').attr('disabled', false);
                $('#fedulvlEducation').val(null).trigger('change');
                $('#educationForm').attr('action', '/hr/education');
            });

            $('#education-table').on('click', '.editBtn', function () {
                $('#educationForm').trigger("reset");
                $('#educationModal').find('#modalTitle').html("Update Education data");
                let tr = $(this).closest('tr');
                let data = $('#education-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#educationForm');

                $('#fempidEducation').attr('disabled', true);
                $('#fempidEducation').append('<option value="' + data.empid + '" selected>' + data.empid + '</option>');

                $('#finstname').val(data.instname);
                $('#fstartperiod').val(data.startperiod);
                $('#ffinishperiod').val(data.finishperiod);
                $('#fcity').val(data.city);
                $('#fstate').val(data.state);
                $('#fcountry').val(data.country);
                $('#fmajor01').val(data.major01);
                $('#fmajor02').val(data.major02);
                $('#fminor01').val(data.minor01);
                $('#fminor02').val(data.minor02);
                $("#educationForm").find('#fremark').val(data.remark);
                $('#fedulvlEducation').append('<option value="' + data.edulvl + '" selected>' + data.edulvl + '</option>');

                $("#educationForm").find('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $("#educationForm").find('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $("#educationForm").find('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-education");
                $('#educationForm').attr('action', '/hr/education/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#educationModal').modal('show');
            });

            $('#educationForm').on('submit', function (event) {
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
                        $("#educationForm").find('#saveBtn').prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            $("#ibox-education").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $("#ibox-education").find('#form_result').html(data.success);
                        }
                        $('#educationModal').modal('hide');
                        tableEducation.ajax.reload();
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
                        $("#educationForm").find('#saveBtn').prop('disabled', false);
                    }
                });
            });
        });

    </script>
@endpush
