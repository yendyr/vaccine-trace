
<div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
            <div class="dropdown profile-element">
                <div class="image-upload">
                    <label for="file-input" style="cursor:pointer;" data-toggle="tooltip" title="Change picture">
                        <img id="image_user" alt="image" width="45px" class="rounded-circle" src="{{
                            isset(\Illuminate\Support\Facades\Auth::user()->image)
                            ? URL::asset('uploads/user/img/'.\Illuminate\Support\Facades\Auth::user()->image)
                            : URL::asset('uploads/user/img/avatar.png')
                        }}"/>
                    </label>

                    <input onchange="getPict(this)" style="display: none;" id="file-input" type="file" name="upload_img"/>
                </div>

                <a class="dropdown-toggle" href="#">
                    <span class="block m-t-xs font-bold">{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
                </a>
                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                    <li><a class="dropdown-item" href="profile.html">Profile</a></li>
                    <li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
                    <li><a class="dropdown-item" href="mailbox.html">Mailbox</a></li>
                    <li class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="login.html">Logout</a></li>
                </ul>
            </div>
            <div class="logo-element">
                <img class="absolute2" src="{{URL::asset('theme/img/yems/asset-1.png')}}" alt="">
            </div>
        </li>
        <li class="{{ request()->is('dashboard*') ? 'active' : '' }}">
            <a href="{{ route('dashboard')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
        </li>
        <li>
            <div class="nav-label text-white p-3 mt-2">Modules</div>
        </li>
        <li class="{{ request()->is('gate/*') ? 'active' : '' }} nav-first-level" id="gate">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Tools</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                @can('viewAny', Modules\Gate\Entities\User::class)
                <li class="{{ (request()->is('gate/user') || request()->is('gate/user/*')) ? 'active' : '' }}">
                    <a href="{{ route('gate.user.index')}}">
                        <div class="nav-second-table-group">
                            <span>
                                <i class="fa fa-user-circle-o"></i>
                            </span>
                            <span>
                                User
                            </span>
                        </div>
                     </a>
{{--                    <ul class="nav nav-second-level">--}}
{{--                        <li class="{{ request()->is('gate/user*') ? 'active' : '' }}"><a href="{{ route('gate.user.index')}}">Data</a></li>--}}
{{--                    </ul>--}}
                </li>
                @endcan
                @can('viewAny', Modules\Gate\Entities\Company::class)
                    <li class=" {{ (request()->is('gate/company') || request()->is('gate/company/*')) ? 'active' : '' }}">
                        <a href="{{ route('gate.company.index')}}">
                            <div class="nav-second-table-group">
                                <span>
                                    <i class="fa fa-building-o"></i>
                                </span>
                                <span>
                                    Company
                                </span>
                            </div>
                        </a>
                    </li>
                @endcan
                @can('viewAny', Modules\Gate\Entities\Role::class)
                    <li class="{{ (request()->is('gate/role') || request()->is('gate/role/*')) ? 'active' : '' }}">
                        <a href="{{route('gate.role.index')}}">
                            <div class="nav-second-table-group">
                                <span >
                                    <i class="fa fa-users"></i>
                                </span>
                                <span >
                                    Role
                                </span>
                            </div>
                        </a>
                    </li>
                @endcan
                @can('viewAny', Modules\Gate\Entities\RoleMenu::class)
                    <li class="{{ (request()->is('gate/role-menu') || request()->is('gate/role-menu/*')) ? 'active' : '' }}">
                        <a href="{{route('gate.role-menu.index')}}">
                            <div class="nav-second-table-group">
                                <span>
                                    <i class="fa fa-list-alt"></i>
                                </span>
                                <span>
                                    Role Menu
                                </span>
                            </div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>

        <li class="{{ request()->is('examples/*') ? 'active' : '' }} nav-first-level" id="examples">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Examples</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                @can('viewAny', \Modules\Examples\Entities\Example::class)
                <li class="{{ (request()->is('examples/example') || request()->is('examples/example/*')) ? 'active' : '' }}">
                    <a href="{{ route('examples.example.index')}}">
                        <div class="nav-second-table-group">
                            <span>
                                <i class="fa fa-plus"></i>
                            </span>
                            <span>
                                Approval Example
                            </span>
                        </div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>

        <li class="{{ request()->is('hr/*') ? 'active' : '' }} nav-first-level" id="humanresources">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Human Resources</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                @can('viewAny', \Modules\HumanResources\Entities\OrganizationStructure::class)
                    <li class="{{ (request()->is('hr/org-structure') || request()->is('hr/org-structure/*')) ? 'active' : '' }}">
                        <a href="{{ route('hr.org-structure.index')}}">
                            <div class="nav-second-table-group">
                                <span>
                                    <i class="fa fa-plus"></i>
                                </span>
                                <span>
                                    Organization Structure
                                </span>
                            </div>
                        </a>
                    </li>
                @endcan
                @can('viewAny', \Modules\HumanResources\Entities\WorkingGroup::class)
                    <li class="{{ (request()->is('hr/workgroup') || request()->is('hr/workgroup/*')) ? 'active' : '' }}">
                        <a href="{{ route('hr.workgroup.index')}}">
                            <div class="nav-second-table-group">
                                <span>
                                    <i class="fa fa-plus"></i>
                                </span>
                                <span>
                                    Working Group
                                </span>
                            </div>
                        </a>
                    </li>
                @endcan
                @can('viewAny', \Modules\HumanResources\Entities\Holiday::class)
                    <li class="{{ (request()->is('hr/holiday') || request()->is('hr/holiday/*')) ? 'active' : '' }}">
                        <a href="{{ route('hr.holiday.index')}}">
                            <div class="nav-second-table-group">
                                <span>
                                    <i class="fa fa-plus"></i>
                                </span>
                                <span>
                                    Holiday
                                </span>
                            </div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    </ul>
</div>

@push('footer-scripts')
    <script>
        function getPict(input){
            console.log(input)
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


        $(document).ready(function(){
            var nav1 = $('li#gate ul').children().length;
            if (nav1 == 0){
                $('li#gate').remove();
            }
            var nav2 = $('li#examples ul').children().length;
            if (nav2 == 0){
                $('li#examples').remove();
            }
            var nav4 = $('li#humanresources ul').children().length;
            if (nav4 == 0){
                $('li#humanresources').remove();
            }
        });
    </script>
@endpush
