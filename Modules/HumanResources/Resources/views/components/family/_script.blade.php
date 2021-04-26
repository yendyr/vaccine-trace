@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
    <script>
        $(document).ready(function () {
            var actionUrl = '/hr/family';
            var tableId = '#family-table';
            var inputFormId = '#familyForm';

            var tableFamily = $('#family-table').DataTable({
                processing: true,
                serverSide: false,
                searchDelay: 1500,
                language: {
                    emptyTable: "No data existed",
                },
                ajax: {
                    url: "/hr/family",
                    type: "GET",
                    dataType: "json",
                },
                columns: [
                    { data: 'empid', defaultContent: '-' },
                    { data: 'famid', defaultContent: '-' },
                    { data: 'relationship.content', defaultContent: '-' },
                    { data: 'fullname', defaultContent: '-' },
                    { data: 'pob', defaultContent: '-' },
                    { data: 'dob', defaultContent: '-' },
                    { data: 'gender.content', defaultContent: '-' },
                    { data: 'maritalstatus.content', defaultContent: '-' },
                    { data: 'edulvl.content', defaultContent: '-' },
                    { data: 'edumajor', defaultContent: '-' },
                    { data: 'job.content', defaultContent: '-' },
                    { data: 'remark', defaultContent: '-' },
                    { data: 'status', defaultContent: '-' },
                    { data: 'action', orderable: false },
                ]
            });

            $('#familyForm').find('.select2_empidFamily').select2({
                theme: 'bootstrap4',
                placeholder: 'choose Emp ID',
                ajax: {
                    url: "{{route('hr.employee.select2.empid')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#familyModal')
            });
            $('.select2_edulvlFamily').select2({
                theme: 'bootstrap4',
                placeholder: 'choose edu level',
                ajax: {
                    url: "{{route('hr.education.select2.edulvl')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#familyModal')
            });
            $('.select2_maritalstatusFamily').select2({
                theme: 'bootstrap4',
                placeholder: 'choose here',
                ajax: {
                    url: "{{route('hr.employee.select2.maritalstatus')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#familyModal')
            });
            $('.select2_relationship').select2({
                theme: 'bootstrap4',
                placeholder: 'choose here',
                ajax: {
                    url: "{{route('hr.family.select2.relationship')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#familyModal')
            });
            $('.select2_jobFamily').select2({
                theme: 'bootstrap4',
                placeholder: 'choose here',
                ajax: {
                    url: "{{route('hr.family.select2.job')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#familyModal')
            });

            $('#create-family').click(function () {
                $('#saveBtn').val("create-family");
                $("input[value='patch']").remove();
                $('#fempidFamily').val(null).trigger('change');
                $('#fempidFamily').attr('disabled', false);
                $('#fedulvlFamily').val(null).trigger('change');
                $('#fmaritalstatusFamily').val(null).trigger('change');
                $('#frelationship').val(null).trigger('change');
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                showCreateModal ('Add New Family data', inputFormId, actionUrl, '#familyModal');
            });

            tableFamily.on('click', '.editBtn', function () {
                $('#familyForm').trigger("reset");
                $('#familyModal').find('#modalTitle').html("Update Family data");
                let tr = $(this).closest('tr');
                let data = $('#family-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#familyForm');

                $('#fempidFamily').attr('disabled', true);
                $('#fempidFamily').append('<option value="' + data.empid + '" selected>' + data.empid + '</option>');

                $('#ffamid').attr('disabled', true);
                $('#ffamid').val(data.famid);
                $('#frelationship').append('<option value="' + data.relationship.value + '" selected>'
                    + data.relationship.content + '</option>');

                $('#familyModal').find('#ffullname').val(data.fullname);
                $('#fpobFamily').val(data.pob);
                $('#fdobFamily').val(data.dob);
                $('#fgenderFamily').find('option').removeAttr('selected');
                $('#fgenderFamily').find('option[value="' + data.gender.value + '"]').attr('selected', '');
                $('#fmaritalstatusFamily').append('<option value="' + data.maritalstatus.value + '" selected>'
                    + data.maritalstatus.content + '</option>');
                $('#fjobFamily').append('<option value="' + data.job.value + '" selected>' + data.job.content + '</option>');
                $('#fedulvlFamily').append('<option value="' + data.edulvl.value + '" selected>' + data.edulvl.content + '</option>');
                $('#fedumajor').val(data.edumajor);
                $('#familyForm').find('#fremark').val(data.remark);

                $("#familyForm").find('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $("#familyForm").find('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $("#familyForm").find('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-family");
                $('#familyForm').attr('action', '/hr/family/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#familyModal').modal('show');
            });

            $(inputFormId).on('submit', function (event) {
                submitButtonProcessDynamic (tableId, inputFormId, '#familyModal');
            });
        });

    </script>
@endpush
