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
        var is_id = $(this).val();
        var actionHref = $(this).attr('href');
        
        showExecuteModal(actionHref);
    });

    function showExecuteModal(actionHref){

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