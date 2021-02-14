@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            var actionUrl = '/hr/leave-quota';
            var tableId = '#leave-quota-table';
            var inputFormId = '#inputForm';

            var tablelquota = $(tableId).DataTable({
                processing: false,
                serverSide: false,
                searchDelay: 1500,
                language: {
                    emptyTable: "No data existed for leave quota",
                },
                height: 180,
                ajax: {
                    url: actionUrl,
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
                    { data: 'quotabal', name: 'quotabal' },
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

            $(inputFormId).find('.select2_empidLquota').select2({
                theme: 'bootstrap4',
                placeholder: 'choose Emp ID',
                ajax: {
                    url: "{{route('hr.employee.select2.empid')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#inputModal')
            });
            $(inputFormId).find('.select2_quotacode').select2({
                theme: 'bootstrap4',
                placeholder: 'choose leave quote code',
                ajax: {
                    url: "{{route('hr.lquota.select2.quotacode')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#inputModal')
            });

            $('#create').click(function () {
                showCreateModal ('Create New Leave Quota', inputFormId, actionUrl);
            });

            tablelquota.on('click', '.editBtn', function () {
                $(inputFormId).trigger("reset");
                $('#inputModal').find('#modalTitle').html("Update Leave Quota data");
                let tr = $(this).closest('tr');
                let data = tablelquota.row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#inputForm');

                $('#fempidLquota').attr('disabled', true);
                $('#fempidLquota').append('<option value="' + data.empid + '" selected>' + data.empid + '</option>');

                $('#fquotayear').val(data.quotayear);
                $('#fquotaqty').val(data.quotaqty);
                $('#fquotastartdate').val(data.quotastartdate);
                $('#fquotaexpdate').val(data.quotaexpdate);
                $('#fremark').val(data.remark);
                $('#fquotacode').attr('disabled', true);
                $('#fquotacode').append('<option value="' + data.quotacode.value + '" selected>' + data.quotacode.content + '</option>');

                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-leave-quota");
                $(inputFormId).attr('action', '/hr/leave-quota/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#inputModal').modal('show');
            });

            $(inputFormId).on('submit', function (event) {
                submitButtonProcess (tableId, inputFormId);
            });

            deleteButtonProcess (tablelquota, tableId, actionUrl);
        });

    </script>
@endpush
