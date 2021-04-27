@push('footer-scripts')
<script>
    // ----------------- UPLOAD SCRIPT ------------- //
    function getWorkOrderFile(input) {
        
        var filedata = input.files[0];
        let imgsize = filedata.size;

        if((imgsize < 10000) || (imgsize > 100000)) {
            swal.fire({
                title: "Upload Failed",
                text: "Size Must Between 10 KB - 100 KB !",
                icon: "error"
            });
        } 
        else {
            var postData = new FormData();
            var id = $('#work-orderFile').data('id');
            postData.append('file', input.files[0]);
            let url="{{ route('ppc.work-order.file-upload', ['work_order' => $work_order->id]) }}"

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content")
                },
                url: url,
                method: "post",
                async: true,
                contentType: false,
                cache: false,
                data: postData,
                processData:false,
                success:function(data){
                    if (data.success) {
                        swal.fire({
                            title: "File Uploaded",
                            text: data.success,
                            icon: "success"
                        });
                        setTimeout(location.reload.bind(location), 2000);
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
                        swal.fire({
                            title: "Upload Failed",
                            text: textError,
                            icon: "error"
                        });
                    }
                },
            });
        }
    }
    // ----------------- END UPLOAD SCRIPT ------------- //
</script>
@endpush