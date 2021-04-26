@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
    <script>
        $(document).ready(function () {
            var tableWHourAttd = $('#whour-attendance-table').DataTable({
                processing: false,
                serverSide: false,
                searchDelay: 1500,
                language: {
                    emptyTable: "No data existed for working hour attendance",
                },
                height: 180,
                ajax: {
                    url: "/hr/working-hour-attendance",
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
                    { data: 'validateon', defaultContent: '-' },
                    { data: 'processedon', defaultContent: '-' },
                    { data: 'rndatestart', defaultContent: '-' },
                    { data: 'rntimestart', defaultContent: '-' },
                    { data: 'rndatefinish', defaultContent: '-' },
                    { data: 'rntimefinish', defaultContent: '-' },
                    { data: 'status', defaultContent: '-' },
                ]
            });

            $('#whour-table').on('click', '.editBtn', function () {
                $('#whourForm').trigger("reset");
                $('#whourModal').find('#modalTitle').html("Update Working Hour Attendance data");
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

        })

    </script>
@endpush
