@push('footer-scripts')
    <script>
        var tableAttd = $('#attendance-table').DataTable({
            processing: false,
            serverSide: false,
            scrollX: true,
            language: {
                emptyTable: "No data existed for working hour attendance",
            },
            height: 180,
            ajax: {
                url: "/hr/attendance",
                type: "GET",
                dataType: "json",
            },
            columns: [
                { data: 'empid', name: 'empid' },
                { data: 'attdtype', name: 'attdtype', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'attddate', name: 'attddate', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'attdtime', name: 'attdtime', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'deviceid', name: 'deviceid', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'inputon', name: 'inputon', defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'status', name: 'status' },
            ]
        });

        $('#whour-table').on('click', '.editBtn', function () {
            $('#whourForm').trigger("reset");
            $('#whourModal').find('#modalTitle').html("Update Working Group data");
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

        $('#whourDetailForm').on('submit', function (event) {
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
                    $("#whourForm").find('#saveBtn').prop('disabled', true);
                },
                success:function(data){
                    if (data.success) {
                        $("#ibox-whour").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                        $("#ibox-whour").find('#form_result').html(data.success);
                    }
                    $('#whourModal').modal('hide');
                    $('#whour-table').DataTable().ajax.reload();
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
                    let l = $( '.ladda-button-submit' ).ladda();
                    l.ladda( 'stop' );
                    $("#whourForm").find('#saveBtn').prop('disabled', false);
                }
            });
        });

    </script>
@endpush
