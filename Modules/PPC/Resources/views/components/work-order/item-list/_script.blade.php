@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = '/ppc/maintenance-program-detail';
    var tableId = '#item-table';
    var inputFormId = '#inputForm';
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //
});
</script>
@endpush