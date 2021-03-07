@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
    <script src="https://cdn.datatables.net/fixedcolumns/3.3.1/js/dataTables.fixedColumns.min.js"></script>

    <script>
        function workgroupSetShift(data){
            if (data.value == 'N'){
                $('#fshiftrolling').val(1);
                $('#frangerolling').val(0);
                $('#fshiftrolling').attr('readonly', true);
                $('#frangerolling').attr('readonly', true);
            } else if(data.value == 'Y'){
                $('#fshiftrolling').val('');
                $('#frangerolling').val(null);
                $('#fshiftrolling').attr('readonly', false);
                $('#frangerolling').attr('readonly', false);
            }
        }

        $(document).ready(function () {
            var actionUrl = '/hr/workgroup';
            var tableId = '#workgroup-table';
            var inputFormId = '#workgroupForm';
            var tableWg = $('#workgroup-table').DataTable({
                processing: true,
                serverSide: false,
                searchDelay: 1000,
                language: {
                    emptyTable: "No data existed",
                },
                fixedColumns:   {
                    leftColumns: 0,
                    rightColumns: 1
                },
                selected: true,
                ajax: {
                    url: "/hr/workgroup",
                    type: "GET",
                    dataType: "json",
                },
                columns: [
                    { data: 'workgroup', name: 'workgroup' },
                    { data: 'workname', name: 'workname', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'shiftstatus.content', name: 'shiftstatus.content' },
                    { data: 'shiftrolling', name: 'shiftrolling', defaultContent: "<p class='text-muted'>none</p>"},
                    { data: 'rangerolling.content', name: 'rangerolling', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'roundtime.content', name: 'roundtime', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'workfinger.content', name: 'workfinger.content', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'restfinger.content', name: 'restfinger.content', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'remark', name: 'remark', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false },
                ]
            });

            //filter for workgroup detail
            $('#workgroup-table tbody').on('click', 'tr', function () {
                //make selected row effect
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                }
                else {
                    tableWg.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
                //send data to Workgroup Detail when selecting row
                let data = tableWg.row(this).data();
                let urlAjax = "/hr/workgroup-detail?workgroup=" + data.workgroup;
                if ( $.fn.DataTable.isDataTable('#workgroup-detail-table') ) {
                    $('#workgroup-detail-table').DataTable().ajax.url(urlAjax).load();
                }
            });

            $('#create-wg').click(function () {
                $('#saveBtn').val("create-workgroup");
                $('#workgroupForm').trigger("reset");
                $("#workgroupModal").find('#modalTitle').html("Add new Working Group data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#workgroupForm').find('#fshiftrolling').attr('readonly', false);
                $('#workgroupForm').find('#frangerolling').attr('readonly', false);
                $('#workgroupForm').find('#fworkgroup').attr('disabled', false);

                showCreateModal ('Add New Workgroup', inputFormId, actionUrl, '#workgroupModal');
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

                $('#fworkgroup').attr('disabled', true);
                $('#fworkgroup').val(data.workgroup);
                $('#fworkname').val(data.workname);

                $('#fshiftstatus').find('option').removeAttr('selected');
                $('#fshiftstatus').find('option[value="' + data.shiftstatus.value + '"]').attr('selected', '');
                //if Non shift
                let shiftstatus = $('#fshiftstatus').val();
                if (shiftstatus == 'N'){
                    $('#fshiftrolling').val(1);
                    $('#frangerolling').val(0);
                    $('#fshiftrolling').attr('readonly', true);
                    $('#frangerolling').attr('readonly', true);
                }

                let shiftvalue = $('#fshiftstatus').val();
                if (shiftvalue == 'Y'){
                    $('#frangerolling').attr('readonly', false);
                    $('#fshiftrolling').attr('readonly', false);
                }

                $('#fshiftrolling').val(data.shiftrolling);
                $('#frangerolling').val(data.rangerolling.value);
                $('#froundtime').val(data.roundtime.value);

                $('#fworkfinger').find('option').removeAttr('selected');
                $('#fworkfinger').find('option[value="' + data.workfinger.value + '"]').attr('selected', '');
                $('#frestfinger').find('option').removeAttr('selected');
                $('#frestfinger').find('option[value="' + data.restfinger.value + '"]').attr('selected', '');

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

            $(inputFormId).on('submit', function (event) {
                submitButtonProcessDynamic (tableId, inputFormId, '#workgroupModal');
            });

        });

    </script>
@endpush
