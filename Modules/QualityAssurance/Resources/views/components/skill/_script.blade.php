@push('footer-scripts')
    <script>
        $(document).ready(function () {
            var skillId;

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

            $('#createSkill').click(function () {
                $('#saveBtn').val("create-skill");
                $('#skillForm').trigger("reset");
                $('#modalTitle').html("Create New Skill Type");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#skillModal').modal('show');
                $('#skillForm').attr('action', '/qualityassurance/skill');
                $("input[value='patch']").remove();
            });

            table.on('click', '.editBtn', function () {
                $('#skillForm').trigger("reset");
                $('#modalTitle').html("Edit Skill");
                skillId= $(this).val();
                let tr = $(this).closest('tr');
                let data = table.row(tr).data();

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'patch'
                }).prependTo('#skillForm');

                $('#code').val(data.code);
                $('#name').val(data.name);
                $('#description').val(data.description);                
                if (data.status == '<label class="label label-success">Active</label>') {
                    $('#status').prop('checked', true);
                }
                else {
                    $('#status').prop('checked', false);
                }

                $('#saveBtn').val("edit-skill");
                $('#skillForm').attr('action', '/qualityassurance/skill/' + data.id);

                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $('#skillModal').modal('show');
            });

            $('#skillForm').on('submit', function (event) {
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
                            $('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $('#form_result').html(data.success);
                        }
                        $('#skillModal').modal('hide');
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
                skillId = $(this).val();
                $('#deleteModal').modal('show');
                $('#delete-form').attr('action', "/qualityassurance/skill/"+ skillId);
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
                            $('#form_result').attr('class', 'alert alert-danger fade show font-weight-bold');
                            $('#form_result').html(data.error);
                        }
                    },
                    success:function(data){
                        if (data.success){
                            $('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $('#form_result').html(data.success);
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