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
        var tablelquota = $('#leave-quota-table').DataTable({
            processing: false,
            serverSide: false,
            scrollX: true,
            language: {
                emptyTable: "No data existed for leave quota",
            },
            height: 180,
            ajax: {
                url: "/hr/leave-quota",
                type: "GET",
                dataType: "json",
            },
            columns: [
                { data: 'empid', name: 'empid' },
                { data: 'quotayear', name: 'quotayear' },
                { data: 'quotacode.content', name: 'quotacode.content' },
                { data: 'quotastartdate', name: 'quotastartdate', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'quotaexpdate', name: 'quotaexpdate', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'quotaallocdate', name: 'quotaallocdate', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'quotaqty', name: 'quotaqty' },
                { data: 'quotabai', name: 'quotabai' },
                { data: 'remark', name: 'remark', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false },
            ]
        });

        $("#fquotayear").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });

        $(document).ready(function () {

            $('#lquotaForm').find('.select2_empidLquota').select2({
                placeholder: 'choose Emp ID',
                ajax: {
                    url: "{{route('hr.employee.select2.empid')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#lquotaModal')
            });
            $('#lquotaForm').find('.select2_quotacode').select2({
                placeholder: 'choose Emp ID',
                ajax: {
                    url: "{{route('hr.lquota.select2.quotacode')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#lquotaModal')
            });

            $('#create-leave-quota').click(function () {
                $('#saveBtn').val("create-leave-hour");
                $('#whourForm').trigger("reset");
                $("#lquotaModal").find('#modalTitle').html("Add new Leave Quota data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $("#fempidLhour").attr("disabled", false);
                $(".select2_empidLquota").val(null).trigger('change');
                $(".select2_quotacode").val(null).trigger('change');
                $("#lquotaModal").find('#fquotabal').val(0);
                $("#lquotaModal").find('#fquotabal').attr("readonly", true);

                $('#lquotaModal').modal('show');
                $("input[value='patch']").remove();
                $('#lquotaForm').attr('action', '/hr/leave-quota');
            });

            $('#leave-quota-table').on('click', '.editBtn', function () {
                $('#lquotaForm').trigger("reset");
                $('#lquotaModal').find('#modalTitle').html("Update Leave Quota data");
                let tr = $(this).closest('tr');
                let data = $('#leave-quota-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#lquotaForm');

                $('#fempidLquota').attr('disabled', true);
                $('#fempidLquota').append('<option value="' + data.empid + '" selected>' + data.empid + '</option>');

                $('#fquotacode').attr('disabled', true);
                $('#fquotacode').append('<option value="' + data.quotacode.value + '" selected>' + data.quotacode.value + '</option>');

                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-leave-quota");
                $('#lquotaForm').attr('action', '/hr/leave-quota/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#lquotaModal').modal('show');
            });

            $('#lquotaForm').on('submit', function (event) {
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
                        $("#whourForm").find('#saveBtn').prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            $("#ibox-whour").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $("#ibox-whour").find('#form_result').html(data.success);
                        }
                        if(data.warning){
                            $("#ibox-whour").find('#form_result').attr('class', 'alert alert-warning fade show font-weight-bold');
                            $("#ibox-whour").find('#form_result').html(data.warning);
                        }
                        if(data.error){
                            $("#ibox-whour").find('#form_result').attr('class', 'alert alert-danger fade show font-weight-bold');
                            $("#ibox-whour").find('#form_result').html(data.error);
                        }
                        $('#whourModal').modal('hide');
                        $('#whour-table').DataTable().ajax.reload();
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
                        $("#whourForm").find('#saveBtn').prop('disabled', false);
                    }
                });
            });
        });

    </script>
@endpush
