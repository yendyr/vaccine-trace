@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/ppc/job-card';
    var tableId = '#job-card-table';
    var inputFormId = '#execute-form';
    var inputModalId = '#inputModal';

    $('.executeBtn').click(function () {
        var detail_id = $(this).val();
        var actionHref = $(this).attr('href');
        var next_status = $(this).data('next-status');
        $('#modalTitle').html("Execute Job Card");
        $('.job-card-modal-icon').removeClass("fa-pause fa-stop text-warning text-danger").addClass("fa-play text-success");
        $('#saveBtn').html('Execute Job Card').removeClass('btn-danger btn-warning').addClass('btn-primary');
        
        showExecuteModal(actionHref, next_status, detail_id);
    });

    $('.resumeBtn').click(function () {
        var detail_id = $(this).val();
        var actionHref = $(this).attr('href');
        var next_status = $(this).data('next-status');
        $('#modalTitle').html("Resume Job Card");
        $('.job-card-modal-icon').removeClass("fa-pause fa-stop text-warning text-danger").addClass("fa-play text-success");
        $('#saveBtn').html('Resume Job Card').removeClass('btn-danger btn-warning').addClass('btn-primary');
        
        showExecuteModal(actionHref, next_status, detail_id);
    });

    $('.pauseBtn').click(function () {
        var detail_id = $(this).val();
        var actionHref = $(this).attr('href');
        var next_status = $(this).data('next-status');
        $('#modalTitle').html("Pause Job Card");
        $('.job-card-modal-icon').removeClass("fa-play fa-stop text-success text-danger").addClass("fa-pause text-warning");
        $('#saveBtn').html('Pause Job Card').removeClass('btn-primary btn-danger').addClass('btn-warning');
        
        showExecuteModal(actionHref, next_status, detail_id);
    });

    $('.closeBtn').click(function () {
        var detail_id = $(this).val();
        var actionHref = $(this).attr('href');
        var next_status = $(this).data('next-status');
        $('#modalTitle').html("Close Job Card");
        $('.job-card-modal-icon').removeClass("fa-play fa-pause text-success text-warning").addClass("fa-stop text-danger");
        $('#saveBtn').html('Close Job Card').removeClass('btn-primary btn-warning').addClass('btn-danger');
        
        showExecuteModal(actionHref, next_status, detail_id);
    });

    function showExecuteModal(actionHref, next_status, detail_id){
        $(inputFormId).attr('action', actionHref);
        if( $("input[name=_method]").length == 0 ){
            $('<input>').attr({
                type: 'hidden',
                name: '_method',
                value: 'patch'
            }).prependTo(inputFormId);
        } else {
            $("input[name=_method]").val('patch');
        }         
        $("input[name=next_status][type=hidden]").val(next_status);
        $("input[name=detail_id][type=hidden]").val(detail_id);

        $('#saveBtn').val("execute");
        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        
        $(inputModalId).modal('show');
        $(inputFormId).find('input[type="text"]').val(null);
    }

    $(inputFormId).on('submit', function (event) {
        submitButtonProcess (null, inputFormId); 
    });
});
</script>
@endpush