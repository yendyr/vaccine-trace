@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
    <script src="https://cdn.datatables.net/fixedcolumns/3.3.1/js/dataTables.fixedColumns.min.js"></script>

    <script>
        function employeeSetOrgcode(data){
            $('#forglvl').val(null).trigger('change');
            $('.select2_orglvl').select2({
                theme: 'bootstrap4',
                placeholder: 'select org code first',
                ajax: {
                    url: "{{route('hr.employee.select2.orglvl')}}",
                    data: {
                        orgcode: data.value
                    },
                    dataType: 'json',
                },
                dropdownParent: $('#employeeModal')
            });

            $('#ftitle').val(null).trigger('change');
            $('.select2_title').select2({
                theme: 'bootstrap4',
                placeholder: 'select org code first',
                ajax: {
                    url: "{{route('hr.employee.select2.title')}}",
                    data: {
                        orgcode: data.value
                    },
                    dataType: 'json',
                },
                dropdownParent: $('#employeeModal')
            });
        }
        $('.select2_workgroup').select2({
            theme: 'bootstrap4',
            placeholder: 'choose workgroup',
            ajax: {
                url: "{{route('hr.workgroup-detail.select2.workgroup')}}",
                dataType: 'json',
            },
            dropdownParent: $('#employeeModal')
        });
        $('.select2_orgcode').select2({
            theme: 'bootstrap4',
            placeholder: 'choose here',
            ajax: {
                url: "{{route('hr.employee.select2.orgcode')}}",
                dataType: 'json',
            },
            dropdownParent: $('#employeeModal')
        });
        $('.select2_recruitby').select2({
            theme: 'bootstrap4',
            placeholder: 'choose here',
            ajax: {
                url: "{{route('hr.employee.select2.recruitby')}}",
                dataType: 'json',
            },
            dropdownParent: $('#employeeModal')
        });
        $('.select2_religion').select2({
            theme: 'bootstrap4',
            placeholder: 'choose here',
            ajax: {
                url: "{{route('hr.employee.select2.religion')}}",
                dataType: 'json',
            },
            dropdownParent: $('#employeeModal')
        });
        $('.select2_maritalstatus').select2({
            theme: 'bootstrap4',
            placeholder: 'choose here',
            ajax: {
                url: "{{route('hr.employee.select2.maritalstatus')}}",
                dataType: 'json',
            },
            dropdownParent: $('#employeeModal')
        });
        $('.select2_bloodtype').select2({
            theme: 'bootstrap4',
            placeholder: 'choose here',
            ajax: {
                url: "{{route('hr.employee.select2.bloodtype')}}",
                dataType: 'json',
            },
            dropdownParent: $('#employeeModal')
        });

        function employeeSetTitle(data){
            $('#fjobtitle').val(null).trigger('change');

            let orgcode = $('#forgcode').val();
            $('.select2_jobtitle').select2({
                theme: 'bootstrap4',
                placeholder: 'choose title first',
                ajax: {
                    url: "{{route('hr.employee.select2.jobtitle')}}",
                    data: {
                        orgcode: orgcode,
                        titlecode: data.value
                    },
                    dataType: 'json',
                },
                dropdownParent: $('#employeeModal')
            });
        }

        $(document).ready(function () {
            var actionUrl = '/hr/employee';
            var tableId = '#employee-table';
            var inputFormId = '#employeeForm';

            var tableEmp = $(tableId).DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                searchDelay: 1500,
                language: {
                    emptyTable: "No data existed",
                },
                fixedColumns:   {
                    leftColumns: 0,
                    rightColumns: 1
                },
                columnDefs: [
                    {
                        targets: [ 0 ],
                        visible: false
                    }
                ],
                selected: true,
                ajax: {
                    url: '/hr/employee',
                    type: "GET",
                    dataType: "json",
                },
                columns: [
                    { data: 'photo', defaultContent: '-' },
                    { data: 'empid', defaultContent: '-' },
                    { data: 'fullname', defaultContent: '-' },
                    { data: 'pob', defaultContent: '-', searchable:false },
                    { data: 'dob', defaultContent: '-', searchable:false },
                    { data: 'gender.content', searchable:false, defaultContent: '-' },
                    { data: 'religion', searchable:false, defaultContent: '-' },
                    { data: 'phone.content', searchable:false, defaultContent: '-' },
                    { data: 'email', defaultContent: '-' },
                    { data: 'bloodtype', defaultContent: '-' },
                    { data: 'maritalstatus.content', searchable:false, defaultContent: '-' },
                    { data: 'empdate', defaultContent: '-' },
                    { data: 'cessdate', defaultContent: '-' },
                    { data: 'probation.content', searchable:false, defaultContent: '-' },
                    { data: 'cesscode.content', searchable:false, defaultContent: '-' },
                    { data: 'recruitby.content', searchable:false, defaultContent: '-' },
                    { data: 'emptype.content', searchable:false, defaultContent: '-' },
                    { data: 'workgrp', defaultContent: '-' },
                    { data: 'site', defaultContent: '-' },
                    { data: 'accsgrp', defaultContent: '-' },
                    { data: 'achgrp', defaultContent: '-' },
                    { data: 'orgcode.content', searchable:false, defaultContent: '-' },
                    { data: 'orglvl.content', searchable:false, defaultContent: '-' },
                    { data: 'title.content', searchable:false, defaultContent: '-' },
                    { data: 'jobtitle', defaultContent: '-' },
                    { data: 'jobgrp', defaultContent: '-' },
                    { data: 'costcode', defaultContent: '-' },
                    { data: 'remark', defaultContent: '-' },
                    { data: 'status', defaultContent: '-' },
                    { data: 'action', orderable: false },
                ]
            });

            //filter for selected emp
            $('#employee-table tbody').on('click', 'tr', function () {
                //make selected row effect
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                }
                else {
                    tableEmp.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
                //send data to Id Card when selecting row
                let data = tableEmp.row(this).data();
                let urlAjax = "/hr/id-card?empid=" + data.empid;
                if ( $.fn.DataTable.isDataTable('#idcard-table') ) {
                    $('#idcard-table').DataTable().ajax.url(urlAjax).load();
                }
            });

            //jika telah dipilih gambar filenya
            $('#fphoto').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).siblings('.custom-file-label').addClass("selected").html(fileName);
            });

            $('#create-employee').click(function () {
                clearForm(inputFormId);
                $("input[value='patch']").remove();
                $("#employeeForm").find('#fempid').removeAttr('readonly');
                $('#frecruitby').val(null).trigger('change');
                $('#fworkgrp').val(null).trigger('change');
                $('#forgcode').val(null).trigger('change');
                $('#frecruitby').val(null).trigger('change');
                $('#freligion').val(null).trigger('change');
                $('#fbloodtype').val(null).trigger('change');
                $('#fmaritalstatus').val(null).trigger('change');
                $('#fphoto').siblings('.custom-file-label').removeClass("selected").html('choose photo');
                $("#employeeForm").find('#fempid').attr('readonly', false);
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                showCreateModal ('Add New Employee', inputFormId, actionUrl, '#employeeModal');
            });

            tableEmp.on('click', '.editBtn', function () {
                $('#employeeForm').trigger("reset");
                $('#employeeModal').find('#modalTitle').html("Update Employee data");
                let tr = $(this).closest('tr');
                let data = $('#employee-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#employeeForm');

                $("#employeeForm").find('#fempid').attr('readonly', true);
                $("#employeeForm").find('#fempid').val(data.empid);

                let photoVal = data.photo;
                if (photoVal != null){
                    $('#fphoto').siblings('.custom-file-label').removeClass("selected").html('photo existed');
                } else {
                    $('#fphoto').siblings('.custom-file-label').removeClass("selected").html('choose photo');
                }
                $('#ffullname').val(data.fullname);
                $('#fnickname').val(data.nickname);
                $('#fpob').val(data.pob);
                $('#fdob').val(data.dob);
                $('#fgender').find('option').removeAttr('selected');
                if (data.gender != null)
                    $('#fgender').find('option[value="' + data.gendervalue + '"]').attr('selected', '');
                $('#freligion').append('<option value="' + data.religion + '" selected>' + data.religion + '</option>');
                $('#fmobile01').val(data.phone?.mobile01);
                $('#fmobile02').val(data.phone?.mobile02);
                $('#femail').val(data.email);
                $('#fbloodtype').append('<option value="' + data.bloodtype + '" selected>' + data.bloodtype + '</option>');
                if (data.maritalstatus != null)
                    $('#fmaritalstatus').append('<option value="' + data.maritalstatus.value + '" selected>' + data.maritalstatus.content + '</option>');
                $('#fempdate').val(data.empdate);
                $('#fcessdate').val(data.cessdate);
                $('#fprobation').find('option').removeAttr('selected');
                if (data.probation != null)
                    $('#fprobation').find('option[value="' + data.probation.value + '"]').attr('selected', '');
                $('#fcesscode').find('option').removeAttr('selected');
                if (data.cesscode != null)
                    $('#fcesscode').find('option[value="' + data.cesscode.value + '"]').attr('selected', '');
                if (data.recruitby != null)
                    $('#frecruitby').append('<option value="' + data.recruitby.value + '" selected>' + data.recruitby.content + '</option>');
                $('#femptype').find('option').removeAttr('selected');
                if (data.emptype != null)
                    $('#femptype').find('option[value="' + data.emptype.value + '"]').attr('selected', '');
                $('#fworkgrp').append('<option value="' + data.workgrp + '" selected>' + data.workgrp + '</option>');
                $('#fsite').val(data.site);
                $('#faccsgrp').val(data.accsgrp);
                $('#fachgrp').val(data.achgrp);
                $('#fjobgrp').val(data.jobgrp);
                $('#fcostcode').val(data.costcode);
                $('#faccsgrp').val(data.accsgrp);
                if (data.orgcode != null)
                    $('#forgcode').append('<option value="' + data.orgcode.value + '" selected>' + data.orgcode.value + ' - ' + data.orgcode.content + '</option>');
                if (data.orglvl != null)
                    $('#forglvl').append('<option value="' + data.orglvl.value + '" selected>' + data.orglvl.content + '</option>');
                if (data.title != null)
                    $('#ftitle').append('<option value="' + data.title.value + '" selected>' + data.title.content + '</option>');
                $('#fjobtitle').append('<option value="' + data.jobtitle + '" selected>' + data.jobtitle + '</option>');
                $('#fremark').val(data.remark);
                $("#employeeForm").find('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $("#employeeForm").find('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $("#employeeForm").find('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-employee");
                $('#employeeForm').attr('action', '/hr/employee/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#employeeModal').modal('show');
            });

            $(inputFormId).on('submit', function (event) {
                submitButtonProcessDynamic (tableId, inputFormId, '#employeeModal');
            });

            // deleteButtonProcess (datatableObject, tableId, actionUrl);
        });
    </script>
@endpush
