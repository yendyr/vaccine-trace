@include('components.toast.script-generate')

@push('footer-scripts')
    <script>
        $(document).ready(function () {
            var rowId;

            var table = $('#skill-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('qualityassurance.skill.index') }}",
                },
                columns: [
                    { data: 'code', name: 'Code'  },
                    { data: 'name', name: 'Skill Name' },
                    { data: 'description', name: 'Description/Remark' },
                    { data: 'status', name: 'Status' },
                    { data: 'created_by', name: 'Created By' },
                    { data: 'created_at', name: 'Created At' },
                    { data: 'updated_by', name: 'Last Updated By' },
                    { data: 'updated_at', name: 'Last Updated At' },
                    { data: 'action', name: 'Action', orderable: false },
                ]
            });

            $('#create').click(function () {
                $('#modalTitle').html("Create New Skill");
                $('#inputForm').attr('action', '/qualityassurance/skill');
                $('#saveBtn').val("create");
                $('#inputForm').trigger("reset");
                $('[class^="invalid-feedback-"]').html('');
                $('#inputModal').modal('show');                
                $("input[value='patch']").remove();
            });

            table.on('click', '.editBtn', function () {
                $('#modalTitle').html("Edit Skill");
                $('#inputForm').trigger("reset");                
                rowId= $(this).val();
                let tr = $(this).closest('tr');
                let data = table.row(tr).data();
                $('#inputForm').attr('action', '/qualityassurance/skill/' + data.id);

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#inputForm');

                $('#code').val(data.code);
                $('#name').val(data.name);
                $('#description').val(data.description);                
                if (data.status == '<label class="label label-success">Active</label>') {
                    $('#status').prop('checked', true);
                }
                else {
                    $('#status').prop('checked', false);
                }

                $('#saveBtn').val("edit");
                $('[class^="invalid-feedback-"]').html('');
                $('#inputModal').modal('show');
            });

            $('#inputForm').on('submit', function (event) {
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
                        $('#saveBtn'). prop('disabled', true);
                    },
                    error: function(data){
                        let errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function (index, value) {
                                $('div.invalid-feedback-'+index).html(value);
                            })
                        }
                    },
                    success: function (data) {
                        if (data.success) {
                            generateToast ('success', data.success);                            
                        }
                        $('#inputModal').modal('hide');
                        $('#skill-table').DataTable().ajax.reload();
                    },
                    complete: function () {
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'stop' );
                        $('#saveBtn'). prop('disabled', false);
                    }
                });
            });

            table.on('click', '.deleteBtn', function () {
                rowId = $(this).val();
                $('#deleteModal').modal('show');
                $('#delete-form').attr('action', "/qualityassurance/skill/"+ rowId);
            });

            $('#delete-form').on('submit', function (e) {
                e.preventDefault();
                let url_action = $(this).attr('action');
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $(
                            'meta[name="csrf-token"]'
                        ).attr("content")
                    },
                    url: url_action,
                    type: "DELETE", //bisa method
                    beforeSend:function(){
                        $('#delete-button').text('Deleting...');
                        $('#delete-button').prop('disabled', true);
                    },
                    error: function(data){
                        if (data.error) {
                            generateToast ('error', data.error);
                        }
                    },
                    success:function(data){
                        if (data.success){
                            generateToast ('success', data.success);
                        }
                    },
                    complete: function(data) {
                        $('#delete-button').text('Delete');
                        $('#deleteModal').modal('hide');
                        $('#delete-button').prop('disabled', false);
                        $('#skill-table').DataTable().ajax.reload();
                    }
                });
            });
        });
    </script>
@endpush