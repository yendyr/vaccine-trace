@push('header-scripts')
    <style>
        .select2-container.select2-container--default.select2-container--open {
            z-index: 9999999 !important;
        }
        .select2{
            width: 100% !important;
        }

    </style>
@endpush

@push('footer-scripts')
    <script>
        var tableAddress = $('#address-table').DataTable({
            processing: true,
            serverSide: false,
            scrollX: true,
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

        function getFamid(empid){
            let empidVal = empid.value;

            $('#ffamidAddress').val(null).trigger('change');
            $('#addressForm').find('.select2_famidAddress').select2({
                placeholder: 'choose famid',
                ajax: {
                    url: "{{route('hr.address.select2.famid')}}",
                    data: {
                        empid: empidVal
                    },
                    dataType: 'json',
                },
                dropdownParent: $('#addressModal')
            });
        }

        $(document).ready(function () {
            $('#addressForm').find('.select2_empidAddress').select2({
                placeholder: 'choose empid',
                ajax: {
                    url: "{{route('hr.employee.select2.empid')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#addressModal')
            });

            $('#create-address').click(function () {
                $('#saveBtn').val("create-address");
                $('#addressForm').trigger("reset");
                $("#addressModal").find('#modalTitle').html("Add new Address data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback

                $('#addressModal').modal('show');
                $("input[value='patch']").remove();
                $('#ffamidAddress').attr('disabled', false);
                $('#ffamidAddress').val(null).trigger('change');
                $('#fempidAddress').attr('disabled', false);
                $('#fempidAddress').val(null).trigger('change');
                $('#faddrid').attr('disabled', false);
                $('#addressForm').attr('action', '/hr/address');
            });

            $('#address-table').on('click', '.editBtn', function () {
                $('#addressForm').trigger("reset");
                $('#addressModal').find('#modalTitle').html("Update Id Card data");
                let tr = $(this).closest('tr');
                let data = $('#address-table').DataTable().row(tr).data();
                console.log(data);
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

            $('#addressForm').on('submit', function (event) {
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
                        $("#addressForm").find('#saveBtn').prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            $("#ibox-address").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $("#ibox-address").find('#form_result').html(data.success);
                        }
                        $('#addressModal').modal('hide');
                        tableAddress.ajax.reload();
                    },
                    error:function(data){
                        let errors = data.responseJSON.errors;
                        $("#addressForm").find('#saveBtn').prop('disabled', false);
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'stop' );
                        if (errors) {
                            $.each(errors, function (index, value) {
                                $('div.invalid-feedback-'+index).html(value);
                            })
                        }
                    },
                    complete:function(){
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'stop' );
                        $("#addressForm").find('#saveBtn').prop('disabled', false);
                    }
                });
            });
        });

    </script>
@endpush
