@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/accounting/chart-of-account';
    var tableId = '#chart-of-account-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        searchDelay: 1500,
        pageLength: 50,
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('accounting.chart-of-account.index') }}",
        },
        columns: [
            { data: 'code', defaultContent: '-' },
            { data: 'name', defaultContent: '-' },
            { data: 'chart_of_account.name', defaultContent: '-' },
            { data: 'chart_of_account_class.name', defaultContent: '-' },
            { data: 'chart_of_account_class.position', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'status', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'updater_name', defaultContent: '-' },
            { data: 'updated_at', defaultContent: '-' },
            { data: 'action', orderable: false },
        ]
    });

    $('.parent_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Parent',
        allowClear: true,
        ajax: {
            url: "{{ route('accounting.chart-of-account.select2.parent') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $(".chart_of_account_class_id").prop("disabled", false);
    $('.parent_id').on('select2:select', function (e) {
        if($('.parent_id').val() == null) {
            $(".chart_of_account_class_id").prop("disabled", false);
        }
        else {
            $(".chart_of_account_class_id").prop("disabled", true);
            $(".info-chart_of_account_class_id").append('<i class="fa fa-info-circle"></i>&nbsp;if you choose parent, class will be same with parent');
        }
        
    });

    $('.parent_id').on('select2:clearing', function (e) {
        $(".chart_of_account_class_id").prop("disabled", false);
        $(".info-chart_of_account_class_id").html('');
    });

    $('.chart_of_account_class_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Class',
        allowClear: true,
        ajax: {
            url: "{{ route('accounting.chart-of-account-class.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('#create').click(function () {
        showCreateModal ('Create New COA Group', inputFormId, actionUrl);

        $(".parent_id").val(null).trigger('change');
        $(".chart_of_account_class_id").prop("disabled", false);
        $(".chart_of_account_class_id").val(null).trigger('change');
        $(".info-chart_of_account_class_id").html('');
    });

    datatableObject.on('click', '.editBtn', function () {
        $('#modalTitle').html("Edit COA Group");
        $(inputFormId).trigger("reset");                
        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject.row(tr).data();
        $(inputFormId).attr('action', actionUrl + '/' + data.id);

        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo('#inputForm');

        $('#code').val(data.code);
        $('#name').val(data.name);

        $(".parent_id").val(null).trigger('change');
        if (data.chart_of_account != null) {
            $('#parent_id').append('<option value="' + data.parent_id + '" selected>' + data.chart_of_account.name + '</option>');

            $(".chart_of_account_class_id").prop("disabled", true);
            $(".info-chart_of_account_class_id").append('<i class="fa fa-info-circle"></i>&nbsp;if you choose parent, class will be same with parent');
        }  

        $(".chart_of_account_class_id").val(null).trigger('change');
        if (data.chart_of_account_class_id != null) {
            $('#chart_of_account_class_id').append('<option value="' + data.chart_of_account_class_id + '" selected>' + data.chart_of_account_class.name + '</option>');
        }   

        $('#description').val(data.description);                
        if (data.status == '<label class="label label-success">Active</label>') {
            $('#status').prop('checked', true);
        }
        else {
            $('#status').prop('checked', false);
        }

        $('#saveBtn').val("edit");
        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $(".info-chart_of_account_class_id").html('');
        $('#inputModal').modal('show');
    });

    $(inputFormId).on('submit', function (event) {
        submitButtonProcess (tableId, inputFormId); 
    });

    deleteButtonProcess (datatableObject, tableId, actionUrl);
});
</script>
@endpush