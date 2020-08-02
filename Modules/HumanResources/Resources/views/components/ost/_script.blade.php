@push('footer-scripts')
    <script>

        $('#ost-table').DataTable({
            retrieve: true,
            processing: true,
            serverSide: true,
            language: {
                emptyTable: "Nothing Organization Structure Title data get",
            },
            ajax: {
                url: "/hr/org-structure-title",
                type: "GET",
                dataType: "json",
            },
            columns: [
                { data: 'titlecode.title', name: 'titlecode' },
                { data: 'jobtitle', name: 'jobtitle' },
                { data: 'rptorg.name', name: 'rptorg', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'rpttitle.title', name: 'rpttitle', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false },
                { data: 'orgcode', name: 'orgcode', visible: false },
            ]
        });
        $('#TreeGrid').on('click', function () {
            let selectedrecords = treeGridObj.getSelectedRecords();
            let orgCode = selectedrecords[0].orgcode;
            let orgstructure = {orgcode: orgCode};
            let urlAjax = "/hr/org-structure-title?orgcode=" + orgstructure.orgcode;
            if ( $.fn.DataTable.isDataTable('#ost-table') ) {
                $('#ost-table').DataTable().ajax.url(urlAjax).load();
            }
        });

        $(document).ready(function () {
            var ostId;

            $('.select2_orgcode').select2({
                placeholder: 'choose here',
                ajax: {
                    url: "{{route('hr.org-structure-title.select2.orgcode')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#ostModal')
            });
            $('.select2_rptorg').select2({
                placeholder: 'choose here',
                ajax: {
                    url: "{{route('hr.org-structure-title.select2.rptorg')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#ostModal')
            });
            $('.select2_rpttitle').select2({
                placeholder: 'choose here',
                ajax: {
                    url: "{{route('hr.org-structure-title.select2.title')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#ostModal')
            });

            $('#createOST').click(function () {
                $('#saveBtn').val("create-os");
                $('#ostForm').trigger("reset");
                $("#ostModal").find('#modalTitle').html("Add New Organization Structure title data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $(".select2_orgcode").select2("val", "");
                $(".select2_rptorg").select2("val", "none");
                $(".select2_rpttitle").select2("val", "none");

                $('#ostModal').modal('show');
                $("#ostForm").find('input[name="id"]').remove();
                $("input[value='patch']").remove();
                $('#ostForm').attr('action', '/hr/org-structure-title');
            });

            $('#ost-table').on('click', '.editBtn', function () {
                $('#ostForm').trigger("reset");
                $('#ostModal').find('#modalTitle').html("Update Organization Structure title data");
                ostId= $(this).val();
                let tr = $(this).closest('tr');
                let data = $('#ost-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#ostForm');

                $(".select2_orgcode").select2("val", "");
                $('#forgcode').empty();
                $('#forgcode').append('<option value="' + data.orgcode.code + '" selected>' + data.orgcode.code + ' - ' + data.orgcode.name + '</option>');

                $('#ftitlecode').find('option').removeAttr('selected');
                $('#ftitlecode').find('option[value="' + data.titlecode.value + '"]').attr('selected', '');
                $('#fjobtitle').val(data.jobtitle);

                $(".select2_rptorg").select2("val", "none");
                if (data.rptorg == null){
                    $('#frptorg').append('<option value="' + 0 + '" selected>none</option>');
                } else{
                    $('#frptorg').append('<option value="' + data.rptorg.code + '" selected>' + data.rptorg.code + ' - ' + data.rptorg.name + '</option>');
                }

                $(".select2_rpttitle").select2("val", "none");
                if (data.rpttitle == null){
                    $('#frpttitle').append('<option value="' + 0 + '" selected>none</option>');
                } else{
                    $('#frpttitle').append('<option value="' + data.rpttitle.code + '" selected>' + data.rpttitle.title + '</option>');
                }

                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-ost");
                $("#ostForm").find('input[name="id"]').remove();
                $('<input type="hidden" name="id" value="' + data.id + '">').prependTo('#ostForm');
                $('#ostForm').attr('action', '/hr/org-structure-title/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#ostModal').modal('show');
            });

            $('#ostForm').on('submit', function (event) {
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
                        $("#ostForm").find('#saveBtn').html('<strong>Saving...</strong>');
                        $("#ostForm").find('#saveBtn').prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            $("#ibox_ost").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $("#ibox_ost").find('#form_result').html(data.success);
                        }
                        $('#ostModal').modal('hide');
                        $('#ost-table').DataTable().ajax.reload();
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
                        $("#ostForm").find('#saveBtn').prop('disabled', false);
                        $("#ostForm").find('#saveBtn').html('<strong>Save Changes</strong>');
                    }
                });
            });
        });

    </script>
@endpush
