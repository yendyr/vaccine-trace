@push('footer-scripts')
    <script src="https://cdn.datatables.net/fixedcolumns/3.3.1/js/dataTables.fixedColumns.min.js"></script>

    <script>
        var tableEmp = $('#employee-table').DataTable({
            // processing: true,
            serverSide: false,
            scrollX: true,
            language: {
                emptyTable: "No data existed",
            },
            fixedColumns:   {
                leftColumns: 0,
                rightColumns: 1
            },
            selected: true,
            ajax: {
                url: "/hr/employee",
                type: "GET",
                dataType: "json",
            },
            columns: [
                { data: 'empid', name: 'empid' },
                { data: 'fullname', name: 'fullname', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'pob', name: 'pob' },
                { data: 'dob', name: 'dob' },
                { data: 'gender.content', name: 'gender.content', defaultContent: "<p class='text-muted'>none</p>"},
                { data: 'religion', name: 'religion', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'phone.content', name: 'phone.content', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'email', name: 'email', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'bloodtype', name: 'bloodtype', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'maritalstatus.content', name: 'maritalstatus.content', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'empdate', name: 'empdate', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'cessdate', name: 'cessdate', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'probation.content', name: 'probation.content', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'cesscode.content', name: 'cesscode.content', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'recruitby', name: 'recruitby', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'emptype.content', name: 'emptype.content', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'workgrp', name: 'workgrp', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'site', name: 'site', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'accsgrp', name: 'accsgrp', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'achgrp', name: 'achgrp', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'orgcode.content', name: 'orgcode.content', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'orglvl.content', name: 'orglvl.content', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'title.content', name: 'title.content', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'jobtitle', name: 'jobtitle', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'jobgrp', name: 'jobgrp', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'costcode', name: 'costcode', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'remark', name: 'remark', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false },
            ]
        });

        function employeeSetOrgcode(data){
            $('#forglvl').val(null).trigger('change');
            $('.select2_orglvl').select2({
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

        function employeeSetTitle(data){
            $('#fjobtitle').val(null).trigger('change');

            let orgcode = $('#forgcode').val();
            $('.select2_jobtitle').select2({
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

            $('.select2_workgroup').select2({
                placeholder: 'choose workgroup',
                ajax: {
                    url: "{{route('hr.workgroup-detail.select2.workgroup')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#employeeModal')
            });
            $('.select2_orgcode').select2({
                placeholder: 'choose here',
                ajax: {
                    url: "{{route('hr.employee.select2.orgcode')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#employeeModal')
            });

            $('#create-employee').click(function () {
                $('#saveBtn').val("create-workgroup");
                $('#employeeForm').trigger("reset");
                $("#employeeModal").find('#modalTitle').html("Add new Employee data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback

                $("input[value='patch']").remove();
                $('#frecruitby').val(null).trigger('change');
                $('#fworkgrp').val(null).trigger('change');
                $('#forgcode').val(null).trigger('change');
                $("#employeeForm").find('#fempid').attr('readonly', false);
                $('#employeeModal').modal('show');
                $('#employeeForm').attr('action', '/hr/employee');
            });

            $('#fphoto').on('change', function() {  //set filename as label
                let fileName = $(this).val().split('\\').pop();
                $(this).siblings('.custom-file-label').addClass("selected").html(fileName);
            });

            $('#employee-table').on('click', '.editBtn', function () {
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
                $('#ffullname').val(data.fullname);
                $('#fnickname').val(data.nickname);
                $('#fpob').val(data.pob);
                $('#fdob').val(data.dob);
                $('#fgender').find('option').removeAttr('selected');
                $('#fgender').find('option[value="' + data.gender.value + '"]').attr('selected', '');
                $('#freligion').find('option').removeAttr('selected');
                $('#freligion').find('option[value="' + data.religion.value + '"]').attr('selected', '');
                $('#fmobile01').val(data.phone.mobile01);
                $('#fmobile02').val(data.phone.mobile02);
                $('#femail').val(data.email);
                $('#fbloodtype').find('option').removeAttr('selected');
                $('#fbloodtype').find('option[value="' + data.bloodtype.value + '"]').attr('selected', '');
                $('#fmaritalstatus').find('option').removeAttr('selected');
                $('#fmaritalstatus').find('option[value="' + data.maritalstatus.value + '"]').attr('selected', '');
                $('#fempdate').val(data.empdate);
                $('#fcessdate').val(data.cessdate);
                $('#fprobation').find('option').removeAttr('selected');
                $('#fprobation').find('option[value="' + data.probation.value + '"]').attr('selected', '');
                $('#fcesscode').find('option').removeAttr('selected');
                $('#fcesscode').find('option[value="' + data.cesscode.value + '"]').attr('selected', '');
                $('#frecruitby').find('option').removeAttr('selected');
                $('#frecruitby').find('option[value="' + data.recruitby.value + '"]').attr('selected', '');
                $('#femptype').find('option').removeAttr('selected');
                $('#femptype').find('option[value="' + data.emptype.value + '"]').attr('selected', '');
                $('#fworkgrp').append('<option value="' + data.workgrp + '" selected>' + data.workgrp + '</option>');
                $('#fsite').val(data.site);
                $('#faccsgrp').val(data.accsgrp);
                $('#fachgrp').val(data.achgrp);
                $('#fjobgrp').val(data.jobgrp);
                $('#fcostcode').val(data.costcode);
                $('#faccsgrp').val(data.accsgrp);
                $('#forgcode').append('<option value="' + data.orgcode.value + '" selected>' + data.orgcode.value + ' - ' + data.orgcode.content + '</option>');
                $('#forglvl').append('<option value="' + data.orglvl.value + '" selected>' + data.orglvl.content + '</option>');
                $('#ftitle').append('<option value="' + data.title.value + '" selected>' + data.title.content + '</option>');
                $('#fjobtitle').append('<option value="' + data.jobtitle + '" selected>' + data.jobtitle + '</option>');
                $('#fremark').val(data.remark);
                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-employee");
                $('#employeeForm').attr('action', '/hr/employee/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#employeeModal').modal('show');
            });

            $('#employeeForm').on('submit', function (event) {
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
                    enctype: 'multipart/form-data',
                    data: new FormData($(this)[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend:function(){
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'start' );
                        $('[class^="invalid-feedback-"]').html('');
                        $("#employeeForm").find('#saveBtn').prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            $("#ibox-employee").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $("#ibox-employee").find('#form_result').html(data.success);
                        }
                        $('#employeeModal').modal('hide');
                        tableEmp.ajax.reload();
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
                        $("#employeeForm").find('#saveBtn').prop('disabled', false);
                    }
                });
            });
        });

    </script>
@endpush
