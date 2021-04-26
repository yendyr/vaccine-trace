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
                    { data: 'empid', defaultContent: '-' },
                    { data: 'workdate', defaultContent: '-' },
                    { data: 'attdtype', defaultContent: '-' },
                    { data: 'timestart', defaultContent: '-' },
                    { data: 'datestart', defaultContent: '-' },
                    { data: 'timefinish', defaultContent: '-' },
                    { data: 'datefinish', defaultContent: '-' },
                    { data: 'processedon', defaultContent: '-' },
                    { data: 'mainattd', defaultContent: '-' },
                    { data: 'caldatestart', defaultContent: '-' },
                    { data: 'caltimestart', defaultContent: '-' },
                    { data: 'caldatefinish', defaultContent: '-' ,
                    { data: 'caltimefinish', defaultContent: '-' },
                    { data: 'status', defaultContent: '-' },
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
