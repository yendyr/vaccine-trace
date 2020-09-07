@push('header-scripts')
    <link href="{{URL::asset('theme/css/plugins/daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet">
@endpush
@push('footer-scripts')
    <!-- Date range picker -->
    <script src="{{URL::asset('theme/js/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{URL::asset('theme/js/plugins/fullcalendar/moment.min.js')}}"></script>

    <script>
        var tableWHour = $('#whour-table').DataTable({
            processing: false,
            serverSide: false,
            scrollX: true,
            language: {
                emptyTable: "No data existed for working hour",
            },
            height: 180,
            ajax: {
                url: "/hr/working-hour",
                type: "GET",
                dataType: "json",
            },
            columns: [
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
                { data: 'stdhours.content', name: 'stdhours', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'minhours.content', name: 'minhours', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'worktype.content', name: 'worktype', defaultContent: "<p class='text-muted'>none</p>"},
                { data: 'workstatus', name: 'workstatus', defaultContent: "<p class='text-muted'>none</p>"},
                { data: 'processedon', name: 'processedon', defaultContent: "<p class='text-muted'>none</p>"},
                { data: 'leavehours', name: 'leavehours', defaultContent: "<p class='text-muted'>none</p>"},
                { data: 'attdhours', name: 'attdhours', defaultContent: "<p class='text-muted'>none</p>"},
                { data: 'overhours', name: 'overhours', defaultContent: "<p class='text-muted'>none</p>"},
                { data: 'attdstatus', name: 'attdstatus', defaultContent: "<p class='text-muted'>none</p>"},
                { data: 'status', name: 'status' },
                // { data: 'action', name: 'action', orderable: false },
            ]
        });

        $(document).ready(function () {
            $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            $('#whourForm').find('.select2_empidWhour').select2({
                placeholder: 'choose Emp ID',
                ajax: {
                    url: "{{route('hr.employee.select2.empid')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#whourModal')
            });

            $('#create-whour').click(function () {
                $('#saveBtn').val("create-whour");
                $('#whourForm').trigger("reset");
                $("#whourModal").find('#modalTitle').html("Generate new Working Hour data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $("#fempidWhour").attr("disabled", false);
                $(".select2_empidWhour").val(null).trigger('change');

                $('#whourModal').modal('show');
                $("input[value='patch']").remove();
                $('#whourForm').attr('action', '/hr/working-hour');
            });

            $('#whour-table').on('click', '.editBtn', function () {
                $('#whourForm').trigger("reset");
                $('#whourModal').find('#modalTitle').html("Update Working Group data");
                let tr = $(this).closest('tr');
                let data = $('#whour-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#whourForm');

                $('#fempidWhour').attr('disabled', true);
                $('#fempidWhour').append('<option value="' + data.empid + '" selected>' + data.empid + '</option>');

                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-workgroup-detail");
                $('#whourForm').attr('action', '/hr/workgroup-detail/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                // $('#whourModal').modal('show');
            });

            $('#whourForm').on('submit', function (event) {
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
