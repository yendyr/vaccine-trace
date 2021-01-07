@push('footer-scripts')
<script>
    $(document).ready(function () {
        var table = $('#taskcard-type-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('ppc.taskcard-type.index')}}",
            },
            columns: [
                { data: 'code', name: 'Code'  },
                { data: 'name', name: 'Task Card Type Name' },
                { data: 'description', name: 'Description/Remark' },
                { data: 'status', name: 'Status' },
                { data: 'action', name: 'Action', orderable: false },
            ]
        });

        var companyId;
        table.on('click', '.delete', function () {
            taskcardTypeId = $(this).attr('id');
            $('#deleteModal').modal('show');
            $('#delete-form').attr('action', "taskcard-type/"+ taskcardTypeId);
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
                    $('#taskcard-type-table').DataTable().ajax.reload();
                }
            });
        });
    });
</script>
@endpush