@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
    <script>
        function getFamid(empid){
            let empidVal = empid.value;

            $('#ffamidAddress').val(null).trigger('change');
            $('#addressForm').find('.select2_famidAddress').select2({
                theme: 'bootstrap4',
                placeholder: 'choose Emp ID first',
                ajax: {
                    url: "{{route('hr.address.select2.famid')}}",
                    data: {
                        empid: empidVal
                    },
                    dataType: 'json',
                    language: {
                        noResults: function (params) {
                            return "Please select Emp ID first";
                        }
                    }
                },
                dropdownParent: $('#addressModal')
            });
        }

        $(document).ready(function () {
            var actionUrl = '/hr/address';
            var tableId = '#address-table';
            var inputFormId = '#addressForm';

            var tableAddress = $('#address-table').DataTable({
                processing: true,
                serverSide: false,
                searchDelay: 1500,
                language: {
                    emptyTable: "No data existed",
                },
                ajax: {
                    url: "/hr/address",
                    type: "GET",
                    dataType: "json",
                },
                columns: [
                    { data: 'empid', name: 'empid' },
                    { data: 'famid', name: 'famid', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'addrid', name: 'addrid', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'street', name: 'street', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'area', name: 'area', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'city', name: 'city', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'state', name: 'state', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'country', name: 'country', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'postcode', name: 'postcode', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'telephone.content', name: 'telephone.content', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'remark', name: 'remark', defaultContent: "<p class='text-muted'>none</p>" },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false },
                ]
            });

            $('#addressForm').find('.select2_empidAddress').select2({
                theme: 'bootstrap4',
                placeholder: 'choose Emp ID',
                ajax: {
                    url: "{{route('hr.employee.select2.empid')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#addressModal')
            });

            $('#create-address').click(function () {
                $('#saveBtn').val("create-address");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $("input[value='patch']").remove();
                $('#ffamidAddress').attr('disabled', false);
                $('#ffamidAddress').val(null).trigger('change');
                $('#fempidAddress').attr('disabled', false);
                $('#fempidAddress').val(null).trigger('change');
                $('#faddrid').attr('disabled', false);
                showCreateModal ('Add New Address data', inputFormId, actionUrl, '#addressModal');
            });

            tableAddress.on('click', '.editBtn', function () {
                $('#addressForm').trigger("reset");
                $('#addressModal').find('#modalTitle').html("Update Id Card data");
                let tr = $(this).closest('tr');
                let data = $('#address-table').DataTable().row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#addressForm');

                $('#fempidAddress').attr('disabled', true);
                $('#fempidAddress').append('<option value="' + data.empid + '" selected>' + data.empid + '</option>');
                $('#ffamidAddress').attr('disabled', true);
                $('#ffamidAddress').append('<option value="' + data.famid + '" selected>' + data.famid + '</option>');
                $('#faddrid').attr('disabled', true);
                $('#faddrid').val(data.addrid);

                $('#addressForm').find('#fstreet').val(data.street);
                $('#addressForm').find('#farea').val(data.area);
                $('#addressForm').find('#fcity').val(data.city);
                $('#addressForm').find('#fstate').val(data.state);
                $('#addressForm').find('#fcountry').val(data.country);
                $('#addressForm').find('#fpostcode').val(data.postcode);
                $('#addressForm').find('#ftel01').val(data.tel01);
                $('#addressForm').find('#ftel02').val(data.tel02);
                $('#addressForm').find('#fremark').val(data.remark);

                $("#addressForm").find('#fstatus').find('option').removeAttr('selected');
                if (data.status == '<p class="text-success">Active</p>'){
                    $("#addressForm").find('#fstatus').find('option[value="1"]').attr('selected', '');
                }else{
                    $("#addressForm").find('#fstatus').find('option[value="0"]').attr('selected', '');
                }

                $('#saveBtn').val("edit-address");
                $('#addressForm').attr('action', '/hr/address/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#addressModal').modal('show');
            });

            $(inputFormId).on('submit', function (event) {
                submitButtonProcessDynamic (tableId, inputFormId, '#addressModal');
            });
        });

    </script>
@endpush
