@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/procurement/purchase-requisition-detail';
    var tableId = '#purchase-requisition-detail-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        order: [ 8, "asc" ],
        ajax: {
            url: "/procurement/purchase-requisition-detail/?id=" + "{{ $PurchaseRequisition->id }}",
        },
        columns: [
            { data: 'item.code', defaultContent: '-' },
            { data: 'item.name', defaultContent: '-' },
            { data: 'item.category.name', defaultContent: '-' },
            { data: 'parent', defaultContent: '-' },
            { data: 'request_quantity', defaultContent: '-' },
            { data: 'available_stock',
                "render": function ( data, type, row, meta ) {
                    if (row.available_stock > 0) {
                        return "<span class='label label-success'>" + row.available_stock + '</span>';
                    }
                    else {
                        return "<span class='label label-danger'>" + row.available_stock + '</span>';
                    } 
                }},
            { data: 'item.unit.name', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            // { data: 'status', name: 'Status' },
            // { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'action', orderable: false },
        ]
    });


    

    $('.item_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Item',
        minimumInputLength: 3,
        minimumResultsForSearch: 10,
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.item.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });
        
    $('.parent_coding').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Parent Item',
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        allowClear: true,
        ajax: {
            url: "{{ route('procurement.purchase-requisition-detail.select2') }}",
            dataType: 'json',
            data: function (params) {
                var getHeaderId = { 
                    term: params.term,
                    purchase_requisition_id: "{{ $PurchaseRequisition->id }}",
                }
                return getHeaderId;
            }
        },
        dropdownParent: $('#inputModal')
    });






    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $('#create').click(function () {
        showCreateModal ('Add New Item/Component', inputFormId, actionUrl);
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //






    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    datatableObject.on('click', '.editBtn', function () {
        clearForm(inputFormId);

        $('#modalTitle').html("Edit Item/Component");
        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject.row(tr).data();
        $(inputFormId).attr('action', actionUrl + '/' + data.id);

        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo('#inputForm');

        $('#quantity').val(data.request_quantity);
        $('#description').val(data.description);

        if (data.item != null) {
            $('#item_id').append('<option value="' + data.item_id + '" selected>' + data.item.code + ' | ' + data.item.name + '</option>');
        }

        if (data.item_group != null) {
            $('.parent_coding').append('<option value="' + data.parent_coding + '" selected>' + data.item_group.item.code + ' | ' + data.item_group.item.name + '</option>');
        }   

        // if($('#quantity').val() > 1) {
        //     $('#serial_number').val(null);
        //     $('#serial_number').prop('disabled', true);
        // }
        // else {
        //     $('#serial_number').prop('disabled', false);
        // }

        // if (data.status == '<label class="label label-success">Active</label>') {
        //     $('#status').prop('checked', true);
        // }
        // else {
        //     $('#status').prop('checked', false);
        // }

        $('#saveBtn').val("edit");
        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $('#inputModal').modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //




    $(inputFormId).on('submit', function (event) {
        submitButtonProcess (tableId, inputFormId); 
    });






    deleteButtonProcess (datatableObject, tableId, actionUrl);







    // -------------------- FRONT-END LEVEL VALIDATION ----------------------------- //
    // $("#quantity").on('change', function () {
    //     if($('#quantity').val() > 1) {
    //         $('#serial_number').val(null);
    //         $('#serial_number').prop('disabled', true);
    //     }
    //     else {
    //         $('#serial_number').prop('disabled', false);
    //     }            
    // });

    // $(".parent_coding").on('change', function () {
    //     if($('.parent_coding').val() != null) {
    //         $('#detailed_item_location').val(null);
    //         $('#detailed_item_location').prop('disabled', true);
    //     }
    //     else {
    //         $('#detailed_item_location').prop('disabled', false);
    //     }            
    // });
    // -------------------- END FRONT-END LEVEL VALIDATION ----------------------------- //
});
</script>
@endpush