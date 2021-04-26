@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')
@push('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            var actionUrl = '/hr/holiday';
            var tableId = '#holiday-table';
            var inputFormId = '#inputForm';
            var sundayFormId = '#sundayForm';

            var holidayTable = $('#holiday-table').DataTable({
                processing: true,
                serverSide: false,
                searchDelay: 1500,
                language: {
                    emptyTable: "No data existed",
                },
                selected: true,
                ajax: {
                    url: actionUrl,
                    type: "GET",
                    dataType: "json",
                    data: function (d) {
                        d.search = $('input[type="search"]').val()
                        d.searchyear = $('#searchyear').val();
                        if (d.searchyear == ''){
                            let currentYear = new Date().getFullYear();
                            $('#searchyear').val(currentYear);
                            d.searchyear = currentYear;
                        }
                    },
                },
                columns: [
                    { data: 'holidayyear', defaultContent: '-' },
                    { data: 'holidaydate.name', defaultContent: '-' },
                    { data: 'holidaycode.name', defaultContent: '-' },
                    { data: 'remark', defaultContent: '-' },
                    { data: 'status', defaultContent: '-' },
                    { data: 'action', orderable: false },
                ]
            });

            $('#searchyear').on('change', function () {
                holidayTable.draw();
            });

            $(inputFormId).find('.select2_holidaycode').select2({
                theme: 'bootstrap4',
                placeholder: 'choose code',
                ajax: {
                    url: "{{route('hr.holiday.select2.code')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#inputModal')
            });

            $("#fsundayyear, #fholidayyear, #searchyear").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            });

            $('#create').click(function () {
                showCreateModal ('Create New Holiday', inputFormId, actionUrl);
            });

            holidayTable.on('click', '.editBtn', function () {
                $(inputFormId).trigger("reset");
                $('#inputModal').find('#modalTitle').html("Update Holiday data");
                let tr = $(this).closest('tr');
                let data = $('#holiday-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#inputForm');

                $('#fholidayyear').val(data.holidayyear);
                $('#fholidayyear').attr('disabled', true);

                $('#fholidaycode').find('option').removeAttr('selected');
                $('#fholidaycode').append('<option value="' + data.holidaycode.value + '" selected>' +
                    data.holidaycode.name + '</option>'
                );
                $('#fholidaycode').attr('disabled', true);

                $('#fholidaydate').val(data.holidaydate.value);
                $('#fholidaydate').attr('disabled', true);

                $('#fremark').val(data.remark);

                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-workgroup");
                $(inputFormId).attr('action', '/hr/holiday/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#inputModal').modal('show');
            });

            $(inputFormId).on('submit', function (event) {
                submitButtonProcess (tableId, inputFormId);
            });

            $('#generate-sunday').click(function () {
                $('#modalTitle').html('Generate Sunday');
                $('#sundayForm').attr('action', '/hr/holiday/sundays');
                $('#saveBtn').val("create");
                $('#sundayForm').trigger("reset");
                $('select').not('[name$="_length"]').val(null).trigger('change');
                $('#sundayModal').modal('show');
                $("input[value='patch']").remove();
            });
            $(sundayFormId).on('submit', function (event) {
                submitButtonProcessDynamic (tableId, sundayFormId, '#sundayModal');
            });

            deleteButtonProcess (holidayTable, tableId, actionUrl);
        });

    </script>
@endpush
