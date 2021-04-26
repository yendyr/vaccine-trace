@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('header-scripts')
    <link href="{{URL::asset('theme/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
    <link href="{{URL::asset('theme/css/plugins/daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet">
@endpush
@push('footer-scripts')
    <!-- Date range picker -->
    <script src="{{URL::asset('theme/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{URL::asset('theme/js/plugins/daterangepicker/daterangepicker.js')}}"></script>

    <script>
        $(document).ready(function () {
            var actionUrl = '/hr/working-hour';
            var tableId = '#whour-table';
            var inputFormId = '#whourForm';

            var tableWHour = $('#whour-table').DataTable({
                processing: false,
                serverSide: false,
                searchDelay: 1500,
                language: {
                    emptyTable: "No data existed for working hour",
                },
                height: 180,
                ajax: {
                    url: "/hr/working-hour",
                    type: "GET",
                    dataType: "json",
                },
                columns: [
                    { data: 'empid', defaultContent: '-' },
                    { data: 'workdate', defaultContent: '-' },
                    { data: 'shiftno', defaultContent: '-' },
                    { data: 'whtimestart', defaultContent: '-' },
                    { data: 'whdatestart', defaultContent: '-' },
                    { data: 'whtimefinish', defaultContent: '-' },
                    { data: 'whdatefinish', defaultContent: '-' },
                    { data: 'rstimestart', defaultContent: '-' },
                    { data: 'rsdatestart', defaultContent: '-' },
                    { data: 'rstimefinish', defaultContent: '-' },
                    { data: 'rsdatefinish', defaultContent: '-' },
                    { data: 'stdhours.content', defaultContent: '-' },
                    { data: 'minhours.content', defaultContent: '-' },
                    { data: 'worktype.content', defaultContent: '-' },
                    { data: 'workstatus', defaultContent: '-' },
                    { data: 'processedon', defaultContent: '-' },
                    { data: 'leavehours', defaultContent: '-' },
                    { data: 'attdhours', defaultContent: '-' },
                    { data: 'overhours', defaultContent: '-' },
                    { data: 'attdstatus', defaultContent: '-' },
                    { data: 'status', defaultContent: '-' },
                    // { data: 'action', name: 'action', orderable: false },
                ]
            });

            $('#data-daterange .input-daterange').datepicker({
                locale: {
                    format: 'dd-mm-yyyy'
                },
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            $('#whourForm').find('.select2_empidWhour').select2({
                theme: 'bootstrap4',
                placeholder: 'choose Emp ID',
                ajax: {
                    url: "{{route('hr.workhour.select2.empid')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#whourModal')
            });

            $('#create-whour, #calculate-whour').click(function () {
                $('#saveBtn').val("create-whour");
                $('#whourForm').trigger("reset");
                $("#whourModal").find('#modalTitle').html("Generate new Working Hour data");
                $('[class^="invalid-feedback-"]').html('');
                $("#fempidWhour").attr("disabled", false);
                $(".select2_empidWhour").val(null).trigger('change');

                showCreateModal ('Add New Workhour', inputFormId, actionUrl, '#whourModal');
            });

            $('#whour-table').on('click', '.editBtn', function () {
                $('#whourForm').trigger("reset");
                $('#whourModal').find('#modalTitle').html("Update Working Hour data");
                let tr = $(this).closest('tr');
                let data = $(tableId).DataTable().row(tr).data();

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

            $(inputFormId).on('submit', function (event) {
                submitButtonProcessDynamic (tableId, inputFormId, '#whourModal');
            });
        });

    </script>
@endpush
