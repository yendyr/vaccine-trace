@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
    <script>
        $(document).ready(function () {
            var actionUrl = '/hr/org-structure-title';
            var tableId = '#ost-table';
            var inputFormId = '#ostForm';

            var tableOst = $('#ost-table').DataTable({
                retrieve: true,
                processing: true,
                serverSide: false,
                searchDelay: 1500,
                language: {
                    emptyTable: "Nothing Organization Structure Title data get",
                },
                ajax: {
                    url: actionUrl,
                    type: "GET",
                    dataType: "json",
                },
                columns: [
                    { data: 'titlecode.title', defaultContent: '-' },
                    { data: 'jobtitle', defaultContent: '-' },
                    { data: 'rptorg.name', defaultContent: '-' },
                    { data: 'rpttitle.title', defaultContent: '-' },
                    { data: 'status', defaultContent: '-' },
                    { data: 'action', orderable: false },
                    { data: 'orgcode', visible: false },
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

            $('.select2_orgcode').select2({
                theme: 'bootstrap4',
                placeholder: 'choose here',
                ajax: {
                    url: "{{route('hr.org-structure-title.select2.orgcode')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#ostModal')
            });
            $('.select2_rptorg').select2({
                theme: 'bootstrap4',
                placeholder: 'choose here',
                ajax: {
                    url: "{{route('hr.org-structure-title.select2.rptorg')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#ostModal')
            });
            $('.select2_rpttitle').select2({
                theme: 'bootstrap4',
                placeholder: 'choose here',
                ajax: {
                    url: "{{route('hr.org-structure-title.select2.title')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#ostModal')
            });
            $('.select2_titlecode').select2({
                theme: 'bootstrap4',
                placeholder: 'choose here',
                ajax: {
                    url: "{{route('hr.org-structure-title.select2.titlecode')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#ostModal')
            });

            $('#createOST').click(function () {
                $('#saveBtn').val("create-ost");
                $('#ostForm').trigger("reset");
                $("#ostModal").find('#modalTitle').html("Add New Organization Structure title data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#ostForm').find(".select2_orgcode").val(null).trigger('change');
                $('#ostForm').find(".select2_titlecode").val(null).trigger('change');
                $('#ostForm').find(".select2_rptorg").select2("val", "none");
                $('#ostForm').find(".select2_rpttitle").select2("val", "none");
                $('#ostForm').find('#forgcode').attr('disabled', false);
                $('#ostForm').find('#fjobtitle').attr('readonly', false);

                showCreateModal ('Add New Organization Structure title data', inputFormId, actionUrl, '#ostModal');
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
                $('#ostForm').find('#forgcode').attr('disabled', true);
                $('#ostForm').find('#forgcode').append('<option value="' + data.orgcode.code + '" selected>' + data.orgcode.code + ' - ' + data.orgcode.name + '</option>');

                $('#ftitlecode').append('<option value="' + data.titlecode.value + '" selected>' + data.titlecode.title + '</option>');

                $('#fjobtitle').attr('readonly', true);
                $('#fjobtitle').val(data.jobtitle);

                $(".select2_rptorg").select2("val", "none");
                if (data.rptorg == null){
                    $('#ostForm').find('#frptorg').append('<option value="' + 0 + '" selected>none</option>');
                } else{
                    $('#ostForm').find('#frptorg').append('<option value="' + data.rptorg.code + '" selected>' + data.rptorg.code + ' - ' + data.rptorg.name + '</option>');
                }

                $(".select2_rpttitle").select2("val", "none");
                if (data.rpttitle == null){
                    $('#frpttitle').append('<option value="' + 0 + '" selected>none</option>');
                } else{
                    $('#frpttitle').append('<option value="' + data.rpttitle.code + '" selected>' + data.rpttitle.title + '</option>');
                }

                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#ostForm').find('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#ostForm').find('#fstatus').find('option[value="0"]').attr('selected', '');
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
                            $('.notif').removeAttr('class').attr('class', 'notif');
                            $('#notifTitle').html("Success");
                            $('#notifMessage').html(data.success);
                            $('.notif').addClass('toast');
                            $('.notif').addClass('toast-success');
                            $('.notif').addClass('animated');
                            $('.notif').addClass('slideInRight');
                            $('.notif').toast('show');
                        }
                        $('#ostModal').modal('hide');
                        $(tableId).DataTable().ajax.reload();
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
