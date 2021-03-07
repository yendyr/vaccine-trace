<div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
            <div class="dropdown profile-element">
                <div class="image-upload">
                    <label for="file-input" style="cursor:pointer;" data-toggle="tooltip" title="Change picture">
                        <img id="image_user" alt="image" width="45px" class="rounded-circle" src="{{
                            isset(\Illuminate\Support\Facades\Auth::user()->image)
                            ? URL::asset('uploads/user/img/'.\Illuminate\Support\Facades\Auth::user()->image)
                            : URL::asset('assets/default-user-image.png')
                        }}"/>
                    </label>

                    <input onchange="getPict(this)" style="display: none;" id="file-input" type="file" name="upload_img"/>
                </div>

                <span class="block m-t-xs font-bold text-white">{{ Auth::user()->username }}</span>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span><small>{{ Auth::user()->name }}</small>&nbsp;<b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#" onclick="changePassword()">Change Password</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Logout</a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form></li>
                    </ul>
                </div>
                
            </div>
            <div class="logo-element">
                <img class="absolute2" src="{{URL::asset('theme/img/yems/asset-1.png')}}" alt="">
            </div>
        </li>
        <li class="{{ request()->is('dashboard*') ? 'active' : '' }}">
            <a href="{{ route('dashboard')}}"><i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard</span></a>
        </li>
        @include('layouts/includes/sidebar-item')
    </ul>
</div>

@push('footer-scripts')
<script>
function getPict(input){
    
    var filedata = input.files[0];
    let imgtype = filedata.type;
    let imgsize = filedata.size;

    let match=["image/jpeg", "image/jpg", "image/png"];

    if((imgtype != match[0]) && (imgtype != match[1]) && (imgtype != match[2])){
        swal.fire({
            title: "Upload Image Failed",
            text: "input file format only for: .jpeg, .jpg, .png !",
            icon: "error"
        });
    } else if((imgsize < 10000) || (imgsize > 100000)){
        swal.fire({
            title: "Upload Image Failed",
            text: "input file size only between 10 KB - 100 KB !",
            icon: "error"
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
                    swal.fire({
                        title: "Image Uploaded!",
                        text: data.success,
                        icon: "success"
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
                    swal.fire({
                        title: "Failed to upload!",
                        text: textError,
                        icon: "error"
                    });
                }
            },
        });
    }
}
</script>
@endpush