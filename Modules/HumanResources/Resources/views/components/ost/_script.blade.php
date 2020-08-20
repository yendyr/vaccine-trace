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
                $(".select2_orgcode").val(null).trigger('change');
                $(".select2_rptorg").select2("val", "none");
                $(".select2_rpttitle").select2("val", "none");
                $('#forgcode').attr('disabled', false);

                $('#ostModal').modal('show');
                $("input[value='patch']").remove();
                $('#ostForm').attr('action', '/hr/org-structure-title');
            });

            $('#ost-table').on('click', '.editBtn', function () {
                $('#ostForm').trigger("reset");
                $('#ostModal').find('#modalTitle').html("Update Organization Structure title data");
                let tr = $(this).closest('tr');
                let data = $('#ost-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#ostForm');

                $(".select2_orgcode").val(null).trigger('change');
                $('#forgcode').attr('disabled', true);
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
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'start' );
                        $('[class^="invalid-feedback-"]').html('');
                        $("#ostForm").find('#saveBtn').prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            $("#ibox-ost").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $("#ibox-ost").find('#form_result').html(data.success);
                        }
                        $('#ostModal').modal('hide');
                        $('#ost-table').DataTable().ajax.reload();
                    },
                    error:function(data){
                        let errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function (index, value) {
                                if (value[0] == "The jobtitle has already been taken."){
                                    value[0] = 'This jobtitle with choosen orgcode & title code has already been taken';
                                }
                                $('div.invalid-feedback-'+index).html(value);
                            })
                        }
                    },
                    complete:function(){
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'stop' );
                        $("#ostForm").find('#saveBtn').prop('disabled', false);
                    }
                });
            });
        });

    </script>
@endpush
