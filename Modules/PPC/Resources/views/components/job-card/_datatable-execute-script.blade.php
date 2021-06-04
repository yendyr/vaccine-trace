@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/ppc/job-card';
    var tableId = '#job-card-table';
    var inputFormId = '#execute-form';
    var inputModalId = '#inputModal';

    $("#job-card-table").on('click', '.executeBtn', function () {
        var detail_id = $(this).val();
        var actionHref = $(this).attr('href');
        var next_status = $(this).data('next-status');
        $('#modalTitle').html("Execute Confirmation");
        $('.job-card-modal-icon').removeClass("fa-pause fa-stop fa-check text-warning text-danger").addClass("fa-play text-success");
        $('#saveBtn').html('Execute Job Card').removeClass('btn-danger btn-warning').addClass('btn-primary');

        if(detail_id) {
            $(".text-notes").text("This Action Will Execute Instruction");
        }else{
            $(".text-notes").text("This Action Will Execute all Detailed Instructions in this Taskcard");
        }

        $(".input-notes").hide();
        $("#notes").attr("required", false);
        
        
        showExecuteModal(actionHref, next_status, detail_id);
    });

    $("#job-card-table").on('click', '.resumeBtn', function () {
        var detail_id = $(this).val();
        var actionHref = $(this).attr('href');
        var next_status = $(this).data('next-status');
        $('#modalTitle').html("Resume Confirmation");
        $('.job-card-modal-icon').removeClass("fa-pause fa-stop fa-check text-warning text-danger").addClass("fa-play text-success");
        $('#saveBtn').html('Resume Job Card').removeClass('btn-danger btn-warning').addClass('btn-primary');
        
        if(detail_id) {
            $(".text-notes").text("This Action Will Execute Instruction");
        }else{
            $(".text-notes").text("This Action Will Execute all Detailed Instructions in this Taskcard");
        }

        $(".input-notes").hide();
        $("#notes").attr("required", false);

        showExecuteModal(actionHref, next_status, detail_id);
    });

    $("#job-card-table").on('click', '.releaseBtn', function () {
        var detail_id = $(this).val();
        var actionHref = $(this).attr('href');
        var next_status = $(this).data('next-status');
        $('#modalTitle').html("Release Confirmation");
        $('.job-card-modal-icon').removeClass("fa-pause fa-stop fa-play text-warning text-danger").addClass("fa-check text-info");
        $('#saveBtn').html('Release Job Card').removeClass('btn-danger btn-warning').addClass('btn-info');
        $(".text-notes").text("Please Enter a Description of the Release Jobcard");
        $(".input-notes").show("slow");
        $("#notes").attr("required", true);

        showExecuteModal(actionHref, next_status, detail_id);
    });

    $("#job-card-table").on('click', '.pauseBtn', function () {
        var detail_id = $(this).val();
        var actionHref = $(this).attr('href');
        var next_status = $(this).data('next-status');
        $('#modalTitle').html("Pause Confirmation");
        $('.job-card-modal-icon').removeClass("fa-play fa-stop fa-check text-success text-danger").addClass("fa-pause text-warning");
        $('#saveBtn').html('Pause Job Card').removeClass('btn-primary btn-danger').addClass('btn-warning');
        $(".text-notes").text("Please Enter a Description of the Pending Jobcard");
        $(".input-notes").show("slow");
        $("#notes").attr("required", true);

        showExecuteModal(actionHref, next_status, detail_id);
    });

    $("#job-card-table").on('click', '.closeBtn', function () {
        var detail_id = $(this).val();
        var actionHref = $(this).attr('href');
        var next_status = $(this).data('next-status');
        $('#modalTitle').html("Close Confirmation");
        $('.job-card-modal-icon').removeClass("fa-play fa-pause fa-check text-success text-warning").addClass("fa-stop text-danger");
        $('#saveBtn').html('Close Job Card').removeClass('btn-primary btn-warning').addClass('btn-danger');
        $(".text-notes").text("Please Enter a Description of the Closing Jobcard");
        $(".input-notes").show("slow");
        $("#notes").attr("required", true);

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