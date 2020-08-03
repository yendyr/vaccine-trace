@push('footer-scripts')
    <script>

        $('#workgroup-table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            language: {
                emptyTable: "No data existed",
            },
            ajax: {
                url: "/hr/workgroup",
                type: "GET",
                dataType: "json",
            },
            columns: [
                { data: 'workgroup', name: 'workgroup' },
                { data: 'workname', name: 'workname', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'shiftstatus', name: 'shiftstatus' },
                { data: 'shiftrolling', name: 'shiftrolling', defaultContent: "<p class='text-muted'>none</p>"},
                { data: 'rangerolling.content', name: 'rangerolling', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'roundtime.content', name: 'roundtime', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'workfinger', name: 'workfinger', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'restfinger', name: 'restfinger', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'remark', name: 'remark', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false },
            ]
        });

        $(document).ready(function () {

            $('#create-wg').click(function () {
                $('#saveBtn').val("create-workgroup");
                $('#workgroupForm').trigger("reset");
                $("#workgroupModal").find('#modalTitle').html("Add new Working Group data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback

                $('#workgroupModal').modal('show');
                $("input[value='patch']").remove();
                $('#workgroupForm').attr('action', '/hr/workgroup');
            });

            $('#workgroup-table').on('click', '.editBtn', function () {
                $('#workgroupForm').trigger("reset");
                $('#workgroupModal').find('#modalTitle').html("Update Working Group data");
                let tr = $(this).closest('tr');
                let data = $('#workgroup-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#workgroupForm');

                $('#fworkgroup').val(data.workgroup);
                $('#fworkname').val(data.workname);
                $('#fshiftstatus').find('option').removeAttr('selected');
                $('#fshiftstatus').find('option[value="' + data.shiftstatus + '"]').attr('selected', '');
                $('#fshiftrolling').val(data.shiftrolling);
                $('#frangerolling').val(data.rangerolling.value);
                $('#froundtime').val(data.roundtime.value);
                $('#fworkfinger').val(data.workfinger);
                $('#frestfinger').val(data.restfinger);
                $('#fremark').val(data.remark);

                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-workgroup");
                $('#workgroupForm').attr('action', '/hr/workgroup/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#workgroupModal').modal('show');
            });

            $('#workgroupForm').on('submit', function (event) {
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
                        $("#workgroupForm").find('#saveBtn').html('<strong>Saving...</strong>');
                        $("#workgroupForm").find('#saveBtn').prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            $("#ibox-workgroup").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $("#ibox-workgroup").find('#form_result').html(data.success);
                        }
                        $('#workgroupModal').modal('hide');
                        $('#workgroup-table').DataTable().ajax.reload();
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
                        $("#workgroupForm").find('#saveBtn').prop('disabled', false);
                        $("#workgroupForm").find('#saveBtn').html('<strong>Save Changes</strong>');
                    }
                });
            });
        });

    </script>
@endpush
