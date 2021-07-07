<div class="navbar-header">
    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
    {{-- <form role="search" class="navbar-form-custom" action="search_results.html">
        <div class="form-group">
            <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
        </div>
    </form> --}}
</div>
<ul class="nav navbar-top-links navbar-right">
    <li>
        <span class="m-r-sm welcome-message">Welcome to {{ config('app.name') }}</span>
    </li>
    {{-- <li>
        <span class="m-r-sm welcome-message">
            <img src={{URL::asset('/Logo-Web.png')}} height="40px">
        </span>
    </li> --}}
    <li>
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            @include('gate::components.user.passwordModal')

            {{-- <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->username }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a class="passwordBtn dropdown-item" onclick="changePassword()">
                        Change Password
                    </a>
                </div>

            </li> --}}
        @endguest
    </li>
</ul>

@push('footer-scripts')
<script>
    function changePassword(){
        $('#userPasswordModal').modal('show');
        $('#user-password-form').attr('action', "/gate/user/change-password");
        $('#passwordModalTitle').html("Change Password");
    }

    $(document).ready(function () {
        $('#savePassBtn').on('click', function (event) {
            event.preventDefault();
            $('div[class^="invalid-feedback-"]').html('');
            let url_action = $('#user-password-form').attr('action');
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content")
                },
                url: url_action,
                method: "POST",
                data: $('#user-password-form').serialize(),
                dataType: 'json',
                beforeSend:function(){
                    $('#savePassBtn').html('<strong>Saving...</strong>');
                    $('#savePassBtn').prop('disabled', true);
                },
                error: function(data){
                    let html = '';
                    let errors = data.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function (index, value) {
                            $('div.invalid-feedback-'+index).html(value);
                        })
                    }
                },
                success:function(data){
                    $('#userPasswordModal').modal('hide');
                    $('#user-password-form').trigger("reset");
                    if (data.success) {
                        swal.fire({
                            title: "Password changed!",
                            text: data.success,
                            icon: "success"
                        });
                    }
                },
                complete:function(){
                    $('#savePassBtn').prop('disabled', false);
                    $('#savePassBtn').html('<strong>Save password</strong>');
                }
            });
        });
    })
</script>
@endpush
