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
                        <div class="col-md-6 col-lg-4">
                            <div class="login-wrap p-0">
                                <h3 class="mb-4 text-center">Reset Password</h3>
                                @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                                @endif

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="form-group">
                                        <input type="email" class="form-control @error('login') is-invalid @enderror" name="login" required autofocus placeholder="Email Address">
                                        @error('login')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <button type="submit" class="form-control btn btn-primary submit px-3">Send Password Reset Link</button>
                                    </div>

                                </form>
                            </div>
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