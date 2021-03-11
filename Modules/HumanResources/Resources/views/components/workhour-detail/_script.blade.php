@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
    <script>
        $(document).ready(function () {
            var tableWHourDetail = $('#whour-detail-table').DataTable({
                processing: false,
                serverSide: false,
                searchDelay: 1500,
                language: {
                    emptyTable: "No data existed for working hour detail",
                },
                height: 180,
                ajax: {
                    url: "/hr/working-hour-detail",
                    type: "GET",
                    dataType: "json",
                },
                columns: [
                    { data: 'empid', name: 'empid' },
                    { data: 'workdate', name: 'workdate' },
                    { data: 'attdtype', name: 'attdtype' },
                    { data: 'timestart', name: 'timestart', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'datestart', name: 'datestart', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'timefinish', name: 'timefinish', defaultContent: "<p class='text-muted'>none</p>"},
                    { data: 'datefinish', name: 'datefinish', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'processedon', name: 'processedon', defaultContent: "<p class='text-muted'>none</p>"},
                    { data: 'mainattd', name: 'mainattd', defaultContent: "<p class='text-muted'>none</p>"},
                    { data: 'caldatestart', name: 'caldatestart', defaultContent: "<p class='text-muted'>none</p>"},
                    { data: 'caltimestart', name: 'caltimestart', defaultContent: "<p class='text-muted'>none</p>"},
                    { data: 'caldatefinish', name: 'caldatefinish', defaultContent: "<p class='text-muted'>none</p>"},
                    { data: 'caltimefinish', name: 'caltimefinish', defaultContent: "<p class='text-muted'>none</p>"},
                    { data: 'status', name: 'status' },
                ]
            });

            $('#whour-table').on('click', '.editBtn', function () {
                $('#whourForm').trigger("reset");
                $('#whourModal').find('#modalTitle').html("Update Working Hour Detail data");
                let tr = $(this).closest('tr');
                let data = $('#whour-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#whourForm');

                $('#fempidWhour').attr('disabled', true);
                $('#fempidWhour').append('<option value="' + data.empid + '" selected>' + data.empid + '</option>');

                $('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-workgroup-detail");
                $('#whourForm').attr('action', '/hr/workgroup-detail/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                // $('#whourModal').modal('show');
            });

            // $(inputFormId).on('submit', function (event) {
            //     submitButtonProcessDynamic ('#whour-detail-table', '#whourDetailForm', '#whourDetailModal');
            // });

        })

    </script>
@endpush
