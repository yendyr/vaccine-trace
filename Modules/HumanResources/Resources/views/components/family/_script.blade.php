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
                { data: 'empid', name: 'empid' },
                { data: 'famid', name: 'famid', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'relationship.content', name: 'relationship.content', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'fullname', name: 'fullname', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'pob', name: 'pob', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'dob', name: 'dob', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'gender.content', name: 'gender.content', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'maritalstatus.content', name: 'maritalstatus.content', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'edulvl.content', name: 'edulvl.content', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'edumajor', name: 'edumajor', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'job.content', name: 'job.content', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'remark', name: 'remark', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false },
            ]
        });

        $(document).ready(function () {
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
                $('#familyForm').trigger("reset");
                $("#familyModal").find('#modalTitle').html("Add new Family data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback

                $('#familyModal').modal('show');
                $("input[value='patch']").remove();
                $('#ffamid').attr('disabled', false);
                $('#fempidFamily').val(null).trigger('change');
                $('#fempidFamily').attr('disabled', false);
                $('#fedulvlFamily').val(null).trigger('change');
                $('#fmaritalstatusFamily').val(null).trigger('change');
                $('#frelationship').val(null).trigger('change');
                $('#familyForm').attr('action', '/hr/family');
            });

            $('#family-table').on('click', '.editBtn', function () {
                $('#familyForm').trigger("reset");
                $('#familyModal').find('#modalTitle').html("Update Id Card data");
                let tr = $(this).closest('tr');
                let data = $('#family-table').DataTable().row(tr).data();
                console.log(data);
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

            $('#familyForm').on('submit', function (event) {
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
                        $("#familyForm").find('#saveBtn').prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            $("#ibox-family").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $("#ibox-family").find('#form_result').html(data.success);
                        }
                        $('#familyModal').modal('hide');
                        tableFamily.ajax.reload();
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
                        $("#familyForm").find('#saveBtn').prop('disabled', false);
                    }
                });
            });
        });

    </script>
@endpush
