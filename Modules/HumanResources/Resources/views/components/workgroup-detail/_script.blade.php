@push('footer-scripts')
    <script>
        $('#workgroup-detail-table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            language: {
                emptyTable: "No data existed",
            },
            ajax: {
                url: "/hr/workgroup-detail",
                type: "GET",
                dataType: "json",
            },
            columns: [
                { data: 'workgroup.value', name: 'workgroup' },
                { data: 'daycode.day', name: 'daycode' },
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

        $(document).ready(function () {
            $('.select2_wgcode').select2({
                placeholder: 'choose here',
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
                $(".select2_wgcode").val(null).trigger('change');

                $('#workgroupDetailModal').modal('show');
                $("input[value='patch']").remove();
                $('#workgroupDetailForm').attr('action', '/hr/workgroup-detail');
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

                $(".select2_wgcode").val(null).trigger('change');
                $('#fwgcode').append('<option value="' + data.workgroup.value + '" selected>' + data.workgroup.value + ' - ' + data.workgroup.name + '</option>');

                $('#fdaycode').find('option[value="' + data.daycode.value + '"]').attr('selected', '');
                $('#fshiftno').find('option[value="' + data.shiftno + '"]').attr('selected', '');
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
                        $("#workgroupDetailForm").find('#saveBtn').html('<strong>Saving...</strong>');
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
                                $('div.invalid-feedback-'+index).html(value);
                            })
                        }
                    },
                    complete:function(){
                        $("#workgroupDetailForm").find('#saveBtn').prop('disabled', false);
                        $("#workgroupDetailForm").find('#saveBtn').html('<strong>Save Changes</strong>');
                    }
                });
            });
        });

    </script>
@endpush
