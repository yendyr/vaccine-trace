@push('header-scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" integrity="sha512-rxThY3LYIfYsVCWPCW9dB0k+e3RZB39f23ylUYTEuZMDrN/vRqLdaCBo/FbvVT6uC2r0ObfPzotsfKF9Qc5W5g==" crossorigin="anonymous" />
@endpush
@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            var actionUrl = '/hr/education';
            var tableId = '#education-table';
            var inputFormId = '#educationForm';

            var tableEducation = $('#education-table').DataTable({
                processing: true,
                serverSide: false,
                searchDelay: 1500,
                language: {
                    emptyTable: "No data existed",
                },
                ajax: {
                    url: "/hr/education",
                    type: "GET",
                    dataType: "json",
                },
                columns: [
                    { data: 'empid', defaultContent: '-' },
                    { data: 'instname', defaultContent: '-' },
                    { data: 'startperiod', defaultContent: '-' },
                    { data: 'finishperiod', defaultContent: '-' },
                    { data: 'city', defaultContent: '-' },
                    { data: 'state', defaultContent: '-' },
                    { data: 'country', defaultContent: '-' },
                    { data: 'major', defaultContent: '-' },
                    { data: 'minor', defaultContent: '-' },
                    { data: 'edulvl', defaultContent: '-' },
                    { data: 'remark', defaultContent: '-' },
                    { data: 'status', defaultContent: '-' },
                    { data: 'action', orderable: false },
                ]
            });

            $('#educationForm').find('.select2_empidEducation').select2({
                theme: 'bootstrap4',
                placeholder: 'choose Emp ID',
                ajax: {
                    url: "{{route('hr.employee.select2.empid')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#educationModal')
            });

            $('.select2_edulvlEducation').select2({
                theme: 'bootstrap4',
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
                clearForm(inputFormId);
                $("input[value='patch']").remove();
                $('#fempidEducation').val(null).trigger('change');
                $('#fempidEducation').attr('disabled', false);
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                showCreateModal ('Add New Education', inputFormId, actionUrl, '#educationModal');
            });

            tableEducation.on('click', '.editBtn', function () {
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

            $(inputFormId).on('submit', function (event) {
                submitButtonProcessDynamic (tableId, inputFormId, '#educationModal');
            });
        });

    </script>
@endpush
