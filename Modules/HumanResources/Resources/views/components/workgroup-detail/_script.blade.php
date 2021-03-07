@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
    <script src="https://cdn.datatables.net/fixedcolumns/3.3.1/js/dataTables.fixedColumns.min.js"></script>
    <script>
        function workgroupDetailGetShift(workgroup){   //getShift when workgroup changed
            let wgcode = workgroup.value;

            $('#fshiftno').val(''); //kosongkan dulu shiftno
            $('.select2_shiftno').select2({
                theme: 'bootstrap4',
                placeholder: 'choose shiftno',
                ajax: {
                    url: "{{route('hr.workgroup-detail.select2.shiftno')}}",
                    data: {
                        workgroup: wgcode
                    },
                    dataType: 'json',
                },
                dropdownParent: $('#workgroupDetailModal')
            });
        }

        $(document).ready(function () {
            var actionUrl = '/hr/workgroup-detail';
            var tableDetailId = '#workgroup-detail-table';
            var inputFormDetailId = '#workgroupDetailForm';

            $('#workgroup-detail-table').DataTable({
                processing: true,
                serverSide: false,
                searchDelay: 1000,
                language: {
                    emptyTable: "No data existed for selected workgroup",
                },
                height: 180,
                ajax: {
                    url: "/hr/workgroup-detail",
                    type: "GET",
                    dataType: "json",
                },
                columns: [
                    { data: 'workgroup.value', name: 'workgroup.value' },
                    { data: 'daycode.day', name: 'daycode.day' },
                    { data: 'shiftno', name: 'shiftno' },
                    { data: 'whtimestart', name: 'whtimestart', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'whtimefinish', name: 'whtimefinish', defaultContent: "<p class='text-muted'>none</p>"},
                    { data: 'rstimestart', name: 'rstimestart', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'rstimefinish', name: 'rstimefinish', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'stdhours.content', name: 'stdhours', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'minhours.content', name: 'minhours', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'worktype.content', name: 'worktype', },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false },
                ]
            });

            $('.select2_wgcode').select2({
                theme: 'bootstrap4',
                placeholder: 'choose workgroup',
                ajax: {
                    url: "{{route('hr.workgroup-detail.select2.workgroup')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#workgroupDetailModal')
            });

            $('#create-wg-detail').click(function () {
                $('#saveBtn').val("create-workgroup-detail");
                $('#workgroupDetailForm').trigger("reset");
                $("#workgroupDetailModal").find('#modalTitle').html("Add new Working Group Detail data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $("#fwgcode").attr("disabled", false);
                $("#fdaycode").attr("disabled", false);
                $("#fshiftno").attr("disabled", false);
                $(".select2_wgcode").val(null).trigger('change');
                $(".select2_shiftno").val(null).trigger('change');
                showCreateModal ('Add New Workgroup Detail', inputFormDetailId, actionUrl, '#workgroupDetailModal');
            });

            $('#workgroup-detail-table').on('click', '.editBtn', function () {
                $('#workgroupDetailForm').trigger("reset");
                $('#workgroupDetailModal').find('#modalTitle').html("Update Working Group data");
                let tr = $(this).closest('tr');
                let data = $('#workgroup-detail-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#workgroupDetailForm');

                $("#fwgcode").attr("disabled", true);
                $('#fwgcode').append('<option value="' + data.workgroup.value + '" selected>' + data.workgroup.value + ' - ' + data.workgroup.name + '</option>');
                // $("#fwgcode").val(data.workgroup.value).trigger('change');

                $("#fshiftno").attr("disabled", true);
                $('.select2_shiftno').select2({
                theme: 'bootstrap4',
                    placeholder: 'choose shiftno',
                    ajax: {
                        url: "{{route('hr.workgroup-detail.select2.shiftno')}}",
                        data: {
                            workgroup: data.workgroup.value
                        },
                        dataType: 'json',
                    },
                    dropdownParent: $('#workgroupDetailModal')
                });
                $('#fshiftno').append('<option value="' + data.shiftno + '" selected>' + data.shiftno + '</option>');

                $("#fdaycode").attr("disabled", true);
                $('#fdaycode').find('option[value="' + data.daycode.value + '"]').attr('selected', '');
                $('#fwhtimestart').val(data.whtimestart);
                $('#fwhtimefinish').val(data.whtimefinish);
                $('#frstimestart').val(data.rstimestart);
                $('#frstimefinish').val(data.rstimefinish);
                $('#fstdhours').val(data.stdhours.value);
                $('#fminhours').val(data.minhours.value);
                $('#fworktype').find('option[value="' + data.worktype.value + '"]').attr('selected', '');

                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-workgroup-detail");
                $('#workgroupDetailForm').attr('action', '/hr/workgroup-detail/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#workgroupDetailModal').modal('show');
            });

            // $(inputDetailFormId).on('submit', function (event) {
            //     submitButtonProcessDynamic (tableDetailId, inputFormDetailId, '#workgroupDetailModal');
            // });

            $('#workgroupDetailForm').on('submit', function (event) {
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
                        $("#workgroupDetailForm").find('#saveBtn').prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            $("#ibox-workgroup-detail").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $("#ibox-workgroup-detail").find('#form_result').html(data.success);
                        }
                        $('#workgroupDetailModal').modal('hide');
                        $('#workgroup-detail-table').DataTable().ajax.reload();
                    },
                    error:function(data){
                        let errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function (index, value) {
                                if (index == 'daycode'){
                                    if (value[0].indexOf("has already been taken") >= 0){
                                        value[0] = 'This daycode with choosen Workgroup and Shiftno has already been taken';
                                    }
                                }
                                $('div.invalid-feedback-'+index).html(value);
                            })
                        }
                    },
                    complete:function(){
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'stop' );
                        $("#workgroupDetailForm").find('#saveBtn').prop('disabled', false);
                    }
                });
            });
        });

    </script>
@endpush
