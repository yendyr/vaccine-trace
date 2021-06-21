<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ config('gate.name', 'Laravel') }} | Dashboard</title>

    <link rel="icon" type="image/png" href="{{ URL::asset('/ico.png') }}">
    <link href="{{ URL::asset('theme/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('theme/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('theme/css/animate.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('theme/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/custom.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('theme/css/login-style.css') }}" rel="stylesheet">
</head>

<body class="img js-fullheight bg-plane">
    <img class="absolute" src="{{URL::asset('theme/img/yems/smartaircraft logo putih.png')}}" alt="">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="row justify-content-center">
                        <div class="col col-lg-4">
                            <div class="login-wrap p-0">
                                <h3 class="mb-4 text-center">Reset Password</h3>
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token ?? null }}">

                                    <div class="form-group row">

                                        <div class="col">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="E-mail">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $email }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="form-group row">

                                        <div class="col">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <div class="col">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Password Confirmation">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <button type="submit" class="form-control btn btn-primary submit px-3">Reset Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>

    <!-- jQuery -->
    <script src="{{URL::asset('theme/js/jquery.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{URL::asset('theme/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- Main Bootstrap & Theme Engine -->
    <script src="{{URL::asset('theme/js/popper.min.js')}}"></script>
    <script src="{{URL::asset('theme/js/bootstrap.min.js')}}"></script>
    <script src="{{ URL::asset('theme/js/login.js') }}"></script>
</body>

</html>