@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')
@push('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            var actionUrl = '/hr/request';
            var tableId = '#request-table';
            var inputFormId = '#inputForm';

            var tableRequest = $(tableId).DataTable({
                processing: true,
                serverSide: false,
                searchDelay: 1500,
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

            $('#data-daterange .input-daterange').datepicker({
                locale: {
                    format: 'dd-mm-yyyy'
                },
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            $('#inputForm').find('.select2_empidRequest').select2({
                theme: 'bootstrap4',
                placeholder: 'choose Emp ID',
                ajax: {
                    url: "{{route('hr.employee.select2.empid')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#inputModal')
            });

            $('#inputForm').find('#freqcode').select2({
                theme: 'bootstrap4',
                placeholder: 'choose Req code',
                ajax: {
                    url: "{{route('hr.request.select2.reqcode')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#inputModal')
            });

            $("#fquotayear").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            });

            $('#create').click(function () {
                showCreateModal ('Create New Request', inputFormId, actionUrl);
            });

            tableRequest.on('click', '.editBtn', function () {
                $(inputFormId).trigger("reset");
                $('#inputModal').find('#modalTitle').html("Update Request data");
                let tr = $(this).closest('tr');
                let data = tableRequest.row(tr).data();
                $(inputFormId).attr('action', actionUrl + '/' + data.id);

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#inputForm');

                $('#fempidRequest').attr('disabled', true);
                $('#fempidRequest').append('<option value="' + data.empid + '" selected>' + data.empid + '</option>');

                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-request");
                $('#inputForm').attr('action', '/hr/request/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#inputModal').modal('show');
            });

            $(inputFormId).on('submit', function (event) {
                console.log($(this));
                submitButtonProcess (tableId, inputFormId);
            });

            deleteButtonProcess (tableRequest, tableId, actionUrl);

        });

    </script>
@endpush
