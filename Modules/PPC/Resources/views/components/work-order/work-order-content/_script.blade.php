@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '{{ route("ppc.work-order.index") }}';
    var inputFormId = '#inputForm';



    // ----------------- "APPROVE" BUTTON SCRIPT ------------- //
    $('.approveBtn').on('click', function () {
        rowId = $(this).val();
        $('#approve-form').trigger("reset");
        $('#approveModal').modal('show');
        $('#approve-form').attr('action', actionUrl + '/' + rowId + '/approve');
    });

    $('#approve-form').on('submit', function (e) {
        e.preventDefault();
        let url_action = $(this).attr('action');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $(
                    'meta[name="csrf-token"]'
                ).attr("content")
            },
            url: url_action,
            type: "POST",
            data: $('#approve-form').serialize(),
            dataType: 'json',
            beforeSend:function(){
                $('#approve-button').text('Approving...');
                $('#approve-button').prop('disabled', true);
            },
            error: function(data){
                if (data.error) {
                    generateToast ('error', data.error);
                }
            },
            success:function(data){
                if (data.error) {
                    generateToast ('error', data.error);
                }
                if (data.success){
                    generateToast ('success', data.success);
                }
                setTimeout(location.reload.bind(location), 2000);
            },
            complete: function(data) {
                $('#approve-button').text('Approve');
                $('#approveModal').modal('hide');
                $('#approve-button').prop('disabled', false);
                $(targetTableId).DataTable().ajax.reload();
            }
        });
    });
    // ----------------- END "APPROVE" BUTTON SCRIPT ------------- //
});
</script>
@endpush