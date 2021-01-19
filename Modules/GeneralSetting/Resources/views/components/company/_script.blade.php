@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/generalsetting/company/';
        var tableId = '#company-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            searchDelay: 1500,
            ajax: {
                url: "{{ route('generalsetting.company.index') }}",
            },
            columns: [
                { data: 'code', name: 'Code', defaultContent: '-' },
                { data: 'name', 
                        "render": function ( data, type, row, meta ) {
                        return '<a href="company/' + row.id + '">' + row.name + '</a>';
                        } },
                { data: 'gst_number', name: 'GST Number', defaultContent: '-' },
                { data: 'npwp_number', name: 'NPWP', defaultContent: '-' },
                { data: 'description', name: 'Description/Remark', defaultContent: '-' },
                { data: 'is_customer', name: 'As Customer', defaultContent: '-' },
                { data: 'is_supplier', name: 'As Supplier', defaultContent: '-' },
                { data: 'is_manufacturer', name: 'As Manufacturer', defaultContent: '-' },
                { data: 'status', name: 'Status', defaultContent: '-' },
                { data: 'creator_name', name: 'Created By', defaultContent: '-' },
                { data: 'created_at', name: 'Created At', defaultContent: '-' },
                { data: 'updater_name', name: 'Last Updated By', defaultContent: '-' },
                { data: 'updated_at', name: 'Last Updated At', defaultContent: '-' },
                { data: 'action', name: 'Action', orderable: false },
            ]
        });



        // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
        $('#create').click(function () {
            showCreateModal ('Create New Company', inputFormId, actionUrl);
        });
        // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //



        // ----------------- "EDIT" BUTTON SCRIPT ------------- //
        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Company");
            $(inputFormId).trigger("reset");                
            rowId= $(this).val();
            let tr = $(this).closest('tr');
            let data = datatableObject.row(tr).data();
            $(inputFormId).attr('action', actionUrl + data.id);

            $('<input>').attr({
                type: 'hidden',
                name: '_method',
                value: 'patch'
            }).prependTo('#inputForm');

            $('#code').val(data.code);
            $('#name').val(data.name);
            $('#gst_number').val(data.gst_number);
            $('#npwp_number').val(data.npwp_number);
            $('#description').val(data.description);                
            if (data.status == '<label class="label label-success">Active</label>') {
                $('#status').prop('checked', true);
            }
            else {
                $('#status').prop('checked', false);
            }
            if (data.is_customer == '<label class="label label-success">Yes</label>') {
                $('#is_customer').prop('checked', true);
            }
            else {
                $('#is_customer').prop('checked', false);
            }
            if (data.is_supplier == '<label class="label label-success">Yes</label>') {
                $('#is_supplier').prop('checked', true);
            }
            else {
                $('#is_supplier').prop('checked', false);
            }
            if (data.is_manufacturer == '<label class="label label-success">Yes</label>') {
                $('#is_manufacturer').prop('checked', true);
            }
            else {
                $('#is_manufacturer').prop('checked', false);
            }

            $('#saveBtn').val("edit");
            $('[class^="invalid-feedback-"]').html('');
            $('#inputModal').modal('show');
        });
        // ----------------- END "EDIT" BUTTON SCRIPT ------------- //



        // ----------------- "SUBMIT FORM" BUTTON SCRIPT ------------- //
        $(inputFormId).on('submit', function (event) {
            submitButtonProcess (tableId, inputFormId); 
        });
        // ----------------- END "SUBMIT FORM" BUTTON SCRIPT ------------- //



        // ----------------- "DELETE" BUTTON  SCRIPT ------------- //
        deleteButtonProcess (datatableObject, tableId, actionUrl);
        // ----------------- END "DELETE" BUTTON  SCRIPT ------------- //



        // ----------------- PROFILE PICTURE UPLOAD SCRIPT ------------- //
        function getPict(input) {
        
            var filedata = input.files[0];
            let imgtype = filedata.type;
            let imgsize = filedata.size;

            let match=["image/jpeg", "image/jpg", "image/png"];

            if((imgtype != match[0]) && (imgtype != match[1]) && (imgtype != match[2])){
                swal({
                    title: "Upload image failed!",
                    text: "input file format only for: .jpeg, .jpg, .png !",
                    type: "error"
                });
            } else if((imgsize < 10000) || (imgsize > 1000000)){
                swal({
                    title: "Upload image failed!",
                    text: "input file size only between 10 KB - 1 MB !",
                    type: "error"
                });
            } else{
                // IMAGE PREVIEW
                var reader = new FileReader();

                reader.onload=function(ev){
                    $('#image_user').attr('src',ev.target.result);
                }
                reader.readAsDataURL(input.files[0]);

                // PROCESS UPLOAD
                var postData = new FormData();
                postData.append('file', input.files[0]);
                let url="/gate/user/upload-image";

                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $(
                            'meta[name="csrf-token"]'
                        ).attr("content")
                    },
                    url: url,
                    method: "POST",
                    async: true,
                    contentType: false,
                    cache: false,
                    data: postData,
                    processData:false,
                    beforeSend:function(){
                        $('#saveButton').html('<strong>Saving...</strong>');
                        $('#saveButton'). prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            swal({
                                title: "Image Uploaded!",
                                text: data.success,
                                type: "success"
                            });
                        }
                    },
                    error: function(data){
                        let html = '';
                        let errors = data.responseJSON.errors;
                        if (errors) {
                            let textError = '';
                            $.each(errors, function (index, value) {
                                textError += value;
                            });
                            swal({
                                title: "Failed to upload!",
                                text: textError,
                                type: "error"
                            });
                        }
                    },
                });
            }
        }
        // ----------------- END PROFILE PICTURE UPLOAD SCRIPT ------------- //
    });
</script>
@endpush