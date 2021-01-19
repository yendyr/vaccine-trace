@push('footer-scripts')
<script>
    // ----------------- PROFILE PICTURE UPLOAD SCRIPT ------------- //
    function getCompanyLogo(input) {
        
        var filedata = input.files[0];
        let imgtype = filedata.type;
        let imgsize = filedata.size;

        let match=["image/jpeg", "image/jpg", "image/png"];

        if((imgtype != match[0]) && (imgtype != match[1]) && (imgtype != match[2])){
            swal({
                title: "Upload Failed",
                text: "input file format only for: .jpeg, .jpg, .png !",
                type: "error"
            });
        } else if((imgsize < 10000) || (imgsize > 100000)){
            swal({
                title: "Upload Failed",
                text: "input file size only between 10 KB - 100 KB !",
                type: "error"
            });
        } else{
            // IMAGE PREVIEW
            var reader = new FileReader();

            reader.onload=function(ev){
                $('#companyLogo').attr('src',ev.target.result);
            }
            reader.readAsDataURL(input.files[0]);

            // PROCESS UPLOAD
            var postData = new FormData();
            var id = $('#logo-input').data('id');
            postData.append('file', input.files[0]);
            let url="/generalsetting/company/logo-upload/" + id;

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
                        swal({
                            title: "Image Uploaded",
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
                            title: "Upload Failed",
                            text: textError,
                            type: "error"
                        });
                    }
                },
            });
        }
    }
    // ----------------- END PROFILE PICTURE UPLOAD SCRIPT ------------- //
</script>
@endpush