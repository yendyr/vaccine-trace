@push('header-scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" integrity="sha512-rxThY3LYIfYsVCWPCW9dB0k+e3RZB39f23ylUYTEuZMDrN/vRqLdaCBo/FbvVT6uC2r0ObfPzotsfKF9Qc5W5g==" crossorigin="anonymous" />
@endpush
@push('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>

    <script>
        var tableRequest = $('#request-table').DataTable({
            processing: false,
            serverSide: false,
            scrollX: true,
            language: {
                emptyTable: "No data existed for Request",
            },
            height: 180,
            ajax: {
                url: "/hr/request",
                type: "GET",
                dataType: "json",
            },
            columns: [
                { data: 'txnperiod', name: 'txnperiod' },
                { data: 'reqcode', name: 'reqcode' },
                { data: 'reqtype', name: 'reqtype' },
                { data: 'docno', name: 'docno' },
                { data: 'docdate', name: 'docdate' },
                { data: 'empid', name: 'empid' },
                { data: 'workdate', name: 'workdate' },
                { data: 'shiftno', name: 'shiftno' },
                { data: 'whtimestart', name: 'whtimestart', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'whdatestart', name: 'whdatestart', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'whtimefinish', name: 'whtimefinish', defaultContent: "<p class='text-muted'>none</p>"},
                { data: 'whdatefinish', name: 'whdatefinish', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'rstimestart', name: 'rstimestart', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'rsdatestart', name: 'rsdatestart', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'rstimefinish', name: 'rstimefinish', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'rsdatefinish', name: 'rsdatefinish', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'workstatus', name: 'workstatus', defaultContent: "<p class='text-muted'>none</p>"},
                { data: 'quotayear', name: 'quotayear', defaultContent: "<p class='text-muted'>none</p>"},
                { data: 'remark', name: 'remark', defaultContent: "<p class='text-muted'>none</p>"},
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false },
            ]
        });

        $(document).ready(function () {
            $('#data-daterange .input-daterange').datepicker({
                locale: {
                    format: 'dd-mm-yyyy'
                },
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            $('#requestForm').find('.select2_empidRequest').select2({
                theme: 'bootstrap4',
                placeholder: 'choose Emp ID',
                ajax: {
                    url: "{{route('hr.employee.select2.empid')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#requestModal')
            });

            $('#requestForm').find('#freqcode').select2({
                theme: 'bootstrap4',
                placeholder: 'choose Req code',
                ajax: {
                    url: "{{route('hr.request.select2.reqcode')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#requestModal')
            });

            $("#fquotayear").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            });

            $('#create-request').click(function () {
                $('#saveBtn').val("create-request");
                $('#requestForm').trigger("reset");
                $("#requestModal").find('#modalTitle').html("add new Request data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $("#fempidRequest").attr("disabled", false);
                $(".select2_empidWhour").val(null).trigger('change');

                $('#requestModal').modal('show');
                $("input[value='patch']").remove();
                $('#requestForm').attr('action', '/hr/request');
            });

            $('#request-table').on('click', '.editBtn', function () {
                $('#requestForm').trigger("reset");
                $('#requestModal').find('#modalTitle').html("Update Request data");
                let tr = $(this).closest('tr');
                let data = $('#request-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#requestForm');

                $('#fempidRequest').attr('disabled', true);
                $('#fempidRequest').append('<option value="' + data.empid + '" selected>' + data.empid + '</option>');

                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-request");
                $('#requestForm').attr('action', '/hr/request/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#requestModal').modal('show');
            });

            $('#requestForm').on('submit', function (event) {
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
                        $("#requestForm").find('#saveBtn').prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            $("#ibox-request").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $("#ibox-request").find('#form_result').html(data.success);
                        }
                        if(data.warning){
                            $("#ibox-request").find('#form_result').attr('class', 'alert alert-warning fade show font-weight-bold');
                            $("#ibox-request").find('#form_result').html(data.warning);
                        }
                        if(data.error){
                            $("#ibox-request").find('#form_result').attr('class', 'alert alert-danger fade show font-weight-bold');
                            $("#ibox-request").find('#form_result').html(data.error);
                        }
                        $('#requestModal').modal('hide');
                        $('#request-table').DataTable().ajax.reload();
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
                        $("#requestForm").find('#saveBtn').prop('disabled', false);
                    }
                });
            });
        });

    </script>
@endpush
